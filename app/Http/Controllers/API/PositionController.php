<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
{
    public function getData()
    {
        $data = Position::all();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Data retrieved Successfully',
                'data' => $data,
            ],
            200
        );
    }
    public function getLastPositionUser(Request $request)
    {
        if ($request->has('id_user')) {
            $data = User::with('position')->find($request->id_user);
        } else {
            $data = User::with('position')->get();
        }
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Data retrieved Successfully',
                'data' => $data,
            ],
            200
        );
    }
    public function store(Request $request)
    {
        $input = $request->only(['latitude', 'longitude']);
        $validator = Validator::make(
            $input,
            Position::rules(),
            [],
            Position::attributes()
        );
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'fields' => $validator->errors(),
                ],
                200
            );
        } else {
            $input['user_id'] = Auth::id();
            $user = User::find(Auth::id());
            $position = Position::create($input);
            if ($position) {
                $user->update([
                    'position_id' => $position->id,
                ]);
                return response()->json(
                    [
                        'status' => 'success',
                        'message' => 'Position create successfully',
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'internal server error',
                    ],
                    500
                );
            }
        }
    }
}
