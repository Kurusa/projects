up:
	docker-compose up -d
install:
	docker-compose stop
	docker-compose rm -fv
	docker-compose up --build -d --remove-orphans
stop:
	docker-compose stop
migrate:
	docker-compose exec app php artisan migrate:fresh --force --seed
	docker-compose exec app php artisan passport:install
seed:
	docker-compose exec app php artisan db:seed
test:
	docker-compose exec app ./vendor/bin/phpunit --stop-on-failure
shell:
	docker-compose exec app sh
composer-install:
	docker-compose exec app composer install
