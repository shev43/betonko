<?php

    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Http\Request;

    class SetLocale {
        /**
         * Handle an incoming request.
         *
         * @param Request $request
         * @param Closure $next
         *
         * @return mixed
         */
        public function handle($request, Closure $next) {
            ($request->segment(1)) ? app()->setLocale($request->segment(1)) : 'ua';
            return $next($request);
        }
    }
