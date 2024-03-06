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
        return view('Admin.login');
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
            $response = Gate::inspect('is-Admin', $request->user());

            // 관리자 여부
            if ($response->allowed()) {
                $request->session()->regenerate();

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
