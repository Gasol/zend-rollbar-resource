--TEST--
Test Rollbar::init() should register exception handler by default
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

register_shutdown_function(function() {
    $output = ob_get_clean();
    foreach (explode("\n", $output) as $line) {
        $expected = '[GasolWu\Zend1\Resource\StdoutLogger: error] Exception: handleException in -:33';
        similar_text($line, $expected, $percent);
        if ($percent > 65) {
            echo "ok\n";
            return;
        }
    }

    echo "not ok\n";
});

ob_start();
throw new Exception('handleException');
?>
--EXPECTF--
ok
