<?php

namespace App\Http\Controllers;

use App\Models\UserActivity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = UserActivity::with('user')->latest()->get();
        return view('activities.index', compact('activities'));
    }
}
