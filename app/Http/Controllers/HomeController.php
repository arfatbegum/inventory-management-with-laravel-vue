<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class HomeController extends Controller
{
    function HomePage()
    {
        return Inertia::render('HomePage');
    }
}
