<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Closure;

class Authenticate 
{
    protected $session;
    protected $timeout = 1200;

    public function __construct(Store $session){
        $this->session = $session;
    }
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    public function handle($request, Closure $next)
    {
        $isLoggedIn = $request->path() != 'dashboard/logout';
// var_dump(time() - $this->session->get('lastActivityTime')); die();
        if(!session('lastActivityTime')){
            $this->session->put('lastActivityTime', time());

        }elseif(time() - $this->session->get('lastActivityTime') > $this->timeout){

            $this->session->forget('lastActivityTime');
            $cookie = cookie('intend', $isLoggedIn ? url()->current() : 'dashboard');

            // auth()->logout();

            return redirect('/logout');
        }
        $isLoggedIn ? $this->session->put('lastActivityTime', time()) : $this->session->forget('lastActivityTime');

        return $next($request);
    }
}
