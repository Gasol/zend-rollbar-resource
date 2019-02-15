<?php

namespace GasolWu\Zend1\Resource;

use Exception;
use Rollbar\Rollbar as RollbarService;
use Rollbar\RollbarLogger;
use Zend_Application_Resource_ResourceAbstract as ResourceAbstract;

class Rollbar extends ResourceAbstract
{
    public function init()
    {
        $options = $this->getOptions();
        return $this->getRollbarLogger($options);
    }

    public function getRollbarLogger(array $options)
    {
        $defaults = [
            'config' => [
                'access_token' => null,
            ],
            'handleError' => true,
            'handleException' => true,
            'handleFatal' => true,
            'initial' => true,
            'loggerClass' => RollbarLogger::class,
        ];

        $options = array_merge($defaults, $options);

        $logger_class = $options['loggerClass'];
        $logger = new $logger_class(($options['config']));

        if ($this->isLiteralTrue($options['initial'])) {
            RollbarService::init(
                $logger,
                $this->isLiteralTrue($options['handleException']),
                $this->isLiteralTrue($options['handleError']),
                $this->isLiteralTrue($options['handleFatal'])
            );
        }

        return $logger;
    }

    protected function isLiteralTrue($value)
    {
        $true_values = [
            true,
            'true',
            'yes',
            'on',
            '1',
            1,
        ];

        return array_search($value, $true_values, true) !== false;
    }
}
