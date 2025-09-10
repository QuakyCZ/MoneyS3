up:
	cd docker && docker compose up --build -d

down:
	cd docker && docker compose down

install: up
	docker exec -it eproduct-moneys3 composer install

update: up
	docker exec -it eproduct-moneys3 composer update

phpstan ps: install
	docker exec -it eproduct-moneys3 vendor/bin/phpstan analyse -c phpstan.neon src

phpcsfixed csf: install
	docker exec -it eproduct-moneys3 vendor/bin/php-cs-fixer fix --cache-file temp/php-cs-fixer.cache src


test: install
	docker exec -it eproduct-moneys3 vendor/bin/phpunit --colors=always --testdox tests


bash b: install
	docker exec -it eproduct-moneys3 bash