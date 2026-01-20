<?php

namespace App\Http\Controllers;

class AdminKantinController extends Controller
{
    public function dashboard()
    {
        return view('admin.kantin.dashboard');
    }
}
