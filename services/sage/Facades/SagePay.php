<?php

namespace Services\Sage\Facades;

use Illuminate\Support\Facades\Facade;

class SagePay extends Facade
{
    protected static function getFacadeAccessor() { 
    	return 'SagePay'; 
    }
}