<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helper;
use App\Models\User;
use App\Models\Certificate;
use App\Models\Level;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $rules = [
        'name' => 'required',
        'email' => 'email|required',
    ];
    private function __uploadCertificate($file, $user_id)
    {
        // Buat path penyimpanan dengan nama file asli
        $fileName = $file->getClientOriginalName();
        // $path = $file->storeAs('certificates', $fileName);
        $file->move(public_path('certificates/'), $fileName);
        $certificate = Certificate::where('user_id', $user_id);
        if ($certificate->count() > 0) {
            // Hapus file sertifikat lama
            // Storage::delete($certificate->certificate_path);
            unlink(public_path('certificates/') . $fileName);
            // Update sertifikat dengan path baru
            $certificate->update([
                'certificate_path' => 'certificates/' . $fileName,
            ]);
        } else {
            // Buat entri sertifikat baru
            Certificate::create([
                'user_id' => $user_id,
                'certificate_path' => 'certificates/' . $fileName,
            ]);
        }
    }
    private function  __uploadPhoto($file, $exist = false){
        $fileName = time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('dist/profiles/'), $fileName);
        if ($exist) {
            unlink(public_path('dist/profiles/') . $exist);
        }
        return $fileName;
    }
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $user = User::all();
            return DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return Helper::actionButtons($row, ['reset', 'edit', 'delete']);
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            $data = [
                'title' => 'User',
                'levels' => Level::all()
            ];
            return view('pages.admin.user', $data);
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
        $input = $request->only(['name', 'email', 'level_id', 'password', 'certificate']);
        $this->rules['certificate'] = 'required|file|max:2048';
        $validator = Validator::make($input, $this->rules, [], []);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ],
                400
            );
        } else {
            $input['password'] = Hash::make($request->password);
            if ($request->has('photo')) {
                $input['photo'] = $this->__uploadPhoto($request->photo);
            }
            $create = User::create($input);
            if ($create) {
                if ($request->has('certificate')) {
                    $this->__uploadCertificate(
                        $request->file('certificate'),
                        $create->id
                    );
                }
                return response()->json(
                    [
                        'status' => 'success',
                        'message' => 'User created successfully',
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reset($id, Request $request)
    {
        $data = User::find($id);
        if ($data) {
            $input = [
                'password' => Hash::make($request->new_password),
            ];
            $data->update($input);
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Reset password successfully',
                    'data' => $data,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Data not exist',
                ],
                404
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::with('servers.server')->find($id);
        if ($data) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Data retrieved successfully',
                    'data' => $data,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Data not exist',
                ],
                404
            );
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
        $input = $request->only(['name', 'email', 'certificate', 'level_id']);
        $validator = Validator::make($input, $this->rules, [], []);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ],
                400
            );
        } else {
            $data = User::find($id);
            if ($data) {
                $input['photo'] = $this->__uploadPhoto($request->photo);
                $data->update($input);
                if ($request->has('certificate')) {
                    $this->__uploadCertificate(
                        $request->file('certificate'),
                        $id
                    );
                }
                return response()->json(
                    [
                        'status' => 'success',
                        'message' => 'Data updated successfully',
                        'data' => $data,
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Data not exist',
                    ],
                    404
                );
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
        $data = User::with('certificate')->find($id);
        if ($data) {
            if ($data->certificate) {
                if (
                    file_exists(
                        public_path($data->certificate->certificate_path)
                    )
                ) {
                    unlink(public_path($data->certificate->certificate_path));
                }
            }
            $data->delete();
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Data deleted successfully',
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Data not exist',
                ],
                404
            );
        }
    }
}
