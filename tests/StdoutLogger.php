<?php

namespace GasolWu\Zend1\Resource;

use Rollbar\RollbarLogger;

class StdoutLogger extends RollbarLogger
{
    public function log($level, $message, array $context = array(), $isUncaught = false)
    {
        echo '[' . get_class($this) . ': '. $level . '] ' . $message;
    }
}
