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

# V. Packages

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

## VI. Deploy

[Deployer documentation](https://deployer.org/docs/7.x/getting-started)

#### 1.Setting up your Local Development Environment
- Deployer installer
```
curl -LO https://deployer.org/deployer.phar
```
- Next, run a short PHP script to verify that the installer matches the SHA-1 hash for the latest installer found on the Deployer - [download page](https://deployer.org/download). Replace the highlighted value with the latest hash:
```
php -r "if (hash_file('sha1', 'deployer.phar') === '7fc18128545bebaa13fc7f3daa79b3e1fa67fd1e') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('deployer.phar'); } echo PHP_EOL;"
```
- Make Deployer available system wide
```
sudo mv deployer.phar /usr/local/bin/dep
```
- Make it executable:
```
sudo chmod +x /usr/local/bin/dep
```
#### 2. Connecting to Your Remote Git Repository
- Local machine to generate the SSH key
```
ssh-keygen -t rsa -b 4096 -f  ~/.ssh/gitkey
```
- Create an SSH config file on your local machine:
```
touch ~/.ssh/config
```
- cd ~/.ssh/config
```
Host mygitserver.com
    HostName mygitserver.com
    IdentityFile ~/.ssh/gitkey
```
```
chmod 600 ~/.ssh/config
```
- Display the content of your public key file with the following command:
```
cat ~/.ssh/gitkey.pub
```
- Add SSH keys to GitHub
  Link: https://docs.github.com/en/authentication/connecting-to-github-with-ssh/adding-a-new-ssh-key-to-your-github-account
- Test the connection with the following command:
```
ssh -T git@github.com
```
#### 3. Configuring the Deployer User
- Log in to your LEMP server with a sudo non-root user and create a new user called "deployer" with the following command:
```
sudo adduser deployer
```
- Add the user to the www-data group to do this:
```
sudo usermod -aG www-data deployer
```
- Setting deployer’s default umask to 022:
```
sudo chfn -o umask=022 deployer
```
- Store the application in the /var/www/html/ directory, so change the ownership of the directory to the deployer user and www-data group.
```
sudo chown deployer:www-data /var/www/html
```
- The deployer user needs to be able to modify files and folders within the /var/www/html directory. Given that, all new files and subdirectories created within the /var/www/html directory should inherit the folder’s group id (www-data). To achieve this, set the group id on this directory with the following command:
```
sudo chmod g+s /var/www/html
```
- Switch to the deployer user on your server:
```
su - deployer
```
- Generate an SSH key pair as the deployer user. This time, you can accept the default filename of the SSH keys:
```
ssh-keygen -t rsa -b 4096
```
- Display the public key:
```
cat ~/.ssh/id_rsa.pub
```
- Feel free to replace deployerkey with a filename of your choice:
```
ssh-keygen -t rsa -b 4096 -f  ~/.ssh/deployerkey
```
- Copy the following command’s output which contains the public key:
```
nano ~/.ssh/authorized_keys
```
- Restrict the permissions of the file:
```
chmod 600 ~/.ssh/authorized_keys
```
- Now switch back to the sudo user:
```
exit
```
- Log in from your local machine to your server as the deployer user to test the connection:
```
ssh deployer@your_server_ip  -i ~/.ssh/deployerkey
```

#### 4. Deploying the Application
- Open the terminal on your local machine and change the working directory to the application’s folder with the following command:
```
cd /path/to/laravel-app
```

The ```deploy.php``` file is used to manage deployment jobs. You can update or add new jobs as needed.
#### 5. Deploy Local
To deploy the project from your local environment to the server, use the following command:

    dep deploy [host]

#### 6. Deploy via GitHub Action
- Create GitHub Secrets for SSH:
To access the server securely, you need to store your SSH private key in GitHub Secrets:
  1. Go to your GitHub repository:

     Settings > Secrets and variables > Actions > New repository secret

  2. Add a new secret called **SSHKEY** and paste your private key.
- GitHub Action Workflow:
The workflow file ```.github/workflows/staging.yml``` is set to deploy when there is a merge commit to the develop branch. You can update the file or create an additional file for another server.
