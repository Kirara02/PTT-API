<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Timezone;
use App\Models\TrCompanyUsers;
use App\Models\User;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function __insertUsers($users, $company_id)
    {
        $result = [];
        foreach ($users as $idx => $row) {
            $result[] = [
                'company_id' => $company_id,
                'user_id' => $row
            ];
        }
        if (TrCompanyUsers::where('company_id', $company_id)->get()) {
            TrCompanyUsers::where('company_id', $company_id)->delete();
        }
        TrCompanyUsers::insert($result);
        return true;
    }
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $data = Company::with('timezone')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('timezone', function($row){
                    return $row->timezone->code;
                })
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
                'title' => 'Company List | PTT UniGuard',
                'timezones' => Timezone::all(),
                'users' => User::all()
            ];
            return view('pages.admin.company', $data);
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
            'name', 'expire_date', 'timezone_id',
            'created_by', 'updated_by'
        ]);
        $validator = Validator::make($input, Company::rules(), [], Company::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
                'message' => 'Bad input values'
            ], 400);
        } else {
            $create = Company::create($input);
            if ($create) {
                $this->__insertUsers($request->users, $create->id);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Company created Successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'internal server error'
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
        $data = Company::with('tr_users', 'timezone')->find($id);
        if ($data) {
            // $date = $data->created_at->timezone($data->timezone->code)->toDateTimeString();
            return response()->json([
                'status' => 'success',
                'message' => 'Data retrieved Successfully',
                'data' => $data,
                // 'date' => $date
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data not exist'
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
            'name', 'expire_date',
            'updated_by', 'timezone_id',
        ]);
        $validator = Validator::make($input, Company::rules(), [], Company::attributes());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
                'message' => 'Bad input values'
            ], 400);
        } else {
            $data = Company::find($id);
            if ($data) {
                $data->update($input);
                $this->__insertUsers($request->users, $id);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data updated Successfully',
                    'data' => $data
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data not exist'
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
        $data = Company::find($id);
        if ($data) {
            $data->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data not exist'
            ], 404);
        }
    }
}
