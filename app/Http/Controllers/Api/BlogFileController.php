<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UploadRequest;
use App\Models\BlogFile;

class BlogFileController extends Controller
{
    public function __construct(public BlogFile $blogFile)
    {
    }

    public function store(UploadRequest $request)
    {
        $file = $request->file('post_img');
        $files = [
            'post' => []
        ];

        try {
            if ($request->has('post_img')) {
                $file = file_s3_upload(nowFiles: $files, requestFiles: ['post' => $file], path: 'post');
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

        return response()->json(['post' => $file['post'], 'msg' => '등록이 완료되었습니다.']);
    }
}
