<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Returns dashboard index page.
     *
     * @return void
     */
    public function index()
    {
        return view('dashboard.index');
    }
}
