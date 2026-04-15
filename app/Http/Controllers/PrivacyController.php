<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PrivacyController extends Controller
{
    public function index(): View
    {
        return view('privacy');
    }
}