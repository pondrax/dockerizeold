# Dockerize
Docker Compose to run lumen API

## Overview

Built in latest lumen 8, with fast and extensible services

It exposes services:

* web (nginx:1.19-alpine)
* php (hermsi/alpine-fpm-php:7.4) 
* db (postgres:11.1-alpine)
* composer

## Install prerequisites

For now the project has been tested on Linux only but should run fine on Docker for Windows and Docker for Mac.

You will need:

* [Docker CE](https://docs.docker.com/engine/installation/)
* [Docker Compose](https://docs.docker.com/compose/install)
* Git (optional)

## How to use it

### Starting App with stack

Checkout the repository or download the sources.

Before start, be sure to copy .env.example to .env on the root directory

Simply run `./stack generate` and you are done. All of the lumen dependency will be automatically installed

The app will be available on `localhost:8080` and PostgreSQL on `localhost:5434`


### Using Stack

Some of stack shortcut instead of using docker-compose. Be surre to add this script to executable mode `chmod +x stack`

	- `./stack generate` 
		Build, generate config needed then run service on background
		
	- `./stack generateonly` 
		Generate config needed to run well
		
	- `./stack build` 
		Build only
	
	- `./stack start` 
		Start the service
		
	- `./stack stop` 
		Stop the service
		
	- `./stack artisan <cmd>` 
		Simple shortcut to execute lumen artisan
		
	- `./stack composer <cmd>` 
		Simple shortcut to execute composer
		
	- `./stack sh` 
		Run inside docker-compose interactively
		
	- `./stack <cmd>` 
		Shortcut for docker compose exec


### Api Test

Try all available API function with `localhost:8080/apix/`



### Starting Docker Compose

Checkout the repository or download the sources.

Simply run `docker-compose up` and you are done.

Nginx will be available on `localhost:8080` and PostgreSQL on `localhost:5434`.


### Using PostgreSQL

Default connection:

`docker-compose exec db psql -U postgres`

Using .env file default parameters:

`docker-compose exec db psql -U dbuser dbname`

If you want to connect to the DB from another container (from the `php` one for instance), the host will be the service name: `db`.


### Using PHP

You can execute any command on the `php` container as you would do on any docker-compose container:

`docker-compose exec php php -v`
