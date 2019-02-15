--TEST--
Test Rollbar::init() should handle warning by default
--SKIPIF--
--FILE--
<?php

use GasolWu\Zend1\Resource\StdoutLogger;

require __DIR__ . '/../../vendor/autoload.php';

$logger_class = StdoutLogger::class;

$options = [
    'config' => [
        'access_token' => str_repeat('x', 32),
    ],
    'loggerClass' => $logger_class,
];

rollbar_init($options);

1/0;
?>
--EXPECTF--
[GasolWu\Zend1\Resource\StdoutLogger: error] %SRollbar\ErrorWrapper%SDivision by zero%S in %s:%d
Stack trace:
#0 %s
#1 %s
#2 %s
Warning: Division by zero in %s on line %d
