<?php

namespace Deployer;

require 'recipe/laravel.php';

// Project Configuration
set('application', 'template-laravel-module');
set('repository', 'git@github.com:TOMOSIA-VIETNAM/template-laravel-module.git');
set('keep_releases', 5);
set('shared_files', ['.env']);
set('shared_dirs', ['storage']);
set('shared_path', '/var/www/html/shared');
set('php_version', '8.2');

// Environment-specific configurations
$environments = [
    'develop' => [
        'hostname' => 'hostname',
        'remoteUser' => 'remoteUser',
        'branch' => 'develop',
    ],
    'staging' => [
        'hostname' => 'hostname',
        'remoteUser' => 'remoteUser',
        'branch' => 'staging',
    ],
    'production' => [
        'hostname' => 'hostname',
        'remoteUser' => 'remoteUser',
        'branch' => 'main',
    ],
];

// Set up hosts
foreach ($environments as $env => $config) {
    host($env)
        ->set('hostname', $config['hostname'])
        ->set('remote_user', $config['remoteUser'])
        ->set('IdentityFile', '~/.ssh/id_rsa')
        ->set('git_ssh_command', 'ssh')
        ->set('deploy_path', '/var/www/html')
        ->set('branch', $config['branch']);
}

// Deployment tasks
desc('Deploy project');
task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'artisan:config:clear',
    'artisan:storage:link',
    'artisan:optimize:clear',
    'artisan:migrate',
    'deploy:publish',
    'deploy:restart_services',
]);

// Custom tasks
desc('Install Composer dependencies');
task('deploy:vendors', function () {
    run('cd {{release_path}} && composer install --no-interaction --prefer-dist --optimize-autoloader');
    writeln('Composer dependencies installed');
});

desc('Restart Supervisord');
task('deploy:restart_supervisord', function () {
    run('sudo systemctl restart supervisord');
    writeln('Supervisord restarted');
});

desc('Restart PHP-FPM');
task('deploy:restart_php_fpm', function () {
    run('sudo systemctl restart php{{php_version}}-fpm');
    writeln('PHP-FPM (version {{php_version}}) restarted');
});

desc('Restart Nginx');
task('deploy:restart_nginx', function () {
    run('sudo systemctl restart nginx');
    writeln('Nginx restarted');
});

desc('Restart all services');
task('deploy:restart_all_services', [
    'deploy:restart_supervisord',
    'deploy:restart_php_fpm',
    'deploy:restart_nginx',
]);

desc('Symlink logs');
task('deploy:symlink_logs', function () {
    run('ln -sfn {{shared_path}}/logs {{release_path}}/storage/logs');
    writeln('Logs symlinked');
});

// Hooks
after('deploy:symlink', 'deploy:symlink_logs');
after('deploy:failed', 'deploy:unlock');
