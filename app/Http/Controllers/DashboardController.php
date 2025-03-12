<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Server;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'countServer' => Server::count(),
            'countUser' => User::count(),
            'countCompanies' => Company::count()
        ];
        return view('pages.dashboard', $data);
    }
    public function markersUser()
    {
        $data = User::select('users.*', 'tz.code')
            ->join('companies as co', 'co.id', '=', 'users.company_id')
            ->join('timezones as tz', 'tz.id', '=', 'co.timezone_id')
            ->has('position')
            ->with('position')
            ->when(Auth::user()->level_id != 0, function ($query) {
                return $query->where('users.company_id', Auth::user()->company_id);
            })
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }
}
