<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;


class DashboardController extends Controller
{
        public function index(Request $request)
        {
            $user = auth()->user();
            $meta = $user->meta();
            $view = sprintf('home.%s-dashboard',$user->role);
            return view($view,compact('user','meta'));
        }
}
