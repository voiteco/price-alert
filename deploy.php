<?php
namespace Deployer;

require 'recipe/symfony4.php';

set('application', 'pricealert');
set('repository', 'git@github.com:voiteco/price-alert.git');

set('git_tty', true);
set('git_cache', true);

// Shared files/dirs between deploys
set('shared_files', ['.env.local']);
add('shared_dirs', []);
add('copy_dirs', ['vendor']);

// Writable dirs by web server
set('writable_mode', 'chown');
set('writable_use_sudo', false);
set('writable_dirs', ['var/cache', 'var/log']);

set('allow_anonymous_stats', false);
set('composer_options', get('composer_options').' --no-scripts');

// Hosts
host('prod')
    ->hostname('pricealert.production.host')
    ->user('www-data')
    ->identityFile('~/.ssh/id_rsa')
    ->set('deploy_path', '/var/www/{{application}}');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.
before('deploy:symlink', 'database:migrate');
