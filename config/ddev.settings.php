<?php

/**
 * @file
 * Local development override configuration feature.
 */

/**
 * Additional host patterns can be added for custom configurations.
 */
$settings['trusted_host_patterns'] = ['.*'];

/**
 * Don't use Symfony's APCLoader. ddev includes APCu.
 *
 * Composer's APCu loader has better performance.
 */
$settings['class_loader_auto_detect'] = FALSE;

/**
 * Reverse proxy settings.
 */
$settings['reverse_proxy'] = FALSE;
