<?php

// phpcs:ignoreFile

$cli = (php_sapi_name() == 'cli');
$env = getenv('APP_ENV') ?: '';

if ($cli) {
  ini_set('memory_limit', '512M');
}

$databases['default']['default'] = [
  'host' => getenv('DB_HOSTNAME'),
  'port' => getenv('DB_PORT') ?? '3306',
  'database' => getenv('DB_DATABASE'),
  'username' => getenv('DB_USER'),
  'password' => getenv('DB_PASSWORD'),
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
  'driver' => 'mysql',
  'prefix' => '',
  'isolation_level' => 'READ COMMITTED',
];

// TODO: Add correct trusted hosts here.
$settings['trusted_host_patterns'] = [
  '.*'
//  '^unswkeh\.ptest\.tv$',
];

$settings['hash_salt'] = getenv('DRUPAL_HASH_SALT') ?: 'MCMGfahfbBEhlbkcFXCrLlsxOtkLfnyZyhYeIfNLyMkPymLRvlGIIFYsWCSwEgUn';
$settings['container_yamls'][] = "$app_root/$site_path/services.yml";
$settings['file_scan_ignore_directories'] = [
  'node_modules',
  'bower_components',
];
$settings['update_free_access'] = FALSE;
$settings['entity_update_batch_size'] = 50;
$settings['entity_update_backup'] = TRUE;
$settings['config_sync_directory'] = '../config/sync';

/**
 * Filesystem settings.
 */
$settings['file_public_path'] = 'sites/default/files';
$settings['file_private_path'] = 'sites/default/files/private';

/**
 * Set developer mode.
 */
if (getenv('DEVELOPER_MODE') == 1) {
  require DRUPAL_ROOT . '/sites/development.settings.php';
}

/**
 * Environment specific config.
 */
if (!empty($env) && is_readable($env_settings = dirname(__FILE__) . "/$env.settings.php")) {
  require $env_settings;
}
