<?php

use GasolWu\Zend1\Resource\Rollbar;

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function _initAlias()
    {
        class_alias(Rollbar::class, 'ZendX_Application_Resource_Rollbar');
    }
}
