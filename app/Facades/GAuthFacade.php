<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class GAuthFacade  extends Facade {
    protected static function getFacadeAccessor() { return 'googleAuth'; }
}
