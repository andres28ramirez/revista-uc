<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EdicionController extends Controller
{
    //VISUAL INICIAL DEL PANEL ADMINISTRATIVO
    public function index(){
        return view('panel_admin.ediciones.index');
    }
}
