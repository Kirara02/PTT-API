<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function saveActivity($activity, $user_id)
    {
        $input = [
            'user_id' => $user_id,
            'activity' => $activity
        ];
        LogActivity::create($input);
        return true;
    }
    public function responseSuccess($message, $msg = 'message')
    {
        return response()->json([
            'status' => 'success',
            $msg => $message
        ], 200);
    }
    public function responseError($message, $code)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $code);
    }
}
