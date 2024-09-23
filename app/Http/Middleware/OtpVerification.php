<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Jobs\SendUserLoginOtpJob;
use App\User;
use DB;

class OtpVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if((Auth::check()) && (!is_null($user->otp)))
        {
            $reset = new AuthenticatedSessionController();
            $time_diff = (strtotime($user->otp_expires_at) - time()) / 60;
            if($time_diff < 0){
                $reset_otp = $reset->resetOtp();
                Auth::logout();
                return redirect()->route('login')->withErrors(['errorlogin' => 'The two factor code has expired. Please login again.']);
            }

            if(!$request->is('otp/*'))
            {
                return redirect('otp/verify');
            }

        }

        return $next($request);
    }
}
