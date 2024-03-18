<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as FoundationApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;

class LoginController extends Controller
{
    /**
     * 로그인 메인화면
     *
     * @return Application|Factory|View|FoundationApplication
     */
    public function index(): Application|Factory|View|FoundationApplication
    {
        return view('admin.login');
    }

    /**
     * 관리자 로그인 여부
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        // 로그인 여부
        if (Auth::attempt($credentials)) {
            $response = Gate::inspect('is-admin', $request->user());

            // 관리자 여부
            if ($response->allowed()) {
                $request->session()->regenerate();

                // api 접근시 아이디 비밀번호가 필요함. 그렇지만 라라벨 유저 테이블서 비밀번호 hash 되어있기 때문에 복호화여 한번 더 처리
                session(['encrypt_password' => Crypt::encryptString($credentials['password'])]);

                return redirect()->intended();
            } else {
                return back()->withErrors([
                    'is_admin' => __('auth.admin_failed'),
                ]);
            }
        }

        return back()->withErrors([
            'email' => __('auth.failed'),
        ])->onlyInput('email');
    }
}
