<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanelController extends Controller
{
    //VISUAL INICIAL DEL PANEL ADMINISTRATIVO
    public function index(){
        return view('dashboard');
    }
}
