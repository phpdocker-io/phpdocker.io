SHELL=/bin/bash
MKCERT_VERSION=v1.4.3
MKCERT_LOCATION=bin/mkcert
HOSTS_VERSION=3.6.4
HOSTS_LOCATION=bin/hosts
SITE_HOST=phpdocker.local
PHP_RUN=docker compose run -e XDEBUG_MODE=coverage --rm php-fpm

# Integrity data for the binaries downloaded below. Upstream publishes no checksum
# for the mkcert v1.4.3 release assets (the GitHub release API reports
# "digest": null for each of them), so these SHA-256 values were computed locally
# from the assets downloaded over HTTPS from the official release URLs on
# 2026-09-25. The windows-amd64.exe value is independently corroborated by the
# mkcert 1.4.3 Chocolatey package (tools/mkcert.exe, published 2020-11-26), which
# contains the same bytes. hosts is fetched from the commit the 3.6.4 tag points at
# (9a929dc70fa11bfe6dc5b0f1d53aea442395edd3) and was hashed on 2026-09-25. If an
# asset is ever republished, update its URL and its hash in the same commit.
MKCERT_SHA256_linux-amd64=c2b0746528588d2a5dabe7c4394a848909da07e23ca3f2393375e9baa3931649
MKCERT_SHA256_darwin-amd64=0b5bd40ea69ec34c567707249938bcd0502d2c3efc0137143a076a2b80d5e882
MKCERT_SHA256_linux-arm=b982ade61b6781f17afc210914116d8078af3ebb631facd28a944033018d41d2
MKCERT_SHA256_linux-arm64=43c4e3b9e7e6466d397b3d6e221788f83b5b91f826f1040240dbaddfc101ce33
MKCERT_SHA256_windows-amd64.exe=9dc25f7d1ae0be93db81aa42f3abfd62d13725dfd48969c9fe94b6af57e5573c
HOSTS_COMMIT=9a929dc70fa11bfe6dc5b0f1d53aea442395edd3
HOSTS_SHA256=eee51960ec8dd30e00090779ba79f11410396e69ac7812b0ad99f5b597c8c36e

# sha256sum on Linux, shasum on macOS
SHA256_CMD=$(shell command -v sha256sum >/dev/null 2>&1 && echo sha256sum || echo 'shasum -a 256')

INFECTION_THREADS?=8
BUILD_TAG?:=$(shell date +'%Y-%m-%d-%H-%M-%S')-$(shell git rev-parse --short HEAD)

# linux-amd64, darwin-amd64, linux-arm, linux-arm64
# On windows, override with windows-amd64.exe
ifndef BINARY_SUFFIX
	BINARY_SUFFIX:=$(shell [[ "`uname -s`" == "Linux" ]] && echo linux || echo darwin)-amd64
endif

# Resolved from BINARY_SUFFIX; an unsupported suffix yields an empty value, which
# fails verification instead of skipping it.
MKCERT_SHA256=$(MKCERT_SHA256_$(BINARY_SUFFIX))

ifndef BUILD_TAG
	BUILD_TAG:=$(shell date +'%Y-%m-%d-%H-%M-%S')-$(shell git rev-parse --short HEAD)
endif

echo-build-tag:
	echo $(BUILD_TAG)
	sleep 3

echo-build-tag-2:
	echo $(BUILD_TAG)

start:
	docker compose up -d --scale php-fpm=2

stop:
	docker compose stop

shell:
	$(PHP_RUN) bash

init: clean install-mkcert create-certs install-hosts clean-hosts init-hosts build-local install-dependencies install-assets-dev fix-permissions fix-cache-permissions-dev start

clean: clear-cache
	docker compose down
	sudo rm -rf vendor
	make clear-cache

build-local:
	docker compose build

fix-permissions:
	sudo chown -Rf $(shell id -u):$(shell id -g) .
	sudo chown -Rf $(shell id -u):$(shell id -g) ~/.cache/composer

fix-cache-permissions-dev:
	sudo chmod -Rf 777 var/*

clear-cache:
	$(PHP_RUN) rm var/* -rf

install-assets-dev:
	$(PHP_RUN) bin/console assets:install --symlink --relative

composer-install:
	$(PHP_RUN) composer -o install

npm-install:
	docker run  \
	    --rm \
	    -t \
	    -v "`pwd`:/workdir" \
	    -w /workdir \
	    node:alpine \
	    npm ci

build-css:
	docker run \
	    --rm \
	    -t \
	    -v "`pwd`:/workdir" \
	    -w /workdir \
	    node:alpine \
	    sh -c "npm ci && npm run build:css"

install-dependencies: composer-install npm-install build-css

composer-update:
	$(PHP_RUN) composer update --no-scripts
	make composer-install

install-mkcert: verify-mkcert
	chmod +x $(MKCERT_LOCATION)
	bin/mkcert -install

download-mkcert:
	@echo "Installing mkcert for OS type ${BINARY_SUFFIX}"
	@if [[ ! -f '$(MKCERT_LOCATION)' ]]; then \
		curl -fsSL --retry 3 -o '$(MKCERT_LOCATION).tmp' 'https://github.com/FiloSottile/mkcert/releases/download/$(MKCERT_VERSION)/mkcert-$(MKCERT_VERSION)-$(BINARY_SUFFIX)' || { rm -f '$(MKCERT_LOCATION).tmp'; exit 1; }; \
		mv '$(MKCERT_LOCATION).tmp' '$(MKCERT_LOCATION)'; \
	fi

verify-mkcert: download-mkcert
	@if [[ ! -f '$(MKCERT_LOCATION)' ]]; then \
		echo "Missing $(MKCERT_LOCATION); refusing to run it"; \
		exit 1; \
	fi; \
	if [[ -z '$(MKCERT_SHA256)' ]]; then \
		echo "No pinned SHA-256 for BINARY_SUFFIX '$(BINARY_SUFFIX)'; refusing to run $(MKCERT_LOCATION)"; \
		exit 1; \
	fi; \
	actual="$$($(SHA256_CMD) '$(MKCERT_LOCATION)' | awk '{print $$1}')"; \
	if [[ "$$actual" != '$(MKCERT_SHA256)' ]]; then \
		echo "SHA-256 mismatch for $(MKCERT_LOCATION): expected '$(MKCERT_SHA256)', got '$$actual'"; \
		exit 1; \
	fi

create-certs: verify-mkcert
	bin/mkcert -cert-file=infrastructure/local/localhost.pem -key-file=infrastructure/local/localhost-key.pem $(SITE_HOST)

install-hosts: verify-hosts
	chmod +x $(HOSTS_LOCATION)

download-hosts:
	@echo "Installing hosts script ($(HOSTS_VERSION))"
	@if [[ ! -f '$(HOSTS_LOCATION)' ]]; then \
		curl -fsSL --retry 3 -o '$(HOSTS_LOCATION).tmp' 'https://raw.githubusercontent.com/xwmx/hosts/$(HOSTS_COMMIT)/hosts' || { rm -f '$(HOSTS_LOCATION).tmp'; exit 1; }; \
		mv '$(HOSTS_LOCATION).tmp' '$(HOSTS_LOCATION)'; \
	fi

verify-hosts: download-hosts
	@if [[ ! -f '$(HOSTS_LOCATION)' ]]; then \
		echo "Missing $(HOSTS_LOCATION); refusing to run it"; \
		exit 1; \
	fi; \
	actual="$$($(SHA256_CMD) '$(HOSTS_LOCATION)' | awk '{print $$1}')"; \
	if [[ "$$actual" != '$(HOSTS_SHA256)' ]]; then \
		echo "SHA-256 mismatch for $(HOSTS_LOCATION): expected '$(HOSTS_SHA256)', got '$$actual'"; \
		exit 1; \
	fi

clean-hosts: verify-hosts
	sudo bin/hosts remove --force *$(SITE_HOST) > /dev/null 2>&1 || exit 0

init-hosts: clean-hosts
	sudo bin/hosts add 127.0.0.1 $(SITE_HOST)

open-frontend:
	xdg-open https://$(SITE_HOST):10000

### Tests & ci
prep-ci: composer-install fix-permissions fix-cache-permissions-dev

composer-cache-dir:
	@composer config cache-files-dir

static-analysis:
	$(PHP_RUN) vendor/bin/phpstan --ansi -v analyse -l 9 src

unit-tests:
	$(PHP_RUN) vendor/bin/phpunit --no-coverage --testdox --colors=always

coverage-tests:
	$(PHP_RUN) php -d zend_extension=xdebug.so vendor/bin/phpunit --testdox --colors=always

open-coverage-report:
	xdg-open reports/phpunit/index.html

### Deployment targets
PHP_CONTAINER=phpdockerio/site-php
NGX_CONTAINER=phpdockerio/site-ngx
CONTAINER_ARCH=linux/amd64
build-and-push:
	docker buildx build --target=backend-deployment  --tag $(PHP_CONTAINER):$(BUILD_TAG) --tag $(PHP_CONTAINER):latest --platform $(CONTAINER_ARCH) --pull --push .
	docker buildx build --target=frontend-deployment --tag $(NGX_CONTAINER):$(BUILD_TAG) --tag $(NGX_CONTAINER):latest --platform $(CONTAINER_ARCH) --pull --push .

deploy:
	cp infrastructure/kubernetes/deployment.yaml /tmp/phpdocker-deployment-$(BUILD_TAG).yaml
	sed -i "s/latest/$(BUILD_TAG)/g" /tmp/phpdocker-deployment-$(BUILD_TAG).yaml

	kubectl apply -f /tmp/phpdocker-deployment-$(BUILD_TAG).yaml
	rm /tmp/phpdocker-deployment-$(BUILD_TAG).yaml

rollback:
	kubectl rollout undo deployment.v1.apps/phpdocker
