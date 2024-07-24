<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages.auth');
    }
    public function login(Request $request)
    {
        $input = $request->only(['email', 'password']);
        $validator = Validator::make($input, [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'fields' => $validator->errors()
            ], 401);
        } else {
            if (Auth::attempt($input)) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email or Password are incorrect !'
                ], 404);
            }
        }
    }
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Auth::logout();
        return redirect()->route('auth.index');
    }
}
