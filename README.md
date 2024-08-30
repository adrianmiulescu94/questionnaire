# Questionnaire Home Assignment for Manual


A symfony project using Api Platform.

The URL is https://127.0.0.1/api or https://dev.questionnaire/api

## Local environment setup:
* `cp ./docker/.env.dist ./docker/.env`
* `cp .env .env.local`
* modify the envs according to your needs
* lets start the docker env:
  * `cd ./docker`
  * `docker compose up --build -d`
  * `docker exec -it questionnaire_php_fpm /bin/sh` to connect to fpm container
* run `composer install`
* run `bin/console doctrine:migrations:migrate`
* run `bin/console doctrine:fixtures:load`
* run `bin/console --env=test doctrine:database:create`
* run `bin/console --env=test doctrine:schema:create`
* run `bin/console --env=test doctrine:fixtures:load`
* run `bin/phpunit` to execute the unit tests

## Things I would do to improve this project:
* add created, updated and maybe status columns to tables (created & updated via lifecycles)
* modify each migration which adds a new column to add the column after a specified column (in order to have at the end of the table the created & modified columns)
* clear a little bit all the APIs exposed automatically by Api Platform
* maybe use a state processor instead of a controller (debatable)
* little refactor: use more constants, add missing parameter types, return types, etc
* add api rate limiter and configure the CORS
* add memcache to return the questions from caching instead of querying the database every time
