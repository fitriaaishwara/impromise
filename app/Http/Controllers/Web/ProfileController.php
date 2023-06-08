<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }
    public function show($id)
    {
        try {
            $data = ['status' => false, 'message' => 'User failed to be found'];
            $user = User::with(['roles'])->where('id', $id)->first();
            if ($user) {
                $data = ['status' => true, 'message' => 'User was successfully found', 'data' => $user];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function update(Request $request)
    {
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
                $photoName = $user->photo;
            }
            $user->username      = $request['username'];
            $user->name          = $request['name'];
            $user->email         = $request['email'];
            $user->photo         = $photoName;
            $user->updated_by    = Auth::user()->id;
            $user->save();

            if ($user) {
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
}
