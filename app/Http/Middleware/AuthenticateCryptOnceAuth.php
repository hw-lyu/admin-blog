<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class AuthenticateCryptOnceAuth
{
    /**
     *  Handle an incoming request.
     *
     * @param $request
     * @param $next
     * @return mixed
     */
    public function handle($request, $next): mixed
    {
        // Basic <ID>:<Password>
        list($email, $password) = explode(':', base64_decode(str_replace('Basic ', '', $request->header('Authorization'))));

        // 양방향키로 암호화하여 클라이언트서 받은 정보 판단
        $email = Crypt::decryptString($email);
        $password = Crypt::decryptString($password);

        if (Auth::once(['email' => $email, 'password' => $password])) {
            return $next($request);
        }

        return response()->json(['msg' => '인증되지 않은 유저입니다.'], Response::HTTP_UNAUTHORIZED);
    }
}
