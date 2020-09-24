# Fleet Mangemnt System
The goal is to build a minimal fleet management system (bus-booking system) using the latest version of Laravel framework
## Table of Content
* [Technologies](#technologies)
* [Installation](#installation)

## Technologies
- Laravel V8.x
- VueJS
- Bootstrap 4
- GraphQL
- Docker

## Installation
- cd into the project directory and run `docker-compose up -d`.
- after the building is finished run `docker-compose exec app composer install` to install the dependencies
- copy `.env.example` to `.env`
- run `docker-compose exec app php artisan key:generate`
- run `docker-compose exec app php artisan migrate --seed`
- run `npm i` then `npm run dev`
- go to `http://localhost:8000`
- the schema is available at `http://localhost:8000/graphql`

#### This repo is part of the hiring process at robusta.
