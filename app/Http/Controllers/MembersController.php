<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function getMembers(){
        return view('backend.members');
    }
}
