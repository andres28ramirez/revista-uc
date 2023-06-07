<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

//Modelos
use App\Models\Conocimiento;

class ViewServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        if(Schema::hasTable('conocimiento')){
            $conocimientos = Conocimiento::all();
            View::share(['conocimientos' => $conocimientos]);
        }
    }
}
