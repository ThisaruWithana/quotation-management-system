<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Session;
use App\Models\User;
use DB;
use Mail;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthenticatedSessionController extends Controller
{
    
    use AuthenticatesUsers ;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        // $request->authenticate();
        // $request->session()->regenerate();
        // $code = $request->user()->generateTwoFactorCode();

       

        // return redirect()->intended(RouteServiceProvider::HOME)->with('success','Login successsfully.');

             // validate the form data
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $credentials = [
                'email' => $request['email'],
                'password' => $request['password'],
                'status' => 1
            ];
            $remember = (isset($request['remember'])) ? 'true' : 'false';    

        if (Auth::attempt($credentials, $remember)) {
            $otp = $this->randomOtp();

            $user_id = Auth::user()->id;
            $logout = User::find($user_id);
            $logout->logout = 0;
            $logout->save();
    
            if (is_numeric($otp)) {

                $content = [
                    'email' => $request['email'],
                    'otp' =>  $otp,
                    'name' => Auth::user()->name
                ];
           
               Mail::to($request->email)->send(new SendOtpMail($content));

                return redirect('otp/verify');

            }else{
                return redirect()->back()->withInput()->withErrors(['errorlogin' => 'Failed to send OTP']);
            }

        } else {
            // $this->incrementLoginAttempts($request);
            return redirect()->back()->withInput()->withErrors(['errorlogin' => 'Incorrect Email or Password']);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function logout(Request $request)
    {
        $logout = 1;

        DB::beginTransaction();
        try {
            $user = Auth::user();
            $user->logout = $logout;
            $user->save();

            Session::forget('client');
            Session::forget('firstLogin');

            DB::commit();
            Auth::logout();
            return redirect('login');
        } catch (\Exception $e) {
            DB::rollBack();
            Auth::logout();
            return redirect('login');
        }

    }

    public function randomOtp()
    {
        try {
            DB::beginTransaction();

            $otp = rand(10000, 99999);

            $user = User::find(Auth::user()->id);
            $user->otp = $otp;
            $user->otp_expires_at = now()->addMinutes(10);
            $user->save();

            DB::commit();

            return $otp;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function resetOtp()
    {
        try {
            DB::beginTransaction();

            $user = User::find(Auth::user()->id);
            $user->otp = null;
            $user->otp_expires_at = null;
            $user->save();

            DB::commit();
            return 1;

        } catch (\Exception $e) {
            DB::rollBack();
            return 0;
        }
    }

}
