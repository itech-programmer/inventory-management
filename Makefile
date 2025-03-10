APP_CONTAINER := backend
DB_CONTAINER := db
ENV_FILE := .env

.PHONY: start up down restart logs bash migrate seed install test artisan composer

start:
	@test -f $(ENV_FILE) || cp .env.example $(ENV_FILE)
	@docker-compose up -d --build
	@docker-compose exec $(APP_CONTAINER) composer install
	@docker-compose exec $(APP_CONTAINER) php artisan migrate
	@docker-compose exec $(APP_CONTAINER) php artisan db:seed

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

optimize:
	docker-compose run --rm app php artisan config:cache && \
	docker-compose run --rm app php artisan route:cache && \
	docker-compose run --rm app php artisan view:cache

cache-clear:
	docker-compose run --rm app php artisan cache:clear && \
	docker-compose run --rm app php artisan config:clear && \
	docker-compose run --rm app php artisan route:clear && \
	docker-compose run --rm app php artisan view:clear