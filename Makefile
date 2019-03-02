build-backend-php:
	docker build --target=deployment -t backend-php -f backend/docker/php-fpm/Dockerfile ./backend/
