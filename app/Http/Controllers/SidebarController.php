<?php

namespace App\Http\Controllers;

use App\Models\SidebarMenu; 
use Illuminate\Support\Facades\Auth;

class SidebarController extends Controller
{
    public function index()
    {
    
        $userRole = Auth::user()->role;

    
        $menuItems = SidebarMenu::where(function($query) use ($userRole) {
            $query->where('role', $userRole)
                  ->orWhereNull('role');
        })
        ->orderBy('order_no')
        ->get();

    
        return view('sidebar', compact('menuItems'));
    }
}
