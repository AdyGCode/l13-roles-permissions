<?php

namespace App\Http\Controllers;

class StaticController extends Controller
{
    //
    public function index()
    {
        $status = 'Not Logged In';
        $isAdmin = '-';
        $isClient = '-';
        $isStaff = '-';

        if (auth()->check()) {
            $status = 'Logged In';
            $user = auth()->user();

            if ($user->hasRole('admin')) {
                $isAdmin = 'Admin';
            }
            if ($user->hasRole('Staff')) {
                $isStaff = 'Staff';
            }
            if ($user->hasRole('client')) {
                $isClient = 'Client';
            }

            $permission = $user->can('admin-only') ? 'Admin' : 'Not Admin';
        }

        return "Static Home Page: {$status} | {$isAdmin} | {$isStaff} | {$isClient} | {$permission}";
    }
}
