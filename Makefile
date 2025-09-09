up:
	cd docker && docker compose up --build -d

down:
	cd docker && docker compose down

install: up
	docker exec -it eproduct-moneys3 composer install

update: up
	docker exec -it eproduct-moneys3 composer update

phpstan ps: up
	docker exec -it eproduct-moneys3 vendor/bin/phpstan analyse -c phpstan.neon src tests

test: up
	docker exec -it eproduct-moneys3 vendor/bin/phpunit --colors=always --testdox tests

