<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $data = Company::with('tr_users.user')->get();
        return response()->json(['message' => 'Company data retrieved successfully', 'data' => $data], 200);
    }
}
