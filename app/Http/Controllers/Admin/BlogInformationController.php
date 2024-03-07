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

        return view('Admin.index', ['data' => $data]);
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

        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => $e->getMessage()]);
        }

        return back()->with('message', '등록이 완료되었습니다.');
    }
}
