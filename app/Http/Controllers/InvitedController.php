<?php

namespace App\Http\Controllers;

use App\Models\Invited;
use Illuminate\Http\Request;

class InvitedController extends Controller
{
    //
    /*
    public function __construct()
    {
        $this->middleware('auth');
    }
    */

    // vista de las colaboraciones
    public function index(){
        $invitaciones = Invited::where('user_id',auth()->user()->id)->get();
        return view('collaborations.index', compact('invitaciones'));
    }
}
