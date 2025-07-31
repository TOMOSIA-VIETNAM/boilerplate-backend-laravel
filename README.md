# I. Project Overview

Structure Project Sample

# II. System Requirements

-   PHP: 8.3
-   Laravel: 11.31
-   MYSQL 8.0
-   OS: Macos, Linux
-   Sail (Docker) 8.2
-   UI: Vite, Tailwind
-   Filament: 3.0 (Admin Panel)

# III. Getting started

## Installation

### 1. Clone the repository

    git clone git@github.com:TOMOSIA-VIETNAM/winner_scout.git

### 2. Switch to the repo folder

    cd winner_scout

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

    127.0.0.1 winner_scout.loc

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

Document api for [scramble]('https://scramble.dedoc.co/')

Url document local: http://template-laravel-module.loc/api-docs

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

# IV. Admin Panel (Filament)

## 1. Access Admin Panel

Document Filament at:

    https://filamentphp.com/docs

## 2. Default Login Credentials

-   **Email**: admin@admin.com
-   **Password**: password

## 3. Features

-   **Admin Management**: Complete CRUD operations for administrators
-   **Multi-language Support**: English (EN) and Japanese (JP)
-   **Language Switching**: Real-time language switching in admin panel
-   **Authentication**: Secure admin authentication with separate guard
-   **Modern UI**: Beautiful and responsive admin interface


## 4. Module Structure

The Admin module follows Laravel modular structure:

```shell
modules/Admin/
├── Filament/
│   ├── Resources/
│   │   └── AdminResource.php
│   ├── Pages/
│   │   ├── CreateAdmin.php
│   │   ├── EditAdmin.php
│   │   └── ListAdmins.php
│   └── Widgets/
├── Http/
│   ├── Controllers/
│   └── Middleware/
│       └── SetLocale.php
├── lang/
│   ├── en/
│   │   └── common.php
│   └── ja/
│       └── common.php
├── Providers/
│   ├── AdminServiceProvider.php
│   ├── FilamentServiceProvider.php
│   └── RouteServiceProvider.php
└── View/
    └── Components/
```

## 5. Database Setup

### Run Migrations and Seeders

    sail artisan migrate
    sail artisan db:seed --class=AdminSeeder

This will create the admin table and insert the default admin user.

# V. Development flow

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

# VI. Packages

## 1. Containers
Each container is responsible for performing a large business operation and is considered the core of the application

### Create a new container:
    sail artisan d:create {container-name}

#### Example:
    sail artisan d:create Payment

It would create a container inside `app` folder under `Containers/Payment` folder.
Also, it would generate the following scaffold:

```shell
|____app
| |____ Containers
| | |____ Payment
| | | |____ Models
| | | |____ Policies
| | | |____ Actions
| | | |____ Jobs
| | | |____ Events
| | | |____ Data
| | | |____ Observers
| | | |____ Listeners
| | | |____ Services
| | | |____ Repositories
```

Check the documentation below to view more details
https://ddd.thejano.com/guide/usage.html#package-commands

## 2. Enum
### Create enum
    sail artisan make:enum StatusEnum
