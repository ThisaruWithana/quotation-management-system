<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Auth;
use App\Models\User;
use DB;
use Mail;
use App\Mail\SendOtpMail;

class OtpController extends Controller
{
    public function index()
    {
        return view('auth.two-fact-verify');
    }

    public function store(Request $request)
    {
        $request->validate([
            'otp' => 'integer|required',
        ]);

        $user = Auth::user();
        if($request->input('otp') == $user->otp)
        {
            $reset_otp = new AuthenticatedSessionController();
            $response_reset = $reset_otp->resetOtp();
            if($response_reset == 1){
                return redirect('/admin/dashboard');
            }else{
                return redirect('password/reset');
            }
        }

        return redirect()->back()->withErrors(['errorotp' => 'The two factor code you have entered does not match']);
    }

    public function resend()
    {
        $otp = new AuthenticatedSessionController();
        $otp = $otp->randomOtp();

        $user = Auth::user();

        $content = [
            'email' => $user->email,
            'otp' =>  $otp,
            'name' => $user->name
        ];
        
        Mail::to($user->email)->send(new SendOtpMail($content));

        return redirect()->back()->with(['otpmsg' => 'The two factor code has been sent again']);
    }
}
