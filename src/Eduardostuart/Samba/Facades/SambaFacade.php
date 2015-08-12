<?php namespace Eduardostuart\Samba\Facades;

use Illuminate\Support\Facades\Facade;

class SambaFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'samba'; }

}