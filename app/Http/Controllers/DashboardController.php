<?php

namespace App\Http\Controllers;

use App\Models\Company;
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
            'countUser' => User::count(),
            'countCompanies' => Company::count()
        ];
        return view('pages.dashboard', $data);
    }
    public function markersUser()
    {
        $data = User::select('users.*', 'tz.code')
            ->join('tr_company_users as tcu', 'users.id', '=', 'tcu.user_id')
            ->join('companies as co', 'co.id', '=', 'tcu.company_id')
            ->join('timezones as tz', 'tz.id', '=', 'co.timezone_id')
            ->has('position')
            ->with('position')
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }
}
