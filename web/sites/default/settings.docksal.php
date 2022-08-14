<?php

/**
 * @file
 * Local development override configuration feature.
 */

use Drupal\Component\Assertion\Handle;

/**
 * Database configuration.
 */
$databases = [
  'default' => [
    'default' => [
      'database' => 'default',
      'username' => 'user',
      'password' => 'user',
      'host' => 'db',
      'port' => '3306',
      'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
      'driver' => 'mysql',
      'prefix' => '',
    ],
  ],
];

if (getenv('DOCKSAL_ENVIRONMENT') && getenv('VIRTUAL_HOST')) {
  $host = getenv('VIRTUAL_HOST');
  $host_parts = explode('.', $host);
  $varnish_configs = [
    'varnish_purger.settings.63375491ff',
    'varnish_purger.settings.cafb995c3d',
  ];
  foreach ($varnish_configs as $varnish_config) {
    $host = getenv('VIRTUAL_HOST');
    $config[$varnish_config]['hostname'] = "varnish.$host";
    // The first header in the config MUST BE X-Acquia-Purge.
    $config[$varnish_config]['headers'][0]['value'] = $host_parts[0];
  }
}

/**
 * Configure to use memcache as the default cache backend. This simulates
 * memcache setup in the remote acquia environment.
 * @see ./factory-hooks/post-settings-php/acsfd8+.memcache.settings.php
 *
 * Requires the memcache module. Ensure it's enabled.
 *
 * To use this, see code and comment section at end of file below.
 */
// $settings['cache']['default'] = 'cache.backend.memcache';
// $settings['memcache']['servers'] = ['memcached:11211' => 'default'];
// $settings['memcache']['bins'] = ['default' => 'default'];
// $settings['memcache']['key_prefix'] = '';

