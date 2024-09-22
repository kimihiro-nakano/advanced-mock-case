<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $loginData = $request->only('email', 'password', 'role');
        $user = User::where('email', $loginData['email'])->first();

        if (Auth::attempt($loginData)) {
            $request->session()->regenerate();

            if (!$user->hasVerifiedEmail()) {
                $user->sendEmailVerificationNotification();
                $request->session()->flash('message', 'ご登録いただいたメールアドレスに認証リンクを送信しましたので、ご確認ください。');
                return redirect()->route('verification.notice');
            }

            if ($user->role !== $loginData['role']) {
                Auth::logout();
                return redirect('/login')
                    ->withErrors(['role' => '選択したカテゴリーが無効です。'])
                    ->withInput($request->only('email'));
            }

            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.index');
                case 'shop_owner':
                    return redirect()->route('owner.index');
                case 'user':
                default:
                    return redirect()->route('index');
            }
        } else {
            return redirect('/login')
                ->withErrors(['password' => 'パスワードが違います'])
                ->withInput($request->only('email'));
        }
    }
}
