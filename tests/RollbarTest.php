<?php

namespace GasolWu\Zend1\Resource;

use Exception;
use Rollbar\Payload\Level;

/***
 * @runTestsInSeparateProcesses
 */
class RollbarTest extends TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testInitWithEmptyOptionsShouldThrowException()
    {
        $this->initRollbar([]);
    }

    public function testInit()
    {
        $logger_class = StdoutLogger::class;

        $options = [
            'config' => [
                'access_token' => $this->getTestAccessToken(),
            ],
            'loggerClass' => $logger_class,
        ];

        $logger = $this->initRollbar($options);
        $logger->log(Level::ERROR, 'foo');

        $this->expectOutputString("[$logger_class: error] foo");
    }

    protected function initRollbar(array $options)
    {
        $resource = new Rollbar($options);
        return $resource->init();
    }
}
