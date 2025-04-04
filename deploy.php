<?php
namespace Deployer;

require 'recipe/symfony.php';

// Config

set('repository', 'https://github.com/matrocheetos/cardapio-api.git');

set('ssh_multiplexing', false);

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('pratofacil.dynv6.net')
    ->set('provision_user', 'ubuntu')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '~/cardapio-api')
    ->set('http_user', 'caddy');

// Hooks

after('deploy:failed', 'deploy:unlock');
