<?php

namespace App\Services;

use Exception;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;





class LoginService
{
    // public static function checkBranchCode(Request $request)
    // {
    //     $branch_code = $request->input('branch_code');

    //     $branch = Branch::where('branch_code', $branch_code)
    //         ->first();

    //     if (!$branch) {
    //         throw new \Exception('Branch code not found', 404);
    //     }
    //     return $branch;
    // }

    public static function checkUsername(Request $request)
    {
        $username = $request->input('username');

        $user = User::where('username', $username)
            ->first();

        if ($user && $user->exists()) {
            if ($user->is_active > 0) {
                return $user;
            }
            throw new \Exception('User not Active', 403);
        }
        throw new \Exception('User not Found', 404);
    }



    public static function checkPassword(Request $request, User $user)
    {
        $password = $request->input('password');
        $remember = $request->boolean('remember', false);

        if (!Hash::check($password, $user->password)) {
            throw new \Exception("Password not match", 403);
        }
        return Auth::login($user);
    }
    public static function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }
}
