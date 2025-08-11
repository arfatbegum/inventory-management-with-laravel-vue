<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class HomeController extends Controller
{
    function Home()
    {
        return Inertia::render('Home');
    }
}
