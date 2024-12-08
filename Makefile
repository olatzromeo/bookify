help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

UID = $(shell id -u)
PHP_CONTAINER = clean-architecture-symfony7_php
NGINX_CONTAINER = clean-architecture-symfony7_nginx
DOCKER_COMPOSE = cd docker && U_ID=${UID} docker compose
SSH_PHP = docker exec -it $(PHP_CONTAINER) bash
SSH_NGINX = docker exec -it $(NGINX_CONTAINER) sh
EXEC = $(DOCKER_COMPOSE) exec
EXEC_PHP = docker exec $(PHP_CONTAINER)

build: ## Execute a fresh build
	$(DOCKER_COMPOSE) build --build-arg UID=$(UID) --no-cache

install: ## Install the docker stack
	make build
	make start

uninstall: ## Uninstall the docker stack
	make stop
	$(DOCKER_COMPOSE) kill
	$(DOCKER_COMPOSE) down --volumes --remove-orphans

restart: ## Restart all docker containers
	make stop
	make start

start: ## Start the project
	$(DOCKER_COMPOSE) up -d --remove-orphans --no-recreate

stop: ## Stop the project
	$(DOCKER_COMPOSE) stop

ssh: ## Access to php container
	$(SSH_PHP)

ssh-nginx: ## Access to nginx container
	$(SSH_NGINX)

cc:
	$(EXEC_PHP) bin/console cache:clear
