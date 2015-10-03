<?php

namespace app\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class OnceAuth
{
    /**
     * The guard instance.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param \Illuminate\Contracts\Auth\Guard $auth
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $fails = $this->auth->onceBasic();

        if ($fails) {
            return response()->json(['message' => 'You are not authorised to perform this request.', 'code' => 401], 401);
        }

        return $next($request);
    }
}
