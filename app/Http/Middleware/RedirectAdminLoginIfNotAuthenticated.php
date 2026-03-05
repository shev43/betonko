<?php

    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    /**
     * Class RedirectAdminLoginIfNotAuthenticated
     *
     * @package Framework\Http\Middleware
     */
    class RedirectAdminLoginIfNotAuthenticated {
        /**
         * Handle an incoming request.
         *
         * @param Request $request
         * @param Closure $next
         * @param string|null $guard
         *
         * @return mixed
         */
        public function handle($request, Closure $next, $guard = null) {
            if(!Auth::guard($guard)->check()) {
                return redirect()->route('amicms::profile.login.form');
            }
            return $next($request);
        }
    }
