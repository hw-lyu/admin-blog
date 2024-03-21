<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogInformationRequest;
use App\Models\BlogInformation;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as FoundationApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class BlogInformationController extends Controller
{

    public function __construct(public BlogInformation $blogInformation)
    {
    }

    /**
     * 기본세팅 메인 화면
     *
     * @return Application|Factory|View|FoundationApplication
     */
    public function index(): Application|Factory|View|FoundationApplication
    {
        $data = $this->blogInformation
            ->with(['profileFile', 'coverFile'])
            ->latest()
            ->first() ?? [
            'name' => '',
            'nick_name' => '',
            'introduce' => '',
            'coverFile' => [
                'id' => '',
                'file_path' => ''
            ],
            'profileFile' => [
                'id' => '',
                'file_path' => ''
            ]
        ];

        return view('admin.index', ['data' => $data]);
    }

    /**
     * 블로그 정보 저장
     *
     * @param BlogInformationRequest $request
     * @return RedirectResponse
     */
    public function store(BlogInformationRequest $request): RedirectResponse
    {
        $data = $request->except('_token');
        $files = [
            'profile_img' => [
                'id' => $data['now_profile_id']
            ],
            'cover_img' => [
                'id' => $data['now_cover_id']
            ]
        ];

        //profile_file_id
        //cover_file_id
        try {
            if ($request->has('profile_img') || $request->has('cover_img')) {
                $files = file_s3_upload(nowFiles: $files, requestFiles: $request->file(), path: 'information');
            }

            $this->blogInformation->create([
                'name' => $data['name'],
                'nick_name' => $data['nick_name'],
                'introduce' => $data['introduce'],
                'profile_file_id' => $files['profile_img']['id'],
                'cover_file_id' => $files['profile_img']['id'],
            ]);

            Log::channel('slack')->info("{$request->user()['email']}님이 블로그 정보를 저장합니다.",
                [
                    '블로그명' => $data['name'],
                    '별명' => $data['nick_name'],
                    '자기소개' => $data['introduce'],
                    '프로필 사진 아이디 | 커버사진 아이디' => $files['profile_img']['id'] . ' | ' . $files['profile_img']['id'],
                ]
            );

        } catch (\Exception $e) {
            Log::channel('slack')->alert("{$request->user()['email']}님이 블로그 정보를 저장합니다.",
                [
                    '블로그명' => $data['name'],
                    '별명' => $data['nick_name'],
                    '자기소개' => $data['introduce'],
                    '프로필 사진 아이디 | 커버사진 아이디' => $files['profile_img']['id'] . ' | ' . $files['profile_img']['id'],
                    '에러 메시지' => $e->getMessage()
                ]
            );

            return back()->withErrors([
                'error' => $e->getMessage()]);
        }

        return back()->with('message', '등록이 완료되었습니다.');
    }
}
