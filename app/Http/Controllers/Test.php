<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class Test extends Controller
{
    public function show()
    {
        return [auth()->user()];
        // return View::component('Hello', [
        //     'event' => ['greeting' => 'greeting'],
        // ]);
    }

    public function index()
    {
        return View::component('Dashboard', [
            'event' => ['greeting' => 'fuck'],
        ]);
    }
}
