<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    // MySQL older than the 5.7.7

    public function boot()
    {
        Blade::directive('set',function($exp) 
        {        	
            list($name,$val) = explode(',',$exp);

            return "<?php $name = $val ?>";     	
        });
        
        Schema::defaultStringLength(191);
    }
}
