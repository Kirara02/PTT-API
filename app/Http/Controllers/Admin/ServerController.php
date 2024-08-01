<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $data = Server::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn_edit = '<button class="btn btn-info" onclick="edit('.$row->id.')" type="button"><i class="icon-pencil"></i></button>';
                    $btn_delete = '<button class="btn btn-danger" onclick="destroy('.$row->id.')" type="button"><i class="icon-trash"></i></button>';
                    $btn = '<div class="btn-group">'.$btn_edit.$btn_delete.'</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            $data = [
                'title' => 'Server List | PTT UniGuard'
            ];
            return view('pages.admin.server', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only([
            'name', 'host', 'port',
            'user_id', 'username', 'password'
        ]);
        $validator = Validator::make($input, Server::rules(), [], Server::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bad input value',
                'errors' => $validator->errors()
            ], 400);
        } else {
            $create = Server::create($input);
            if ($create) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Server create successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'internal server error',
                ], 500);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Server::find($id);
        if ($data) {
            return response()->json([
                'status' => 'success',
                'message' => 'Server retrieved successfully',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Server not exist',
                'data' => $data
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->only([
            'name', 'host', 'port',
            'user_id', 'username', 'password'
        ]);
        $validator = Validator::make($input, Server::rules(), [], Server::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bad input value',
                'errors' => $validator->errors()
            ], 400);
        } else {
            $data = Server::find($id);
            if ($data) {
                $data->update($input);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Server updated successfully',
                    'data' => $data
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Server not exist',
                    'data' => $data
                ], 404);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Server::find($id);
        if ($data) {
            $data->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Server deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Server not exist'
            ], 404);
        }
    }
}
