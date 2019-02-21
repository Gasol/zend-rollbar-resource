<?php

use Rollbar\Rollbar;

class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $exception = new Exception('Sent from Travis CI');

        $result = Rollbar::debug($exception);
        if (!$result->wasSuccessful()) {
            throw $exception;
        }
    }
}
