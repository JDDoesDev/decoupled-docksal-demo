<?php

/**
 * Load services definition file.
 */
$settings['container_yamls'][] = __DIR__ . '/services.yml';

/**
 * Include the Pantheon-specific settings file.
 *
 * n.b. The settings.pantheon.php file makes some changes
 *      that affect all environments that this site
 *      exists in.  Always include this file, even in
 *      a local development environment, to ensure that
 *      the site settings remain consistent.
 */
require __DIR__ . "/settings.pantheon.php";

/**
 * Place the config directory outside of the Drupal root.
 *
 * Override Pantheon and ddd sub-directory "sync" in config directory.
 */
$settings['config_sync_directory'] = dirname(DRUPAL_ROOT) . '/config/sync';

// Enable config split for dev, local, test and live environments.
switch (getenv('PANTHEON_ENVIRONMENT')) {
  case 'live':
    // Disabled on test and production.
    $config['config_split.config_split.config_dev']['status'] = FALSE;
    $config['key.key.graphql']['key_provider_settings']['file_location'] = 'private://keys/glive.json';
    $config['google_tag.container.petfinder']['status'] = TRUE;
    $config['system.performance']['max-age'] = 3600;
    $config['system.performance']['css']['preprocess'] = TRUE;
    $config['system.performance']['js']['preprocess'] = TRUE;
    break;

  case 'test':
    $config['system.performance']['max-age'] = 3600;
    $config['system.performance']['css']['preprocess'] = TRUE;
    $config['system.performance']['js']['preprocess'] = TRUE;
    $config['config_split.config_split.config_dev']['status'] = FALSE;
    $config['key.key.graphql']['key_provider_settings']['file_location'] = 'private://keys/gtest.json';
    // @todo Change this to FALSE after launch so that events are not tracked
    // on QA.
    $config['google_tag.container.petfinder']['status'] = TRUE;
    break;

    default:
    $config['system.performance']['max-age'] = 0;
    $config['system.performance']['css']['preprocess'] = FALSE;
    $config['system.performance']['js']['preprocess'] = FALSE;
    $config['config_split.config_split.config_dev']['status'] = TRUE;
    $config['key.key.graphql']['key_provider_settings']['file_location'] = 'private://keys/gdev.json';
    $config['google_tag.container.petfinder']['status'] = FALSE;
    break;
}

// Configure Redis.
// Must enable on Pantheon and enable the redis module.
if (defined('PANTHEON_ENVIRONMENT')) {
    // Include the Redis services.yml file. Adjust the path if you installed
    // to a contrib or other subdirectory.
    $settings['container_yamls'][] = '/web/modules/contrib/redis/example.services.yml';

    // Phpredis is built into the Pantheon application container.
    $settings['redis.connection']['interface'] = 'PhpRedis';
    // These are dynamic variables handled by Pantheon.
    $settings['redis.connection']['host'] = $_ENV['CACHE_HOST'];
    $settings['redis.connection']['port'] = $_ENV['CACHE_PORT'];
    $settings['redis.connection']['password'] = $_ENV['CACHE_PASSWORD'];

    $settings['redis_compress_length'] = 100;
    $settings['redis_compress_level'] = 1;
    // Use Redis as the default cache.
    $settings['cache']['default'] = 'cache.backend.redis';
    $settings['cache_prefix']['default'] = 'pantheon-redis';
    // Use the database for forms.
    $settings['cache']['bins']['form'] = 'cache.backend.database';
}

/**
 * Skipping permissions hardening will make scaffolding
 * work better, but will also raise a warning when you
 * install Drupal.
 *
 * https://www.drupal.org/project/drupal/issues/3091285
 */
// $settings['skip_permissions_hardening'] = TRUE;

if (isset($_ENV['PANTHEON_ENVIRONMENT'])) {

  switch ($_ENV['PANTHEON_ENVIRONMENT']) {
    case 'live':
      $config["config_split.config_split.dev"]["status"] = FALSE;
      $config["config_split.config_split.local"]["status"] = FALSE;
      $config["config_split.config_split.qa"]["status"] = FALSE;
      $config["config_split.config_split.prod"]["status"] = TRUE;
      break;

    case 'test':
      $config["config_split.config_split.dev"]["status"] = FALSE;
      $config["config_split.config_split.local"]["status"] = FALSE;
      $config["config_split.config_split.qa"]["status"] = TRUE;
      $config["config_split.config_split.prod"]["status"] = FALSE;
      break;

    default:
      $config["config_split.config_split.dev"]["status"] = TRUE;
      $config["config_split.config_split.local"]["status"] = FALSE;
      $config["config_split.config_split.qa"]["status"] = FALSE;
      $config["config_split.config_split.prod"]["status"] = FALSE;
      break;
  }
}
else {
  $config["config_split.config_split.dev"]["status"] = FALSE;
  $config["config_split.config_split.local"]["status"] = TRUE;
  $config["config_split.config_split.qa"]["status"] = FALSE;
  $config["config_split.config_split.prod"]["status"] = FALSE;
}

/**
 * If there is a local settings file, then include it
 */
$local_settings = __DIR__ . "/settings.local.php";
if (file_exists($local_settings)) {
    include $local_settings;
}
