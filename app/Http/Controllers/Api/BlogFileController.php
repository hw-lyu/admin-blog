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
            'post_img' => $file
        ];

        try {
            if ($request->has('post_img')) {
                $files = file_s3_upload(nowFiles: $files, requestFiles: $files, path: 'post');
            }

            $fileArr = [
                'file_name' => str_replace('post/', '', $files['post_img_path']),
                'file_path' => $files['post_img_path'],
                'file_size' => $file->getSize(),
                'file_mine' => $file->getMimeType(),
            ];

            $this->blogFile->create($fileArr);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

        return response()->json(['data' => $fileArr, 'msg' => '등록이 완료되었습니다.']);
    }
}
