build-backend-php:
	docker build --target=deployment -t backend-php -f backend/docker/php-fpm/Dockerfile ./backend/

start:
	docker-compose up -d

stop:
	docker-compose kill

init: stop clean
	cd ./frontend; yarn install
	cd ./admin; yarn install
	composer -o install --working-dir backend/
	make start
	cd ./backend; ./console doctrine:schema:update --force; ./console doctrine:fixtures:load -n

clean: stop
	docker-compose rm -f
	cd ./frontend; sudo rm -rf node_modules
	cd ./admin; sudo rm -rf node_modules
