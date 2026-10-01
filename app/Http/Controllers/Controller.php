<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function profile()
    {
        return view('profile _sekolah.index');
    }
}
