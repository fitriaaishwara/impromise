<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\EmailResetPasswordJob;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //You can add validation login here
        $request->validate([
            'email' => ['required', 'email'],
        ]);
        $user = User::where('email', $request['email'])
            ->first();
        //Check if the user exists
        if (empty($user)) {
            return redirect()->back()->withErrors(['email' => trans('User does not exist')]);
        }

        //Create Password Reset Token
        $token = Str::random(60);
        $created_at = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
        $expired_at = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->addMinutes(15);
        DB::table('password_resets')->insert([
            'email'         => $request->email,
            'token'         => $token,
            'created_at'    => $created_at,
            'expired_at'    => $expired_at
        ]);

        if ($this->sendResetEmail($request->email, $token)) {
            return redirect()->back()->with('status', trans('A reset link has been sent to your email address.'));
        } else {
            return redirect()->back()->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
        }
    }
    private function sendResetEmail($email, $token)
    {
        //Retrieve the user from the database
        $user = User::where('email', $email)->first();
        //Generate, the password reset link. The token generated is embedded in the link

        $link = url('reset-password/' . $token);

        try {
            //Here send the link with CURL with an external email API
            dispatch(new EmailResetPasswordJob($user, $link));
            // Mail::to($user->email)->queue(new ResetPasswordMail($user, $link));
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
