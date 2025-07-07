<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function editProfile()
    {
        $data = array(
            'title' => 'Profile',
        );
        return view('auth.profile', $data);
    }
}
