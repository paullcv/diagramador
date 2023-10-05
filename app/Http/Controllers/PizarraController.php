<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PizarraController extends Controller
{
    
    public function index(){
        return view('pizarra.index');
    }
}
