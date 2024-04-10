# Tomosia laravel modules template

The simply method to set up this project (for development only) is using [Docker](https://docs.docker.com/) and [Docker Compose](https://docs.docker.com/compose/).

## Setup & start
#### 1. Setup Docker
The first, install **Docker** and **Docker Compose**:

- https://docs.docker.com/install/
- https://docs.docker.com/compose/install/

#### 2. Clone source code

Clone this project to your server or local machine.

#### 3. Make config file

Run below command to make config file from sample file:

```bash
cp .env.example .env
```

#### 4. Build & start application
Run following command to build & start your application

```bash
docker-compose up
```

Run in background

```bash
docker-compose up -d
```

#### 5. Install packages

```bash
composer install
```

## Executes tests
```bash
php artisan test
```

## Documentation
API documentation with Swagger format is available here: [http://localhost:{$PORT}/api/documentation](http://localhost:8080/api/documentation)

## Useful link
- laravel-modules https://github.com/nWidart/laravel-modules
- l5-swagger https://github.com/DarkaOnLine/L5-Swagger
- laravel-jwt https://github.com/tymondesigns/jwt-auth
