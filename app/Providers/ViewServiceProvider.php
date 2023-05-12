<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        $conocimientos = Conocimiento::all();
        View::share(['conocimientos' => $conocimientos]);
    }
}
