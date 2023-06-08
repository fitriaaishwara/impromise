<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $user = User::where('username', $request['username'])->first();

        if ($user) {
            $user_id = $user->id;
            if (!$user->is_active) {
                throw ValidationException::withMessages([
                    'username'      => trans('The system is unable to validate the user account. Your account has been disabled. Please contact admin for assistance. (3/3)'),
                ]);
            } else {
                if (!Auth::attempt($request->only('username', 'password'))) {
                    $login_failed = $user->login_failed_count + 1;

                    User::where('id', $user_id)->update([
                        'login_failed_count'     => $login_failed
                    ]);

                    if ($login_failed >= 3) {
                        User::where('id', $user_id)->update([
                            'is_active'     => false,
                        ]);

                        throw ValidationException::withMessages([
                            'username'      => trans('The system is unable to validate the user account. Your account has been disabled. Please contact admin for assistance. (3/3)'),
                        ]);
                    } else {
                        throw ValidationException::withMessages([
                            'username'      => trans('The system is unable to validate the user account. Please review your login credentials and try again. (' . $login_failed . '/3)'),
                        ]);
                    }
                } else {
                    User::where('id', $user_id)->update([
                        'login_failed_count'    => 0,
                    ]);

                    $request->session()->regenerate();

                    return redirect()->intended(RouteServiceProvider::HOME);
                }
            }
        } else {
            throw ValidationException::withMessages([
                'username'  => trans('The user credentials were incorrect.'),
            ]);
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
