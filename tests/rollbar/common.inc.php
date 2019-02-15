<?php
// @codingStandardsIgnoreFile

require __DIR__ . '/../../vendor/autoload.php';

use GasolWu\Zend1\Resource\Rollbar;

function rollbar_init(array $options)
{
    $rollbar = new Rollbar($options);
    return $rollbar->init();
}
