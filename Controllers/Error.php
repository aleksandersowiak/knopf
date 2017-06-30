<?php

/**
 * Created by PhpStorm.
 * User: aso@ccp
 * Date: 28.04.17
 * Time: 05:18
 */
class Error extends BaseController
{
    protected function badUrl()
    {
        $viewmodel = array("Just a basic string");
        $this->ReturnView($viewmodel, true);
    }
} 