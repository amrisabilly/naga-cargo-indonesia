<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataController extends Controller
{

    public function index() {
        return view('dashboard.index');
    }

    public function data() {
        return view('dashboard.data.index');
    }
}
