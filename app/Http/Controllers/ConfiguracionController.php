<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    //Cambio de idioma y activación de plugin
    public function setlocale($locale){
        app()->setLocale($locale);
        session()->put('locale', $locale);

        return redirect()->back();
    }
}
