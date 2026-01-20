<?php

namespace App\Http\Controllers;

class AdminWebController extends Controller
{
    public function dashboard()
    {
        return view('admin.web.dashboard');
    }
}
