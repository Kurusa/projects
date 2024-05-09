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
seed:
	docker-compose exec app php artisan db:seed
swagger:
	docker-compose exec app php artisan l5-swagger:generate
shell:
	docker-compose exec app sh
composer-install:
	docker-compose exec app composer install
