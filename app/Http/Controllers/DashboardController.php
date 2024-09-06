<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'countServer' => Server::count(),
            'countUser' => User::count()
        ];
        return view('pages.dashboard', $data);
    }
    public function markersUser()
    {
        $data = User::has('position')
            ->with('position')
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }
}
