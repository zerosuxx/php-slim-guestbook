default: help

build: ## Build docker compose
	@docker-compose build

up: ## Start containers
	docker-compose up

upd: ## Start containers in background
	docker-compose up -d

destroy: ## Destroys containers
	docker-compose down

stop: ## Stops containers
	docker-compose stop

help: ## This help message
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' -e 's/:.*#/: #/' | column -t -s '##'

ssh: ## SSH into web server container
	docker-compose exec gbweb /bin/bash

ssh-test: ## SSH into web server container
	docker-compose run gbtest /bin/bash

phpunit: ## SSH into test web server container and run tests
	docker-compose run gbtest /bin/bash -l -c "vendor/bin/phpunit --testdox --coverage-html coverage --coverage-clover clover.xml"

mysql: ## Opens mysql cli
	docker-compose exec mysql mysql -u guestbook -pguestbook

composer-install: ## Runs composer install for sample_project
	docker-compose run gbtest /bin/bash -l -c "composer install && vendor/bin/phinx migrate -e development -e testing"

migrate-dbs: ## Migrates databases
	docker-compose exec gbweb /bin/bash -l -c "php vendor/bin/phinx migrate -e development && php vendor/bin/phinx migrate -e testing"

seed-dbs: ## Migrates databases
	docker-compose exec gbweb /bin/bash -l -c "php vendor/bin/phinx seed:run -e development && php vendor/bin/phinx seed:run -e testing"

install: destroy build up composer-install migrate-dbs seed-dbs

init-test: ## Init for testing
	(docker network create gb-net) && docker-compose pull mysql && docker-compose pull gbtest && docker-compose up -d mysql && make composer-install