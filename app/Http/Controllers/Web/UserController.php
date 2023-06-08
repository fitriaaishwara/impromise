<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\SendVerifUser;
use App\Models\User;
use App\Models\UserDepartment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }
    public function getData(Request $request)
    {
        $keyword = $request['searchkey'];
        $department_id = $request['department_id'];

        $users = User::select()
            ->with(['roles', 'user_department.department'])
            ->offset($request['start'])
            ->limit(($request['length'] == -1) ? User::count() : $request['length'])
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->when($department_id, function ($query, $department_id) {
                $query->whereHas('user_department', function ($query) use ($department_id) {
                    return $query->where('department_id', $department_id);
                });
            })
            ->oldest('name')
            ->get();

        $usersCounter = User::select()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->when($department_id, function ($query, $department_id) {
                $query->whereHas('user_department', function ($query) use ($department_id) {
                    return $query->where('department_id', $department_id);
                });
            })
            ->count();
        $response = [
            'status'          => true,
            'code'            => '',
            'message'         => '',
            'draw'            => $request['draw'],
            'recordsTotal'    => User::count(),
            'recordsFiltered' => $usersCounter,
            'data'            => $users,
        ];
        return $response;
    }
    public function create()
    {
        return view('user.create');
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $fileName = Str::random(20);
        $path = 'images/user/';
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'message' => 'User failed to create'];
            if (User::where('email', $request['email'])->exists()) {
                return $data = ['status' => false, 'message' => 'Email already exists'];
            }
            if (User::where('username', $request['username'])->exists()) {
                return $data = ['status' => false, 'message' => 'Username already exists'];
            }
            $validator = Validator::make($request->all(), [
                'photo' => 'image|mimes:jpg,jpeg,png|max:2048',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Files cannot be larger than 2MB, in the format of jpg, jpeg, png']);
            }
            if ($request->file('photo') != null) {
                $extension = $request->file('photo')->extension();
                $photoName = $fileName . '.' . $extension;
                Storage::disk('public')->putFileAs($path, $request->file('photo'), $fileName . "." . $extension);
            } else {
                $photoName = null;
            }
            $user                = new User;
            $user->username      = $request['username'];
            $user->name          = $request['name'];
            $user->email         = $request['email'];
            $user->photo         = $photoName;
            $user->is_active     = false;
            $user->created_by    = Auth::user()->id;
            $user->save();

            $user->assignRole($request->role_id);

            if ($user) {
                foreach ($request['department_id'] as $key => $value) {
                    $create = UserDepartment::create([
                        'user_id'       => $user->id,
                        'department_id' => $value
                    ]);
                }
                DB::commit();
                $data = ['status' => true, 'message' => 'User successfully created'];
            }
        } catch (\Exception $ex) {
            DB::rollback();
            $data = ['status' => false, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function show($id)
    {
        try {
            $data = ['status' => false, 'message' => 'User failed to be found'];
            $user = User::with(['roles', 'user_department.department'])->where('id', $id)->first();
            if ($user) {
                $data = ['status' => true, 'message' => 'User was successfully found', 'data' => $user];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function edit($id)
    {
        return view('user.edit', compact('id'));
    }
    public function update(Request $request)
    {
        // dd($request->all());
        $fileName = Str::random(20);
        $path = 'images/user/';
        $user = User::where('id', $request->id)->first();
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'message' => 'User failed to update'];
            if ($user->email != $request['email']) {
                if (User::where('email', $request['email'])->exists()) {
                    return $data = ['status' => false, 'code' => 'EC002', 'message' => 'Email already exists'];
                }
            }
            if ($user->username != $request['username']) {
                if (User::where('username', $request['username'])->exists()) {
                    return $data = ['status' => false, 'message' => 'Username already exists'];
                }
            }
            $validator = Validator::make($request->all(), [
                'photo' => 'image|mimes:jpg,jpeg,png|max:2048',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Files cannot be larger than 2MB, in the format of jpg, jpeg, png']);
            }
            if ($request->file('photo') != null) {
                $extension = $request->file('photo')->extension();
                $photoName = $fileName . '.' . $extension;
                Storage::disk('public')->putFileAs($path, $request->file('photo'), $fileName . "." . $extension);
            } else {
                $photoName = null;
            }

            $user->username      = $request['username'];
            $user->name          = $request['name'];
            $user->email         = $request['email'];
            $user->photo         = $photoName;
            $user->updated_by    = Auth::user()->id;
            $user->save();
            $user->syncRoles($request->role_id);

            if ($user) {
                $delete = UserDepartment::where('user_id', $user->id)->delete();
                foreach ($request['department_id'] as $key => $value) {
                    $create = UserDepartment::create([
                        'user_id'       => $user->id,
                        'department_id' => $value
                    ]);
                }
                DB::commit();
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'User updated successfully'];
            }
        } catch (\Exception $ex) {
            DB::rollback();
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function changePassword(Request $request)
    {
        try {
            $data = ['status' => false, 'message' => 'Password failed to update'];

            $update = User::where('id', $request['id'])->update([
                'password' => Hash::make($request['password']),
            ]);
            if ($update) {
                $data = ['status' => true, 'message' => 'Password successfully updated'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'message' => 'User failed to delete'];

            $user = User::find($id);
            $user->removeRole($user->roles->first());
            $user->delete();
            if ($user) {
                DB::commit();
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'User deleted successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function send($id)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'User failed to send'];
            $user = User::find($id);
            $today = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
            $password = Str::random(8);

            $email = $user->email;
            Mail::to($email)->queue(new SendVerifUser($user, $password));
            if (Mail::failures()) {
                $data = ['status' => false, 'code' => 'EC001', 'message' => 'User failed to send'];
            } else {
                $update = User::where('id', $id)->update([
                    'password'          => Hash::make($password),
                    'is_active'         => true,
                    'email_verified_at' => $today
                ]);
                if ($update) {
                    DB::commit();
                    $data = ['status' => true, 'code' => 'EC001', 'message' => 'User sent successfully'];
                }
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function updateActive(Request $request)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'User failed to update'];
            $is_active = ($request['is_active'] == "true") ? 1 : 0;

            $update = User::where('id', $request['id'])->update([
                'is_active'        => $is_active,
            ]);
            if ($update) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'User successfully updated'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
}
