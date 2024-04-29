<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCommentRequest;
use App\Models\BlogComment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class CommentController extends Controller
{
    public function __construct(public BlogComment $blogComment)
    {
    }

    /**
     * 코멘트 저장
     *
     * @param BlogCommentRequest $request
     * @return RedirectResponse
     */
    public function store(BlogCommentRequest $request) : RedirectResponse
    {
        $data = $request->except(['_token', 'comment_img']);
        $files = [
            'comment_img' => [
                'id' => null
            ]
        ];

        try {
            if ($request->has('comment_img')) {
                $files = file_s3_upload(nowFiles: $files, requestFiles: $request->file(), path: 'comment');
            }

            $data['password'] = Hash::make($data['password']);
            $this->blogComment->create([
                ...$data,
                'ip' => "{$request->ip()}",
                'user_agent' => $request->server('HTTP_USER_AGENT'),
                'comment_file_id' => $files['comment_img']['id'],
            ]);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        return back()->with('message', '등록이 완료되었습니다.');
    }
}
