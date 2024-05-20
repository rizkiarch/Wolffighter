<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LoginService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function user(Request $request)
    {
        return $request->user();
    }

    public function login(Request $request)
    {
        return inertia('auth/login');
    }

    public function doLogin(Request $request)
    {

        try {
            // $branch = LoginService::checkUser($request);
            $user = LoginService::checkUsername($request);
            // $login = 
            LoginService::checkPassword($request, $user);

            return redirect()->route('home');
        } catch (\Exception $e) {

            return redirect()
                ->route('login')
                ->with('error', $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        LoginService::logout($request);
        return redirect()->route('login');
    }
}
