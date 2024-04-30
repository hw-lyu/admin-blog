<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCommentRequest;
use App\Models\BlogComment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

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
    public function store(BlogCommentRequest $request): RedirectResponse
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

    /**
     * 코멘트 편집 페이지 업데이트
     *
     * @param Request $request
     * @param string $id
     * @return void
     */
    public function update(Request $request, string $id)
    {
        $password = $request->input('password');
        $comment = $this->blogComment
            ->find($id);

        // 비밀번호가 같으면 업데이트
        if (Hash::check($password, $comment['password'])) {

        }
    }

    /**
     * 비밀번호 체크
     *
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function check(Request $request, string $id): RedirectResponse
    {
        $password = $request->input('password');
        $comment = $this->blogComment
            ->find($id);

        // 비밀번호가 같으면 라우터 이동
        if (Hash::check($password, $comment['password'])) {
            return redirect()->route('front.comments.edit', ['comment' => $id]);
        }

        return back()->withErrors(['error' => '비밀번호가 틀렸습니다.']);
    }

    /**
     * 비밀번호 입력 페이지
     *
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function create(Request $request) : Application|Factory|View|\Illuminate\Foundation\Application
    {
        $commentId = $request->query('comment');

        return view('front.layouts.comment', ['commentId' => $commentId]);
    }

    /**
     * 코멘트 편집 페이지
     *
     * @param Request $request
     * @param string $id
     * @return void
     */
    public function edit(Request $request, string $id)
    {

        dd($id);
        //return view('front.layouts.comment', ['pageName' => $pageName, 'commentId' => $id]);
    }
}
