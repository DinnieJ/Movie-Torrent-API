up:
	docker-compose up

up-daemon:
	docker-compose up -d

down:
	docker-compose down

status:
	docker-compose ps

build:
	cp .env.development .env
	docker-compose build
	docker-compose exec api composer install
	docker-compose exec api php artisan migrate
	docker-compose exec api php artisan key:generate
	docker-compose exec api php artisan jwt:secret
	docker-compose exec api composer dump-autoload

tinker:
	docker-compose exec api php artisan tinker

db:
	docker-compose exec mysql mysql -uroot -proot
