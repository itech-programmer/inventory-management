APP_CONTAINER := backend
DB_CONTAINER := db
ENV_FILE := .env

.PHONY: up down restart logs bash migrate seed install test artisan composer

up:
	docker-compose up -d --build

down:
	docker-compose down

restart:
	docker-compose down && docker-compose up -d --build

logs:
	docker-compose logs -f

bash:
	docker exec -it $(APP_CONTAINER) bash

migrate:
	docker exec -it $(APP_CONTAINER) php artisan migrate

seed:
	docker exec -it $(APP_CONTAINER) php artisan db:seed

install:
	docker exec -it $(APP_CONTAINER) composer install

test:
	docker exec -it $(APP_CONTAINER) php artisan test

artisan:
	docker exec -it $(APP_CONTAINER) php artisan $(cmd)

composer:
	docker exec -it $(APP_CONTAINER) composer $(cmd)
