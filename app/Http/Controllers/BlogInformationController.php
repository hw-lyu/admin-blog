<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogInformationRequest;
use App\Models\BlogInformation;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as FoundationApplication;
use Illuminate\Support\Facades\Storage;
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
        $data = $this->blogInformation->latest()->first() ?? [
            'name' => '',
            'nick_name' => '',
            'introduce' => '',
            'profile_img_path' => '',
            'cover_img_path' => ''
        ];

        return view('index', ['data' => $data]);
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
            'profile_img_path' => $data['now_profile_img'],
            'cover_img_path' => $data['now_cover_img']
        ];

        try {

            if ($request->has('profile_img') || $request->has('cover_img')) {
                foreach ($request->file() as $name => $file) {
                    $fileName = "information/{$name}_" . now()->format('Ymdhisu') . ".{$file->extension()}";

                    $files["{$name}_path"] = $fileName;
                    Storage::disk('s3')->put($fileName, $file->getContent());
                }
            }

            $this->blogInformation->create([
                'name' => $data['name'],
                'nick_name' => $data['nick_name'],
                'introduce' => $data['introduce'],
                ...$files
            ]);

        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => $e->getMessage()]);
        }

        return back()->with('message', '등록이 완료되었습니다.');
    }
}
