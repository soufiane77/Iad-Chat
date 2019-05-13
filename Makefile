DOCKER_COMPOSE 		= docker-compose
EXEC_PHP 			= $(DOCKER_COMPOSE) exec iad-chat_php_1 php
COMPOSER_PHP 		= $(EXEC_PHP) composer

install:
	make start
	make vendors

vendors:
	$(COMPOSER_PHP) install

start:
	$(DOCKER_COMPOSE) up --build


clean:
	$(DOCKER_COMPOSE) down --rmi all
