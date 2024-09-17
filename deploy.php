<?php

namespace Deployer;

require 'recipe/laravel.php';

// Configurations for the Laravel module deployment
set('application', 'template-laravel-module');
// Git repository URL of the project
set('repository', 'git@github.com:TOMOSIA-VIETNAM/template-laravel-module.git');
// Number of releases to keep on the server
set('keep_releases', 5);
// Files that should be shared between releases (not overwritten during deployment)
set('shared_files', ['.env']);
// Directories that should be shared between releases
set('shared_dirs', ['storage/logs']);

//This configuration file documents the setup for deploying to a staging server.
//It outlines important parameters such as hostname, remote user, SSH key, Git branch, etc.
//This is not the actual config but serves as a reference for future configurations.
//Define the staging server name (can be replaced with other server names)

// Develop server configuration
host('develop')
    ->set('hostname', 'hostname')
    ->set('remote_user', 'remote_user')
    ->set('IdentityFile', '~/.ssh/id_rsa')
    ->set('git_ssh_command', 'ssh')
    ->set('deploy_path', '/var/www/html')
    ->set('branch', 'develop');

// Staging server configuration
host('staging')
    ->set('hostname', 'hostname')
    ->set('remote_user', 'remote_user')
    ->set('IdentityFile', '~/.ssh/id_rsa')
    ->set('git_ssh_command', 'ssh')
    ->set('deploy_path', '/var/www/html')
    ->set('branch', 'staging');

// Production server configuration
host('production')
    ->set('hostname', 'hostname')
    ->set('remote_user', 'remote_user')
    ->set('IdentityFile', '~/.ssh/id_rsa')
    ->set('git_ssh_command', 'ssh')
    ->set('deploy_path', '/var/www/html')
    ->set('branch', 'main');

// Tasks
task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'artisan:config:clear',
    'artisan:storage:link',
    'artisan:optimize:clear',
    'artisan:migrate',
    'deploy:publish',
])->desc('Deploy project');

set('shared_path', '/var/www/html/shared');

task('deploy:symlink_logs', function () {
    run('cd {{release_path}} && ln -sfn {{shared_path}}/logs storage/logs');
});

after('deploy:symlink', 'deploy:symlink_logs');

task('deploy:restart-php-fpm', function () {
    run('sudo systemctl restart php8.2-fpm');
});

after('deploy:symlink', 'deploy:restart-php-fpm');

// After deploy tasks
after('deploy:failed', 'deploy:unlock');
