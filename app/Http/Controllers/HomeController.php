<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display dashboard
     */
    public function index()
    {
        $totalUsers = User::whereNull('deleted_at')->count();
        $totalRoles = Role::count();

        return view('dashboard', compact('totalUsers', 'totalRoles'));
    }
}
