<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password as RulesPassword;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $token = $request->route('token');
        $time = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->toTimeString();
        $date = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m-d');
        $tokenData = DB::table('password_resets')->where('token', $token)->whereDate('expired_at', '>=', $date)->whereTime('expired_at', '>=', $time)->first();
        if ($tokenData) {
            return view('auth.reset-password', ['request' => $request]);
        } else {
            return redirect()->back()->with('token', trans('This password reset token is invalid.'));
        }
    }

    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'password' => ['required', 'confirmed'],
        ]);
        // Validate the token
        $time = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->toTimeString();
        $date = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m-d');
        $tokenData = DB::table('password_resets')->where('token', $request->token)->whereDate('expired_at', '>=', $date)->whereTime('expired_at', '>=', $time)->first();
        // Redirect the user back to the password reset request form if the token is invalid
        if (!$tokenData) {
            return redirect()->back()->with('token', trans('This password reset token is invalid.'));
        }
        $validator = Validator::make($request->all(), [
            'password'    => RulesPassword::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['password' => trans('At least 8 characters combination of capital letters, lowercase letters, numbers and symbols.')]);
        }
        $user = User::where('email', $tokenData->email)->first();
        $user->password = \Hash::make($request->password);
        $user->save();
        DB::table('password_resets')->where('email', $user->email)->delete();
        if ($user) {
            return redirect()->route('login')->with('status', trans('Your password has been changed successfully'));
        } else {
            return redirect()->back()->withErrors(['password' => trans('A Network Error occurred. Please try again.')]);
        }
    }
}
