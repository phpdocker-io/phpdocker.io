SHELL=/bin/bash
MKCERT_VERSION=v1.4.1
MKCERT_LOCATION=$(PWD)/bin/mkcert
PHPDOCKER_HOST=phpdocker.local

# linux-amd64, darwin-amd64, linux-arm
# On windows, override with windows-amd64.exe
ifndef BINARY_SUFFIX
	BINARY_SUFFIX:=$(shell [[ "`uname -s`" == "Linux" ]] && echo linux || echo darwin)-amd64
endif

ifndef BINARY_ARCH
	BUILD_TAG:=$(shell date +'%Y-%m-%d-%H-%M-%S')-$(shell git rev-parse --short HEAD)
endif

build-backend-php:
	docker build --target=deployment -t backend-php -f backend/docker/php-fpm/Dockerfile ./backend/

start:
	docker-compose up -d

stop:
	docker-compose stop

install-dependencies:
	cd ./frontend; yarn install
	cd ./admin; yarn install
	docker-compose run --rm php-fpm composer -o install

install-mkcert:
	@echo "Installing mkcert for OS type ${BINARY_SUFFIX}"
	@if [[ ! -f '$(MKCERT_LOCATION)' ]]; then curl -sL 'https://github.com/FiloSottile/mkcert/releases/download/$(MKCERT_VERSION)/mkcert-$(MKCERT_VERSION)-$(BINARY_SUFFIX)' -o $(MKCERT_LOCATION); chmod +x $(MKCERT_LOCATION);	fi;
	bin/mkcert -install

create-certs:
	bin/mkcert -cert-file=infrastructure/local/local.pem -key-file=infrastructure/local/local.key.pem $(PHPDOCKER_HOST)
	cp infrastructure/local/local.pem infrastructure/local/webpack.pem
	cat infrastructure/local/local.key.pem >> infrastructure/local/webpack.pem

clean-hosts:
	sudo bin/hosts remove --force *phpdocker.local > /dev/null 2>&1 || exit 0

init-hosts: clean-hosts
	sudo bin/hosts add 127.0.0.1 $(PHPDOCKER_HOST)

init: clean install-dependencies install-mkcert create-certs init-hosts start load-fixtures

clean:
	docker-compose down
	cd ./frontend; sudo rm -rf node_modules
	cd ./admin; sudo rm -rf node_modules

load-fixtures:
	docker-compose exec database backend/bin/wait-for-db.sh
	cd ./backend; chmod 777 var/* -Rf; ./console doctrine:schema:update --force; ./console doctrine:fixtures:load -n

open-frontend:
	xdg-open https://phpdocker.local:5000

open-admin:
	xdg-open https://phpdocker.local:5001

open-content-api:
	xdg-open https://phpdocker.local:5002/content

open-mailhog:
	xdg-open https://phpdocker.local:5003/

open-api-profiler:
	xdg-open https://phpdocker.local:5002/_profiler/latest?limit=10

api-clear-cache:
	docker-compose exec php-fpm bin/console cache:clear

test-frontend-watch:
	cd frontend; yarn test

test-frontend:
	cd frontend; yarn test --no-watch --coverage

test-backend-static:
	cd backend; vendor/bin/phpstan -v analyse -l 7 src/

test-backend-infection:
	cd backend; vendor/bin/infection  --threads=4 -s

test-backend-infection-no-initial-coverage:
	cd backend; vendor/bin/infection  --threads=4 -s --coverage=reports/infection/
