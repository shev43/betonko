<?php

    namespace App\Http\Controllers;
    class AmicmsController extends Controller {
        public function is_profile_auth() {
            $this->middleware('auth')->except('logout');
        }
    }
