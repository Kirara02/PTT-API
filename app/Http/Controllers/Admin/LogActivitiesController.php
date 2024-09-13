<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class LogActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $query = LogActivity::select('log_activities.*', 'users.name', 'tz.code')
                ->join('users', 'users.id', '=', 'log_activities.user_id')
                ->join('tr_company_users as tcu', 'tcu.user_id', '=', 'log_activities.user_id')
                ->join('companies as co', 'co.id', '=', 'tcu.company_id')
                ->join('timezones as tz', 'tz.id', '=', 'co.timezone_id')
                ->orderBy('log_activities.created_at', 'desc')
                ->get();
            return DataTables::of($query)
                ->editColumn('created_at', function($row){
                    return Carbon::parse(strtotime($row->created_at))->setTimezone($row->code)->isoFormat('DD MMM Y HH:mm z');
                })
                ->make(true);
        } else {
            $data = [
                'title' => 'Log Activities'
            ];
            return view('pages.admin.log-activities', $data);
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
        $input = [
            'user_id' => Auth::user()->id,
            'activity' => $request->activity
        ];
        if ($request->has('attachment')) {
            // Dapatkan file yang diupload
            $file = $request->file('attachment');

            // Buat path penyimpanan dengan nama file asli
            $fileName = $file->getClientOriginalName();
            // $path = $file->storeAs('audio', $fileName);
            $file->move(public_path('audio/'), $fileName);
            $input['attachment'] = 'audio/' . $fileName;
        }

        $create = LogActivity::create($input);
        if ($create) {
            return response()->json([
                'status' => 'success',
                'message' => 'Log Activity Created'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Log Activity failed to create'
            ], 500);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
