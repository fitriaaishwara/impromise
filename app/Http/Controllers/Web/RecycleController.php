<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RecycleController extends Controller
{
    public function index()
    {
        return view('recycle.index');
    }
}
