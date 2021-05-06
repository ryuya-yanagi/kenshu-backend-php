init:
	make build && make up && make composer-install && mkdir -p htdocs/public/uploads
build:
	docker-compose build
up:
	docker-compose up -d
down:
	docker-compose down
composer-install:
	docker exec kenshu-php composer install
dump-autoload:
	docker exec kenshu-php composer dump-autoload