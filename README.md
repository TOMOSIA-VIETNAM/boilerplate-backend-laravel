# I. Project Overview

Structure Project Sample

# II. System Requirements

-   PHP: 8.2
-   Laravel: 10.10
-   MYSQL 8.0
-   OS: Macos, Linux
-   Sail (Docker) 8.2
-   UI: HopeUI, Vite, Boostrap 5

# III. Getting started

## Installation

### 1. Clone the repository

    git clone git@github.com:TOMOSIA-VIETNAM/template-laravel-module.git

### 2. Switch to the repo folder

    cd template-laravel-module

### 3. Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

### 4. Install Laravel Sail

    docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php82-composer:latest composer install --ignore-platform-reqs

### 5. Open file `~/.zshrc` and add alias to shell

    sudo vim ~/.zshrc

Add this alias to `~/.zshrc` file

    alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'

### 6. Modify hosts file

    sudo vim /etc/hosts

Add this line to hosts file

    127.0.0.1 template-laravel-module.loc

## Sail/Docker for Development

### 1. Backend

    sail up -d
    sail composer install
    sail composer dump-autoload
    sail artisan key:generate
    sail artisan optimize
    sail artisan migrate
    sail artisan db:seed
    sail artisan storage:link

### 2. Frontend

    sail npm install

#### 2.1 For development

    sail npm run dev

#### 2.2 For production

    sail npm run build

## Convention Fixer

### 1. Check coding convention

    sail pint --test

### 2. Check and fix coding convention

    sail pint -v

# IV. Development flow

## 1. Git flow

Create a `feature` branch from the `develop` branch  
↓  
Development (during the process, if there is a topic regarding the source code, etc.)  
↓  
Create a pull request from `feature` branch to `develop` branch  
↓  
Review  
↓  
Merge into `develop` on GitHub  
↓  
Release `main` branch to production

## 2. Git convention

### 2.1. Naming branch

-   `<type>/<issue_number><issue_name>`
-   Example:
    ```shell
      - feature/issue-352-payment-api
      - bugfix/issue-352-bug-payment
      - release/v2.1-release-payment-api
    ```

### 2.2. Commit message

-   `<type>: <description>`
-   Example:
    ```shell
      - feat: Implement Admin UI dashboard
      - refactor: Admin UI dashboard
      - fix: Bug validation email when user register
      - revert: Revert commit
    ```

## 3. Interact with database

Create a migration file and add columns/table, etc.
