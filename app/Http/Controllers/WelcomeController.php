<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
    {
        $dashboardUrl = [];

        if (Auth::check()) {
            $role = Auth::user()->role;

            if ($role === 'admin') {
                $dashboardUrl = route('filament.admin.pages.dashboard');
            } elseif ($role === 'teacher') {
                $dashboardUrl = route('filament.teacher.pages.dashboard');
            } elseif ($role === 'student') {
                $dashboardUrl = route('filament.student.pages.dashboard');
            }
        }

        return view('welcome', compact('dashboardUrl'));
    }
}
