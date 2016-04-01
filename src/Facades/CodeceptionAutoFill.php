<?php namespace Sukohi\CodeceptionAutoFill\Facades;

use Illuminate\Support\Facades\Facade;

class CodeceptionAutoFill extends Facade {

    /**
    * Get the registered name of the component.
    *
    * @return string
    */
    protected static function getFacadeAccessor() { return 'codeception-auto-fill'; }

}