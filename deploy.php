<?php

namespace Deployer;

require 'recipe/symfony4.php';

// Project name
set('application', 'healthCheck');

// Project repository
set('repository', 'git@github.com:nsolv/healthCheck.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);
set('writable_use_sudo', true);

set('keep_releases', 3);

set('symfony_env', 'prod');
set('env', [
    'SYMFONY_ENV' => get('symfony_env'),
]);
set('composer_options', function () {
    $options = '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --no-dev --optimize-autoloader --no-suggest';
    return get('symfony_env') !== 'prod' ? str_replace('--no-dev', '', $options) : $options;
});

// Shared files/dirs between deploys
add('shared_files', ['var/data.db']);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts
host('ubuntu@pi')
    ->set('deploy_path', '/var/www/{{application}}');

// Tasks
task('build', function () {
    run('cd {{release_path}} && build');
});

desc('parses ALL .env files and dumps their final values to .env.local.php');
task('dump-env', function () {
    run('cd {{release_path}} && {{bin/composer}} dump-env {{symfony_env}}');
});

desc('dumpautoload with option -o');
task('dump-autoload', function () {
    run('cd {{release_path}} && {{bin/composer}} dump-autoload -o');
});

after('deploy:cache:warmup', 'dump-env');
after('deploy:cache:warmup', 'dump-autoload');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.
// before('deploy:symlink', 'database:migrate');
