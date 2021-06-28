SHELL=/bin/bash
MKCERT_VERSION=v1.3.0
MKCERT_LOCATION=$(PWD)/bin/mkcert
SITE_HOST=phpdocker.local
PHP_RUN=docker-compose run --rm php-fpm

ifndef BUILD_TAG
	BUILD_TAG:=$(shell date +'%Y-%m-%d-%H-%M-%S')-$(shell git rev-parse --short HEAD)
endif

# linux-amd64, darwin-amd64, linux-arm
# On windows, override with windows-amd64.exe
ifndef BINARY_SUFFIX
	BINARY_SUFFIX:=$(shell [[ "`uname -s`" == "Linux" ]] && echo linux || echo darwin)-amd64
endif

ifndef BINARY_ARCH
	BUILD_TAG:=$(shell date +'%Y-%m-%d-%H-%M-%S')-$(shell git rev-parse --short HEAD)
endif

echo-build-tag:
	echo $(BUILD_TAG)

start:
	docker-compose up -d --scale php-fpm=2

stop:
	docker-compose stop

shell:
	docker-compose exec php-fpm bash

init: clean install-mkcert create-certs clean-hosts init-hosts install-dependencies install-assets-dev fix-permissions fix-cache-permissions-dev start

clean: clear-cache
	docker-compose down
	sudo rm -rf vendor
	make clear-cache

fix-permissions:
	sudo chown -Rf $(shell id -u):$(shell id -g) .
	sudo chown -Rf $(shell id -u):$(shell id -g) ~/.cache/composer

fix-cache-permissions-dev:
	sudo chmod -Rf 777 var/*

clear-cache:
	$(PHP_RUN) rm var/* -rf

install-assets-dev:
	mkdir -p web/bundles web/css web/js
	$(PHP_RUN) bin/console assets:install --symlink --relative

composer-install:
	$(PHP_RUN) composer -o install

bower-install:
	docker run  \
	    --rm \
	    -it \
	    -v "`pwd`:/workdir" \
	    -w /workdir \
	    node:alpine \
	    sh -c "apk update; apk add git; npm i -g bower; bower install --allow-root"

install-dependencies: composer-install bower-install

composer-update:
	$(PHP_RUN) composer update --no-scripts
	make composer-install

install-mkcert:
	@echo "Installing mkcert for OS type ${BINARY_SUFFIX}"
	@if [[ ! -f '$(MKCERT_LOCATION)' ]]; then curl -sL 'https://github.com/FiloSottile/mkcert/releases/download/$(MKCERT_VERSION)/mkcert-$(MKCERT_VERSION)-$(BINARY_SUFFIX)' -o $(MKCERT_LOCATION); chmod +x $(MKCERT_LOCATION);	fi;
	bin/mkcert -install

create-certs:
	bin/mkcert -cert-file=infrastructure/local/localhost.pem -key-file=infrastructure/local/localhost-key.pem $(SITE_HOST)

clean-hosts:
	sudo bin/hosts remove --force *$(SITE_HOST) > /dev/null 2>&1 || exit 0

init-hosts: clean-hosts
	sudo bin/hosts add 127.0.0.1 $(SITE_HOST)

open-frontend:
	xdg-open https://$(SITE_HOST):10000

### Tests
prep-ci: install-dependencies install-assets-dev fix-permissions fix-cache-permissions-dev start

behaviour:
	$(PHP_RUN) vendor/bin/behat

### Deployment targets

build-images:
	docker build --pull --target=backend-deployment  -t phpdocker-old-php-fpm .
	docker build --pull --target=frontend-deployment -t phpdocker-old-nginx   .

tag-images:
	docker tag phpdocker-old-nginx eu.gcr.io/auron-infrastructure/phpdocker-old-nginx:$(BUILD_TAG)
	docker tag phpdocker-old-php-fpm eu.gcr.io/auron-infrastructure/phpdocker-old-php-fpm:$(BUILD_TAG)

push-images:
	docker push eu.gcr.io/auron-infrastructure/phpdocker-old-nginx:$(BUILD_TAG)
	docker push eu.gcr.io/auron-infrastructure/phpdocker-old-php-fpm:$(BUILD_TAG)

build-and-push: build-images tag-images push-images

deploy:
	cp infrastructure/kubernetes/deployment.yaml /tmp/phpdocker-deployment-$(BUILD_TAG).yaml
	sed -i "s/latest/$(BUILD_TAG)/g" /tmp/phpdocker-deployment-$(BUILD_TAG).yaml

	kubectl apply -f /tmp/phpdocker-deployment-$(BUILD_TAG).yaml
	rm /tmp/phpdocker-deployment-$(BUILD_TAG).yaml

rollback:
	kubectl rollout undo deployment.v1.apps/phpdocker-io-old
