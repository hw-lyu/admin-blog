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
    protected int $MAX_TODAY_COMMENT_COUNT = 3;

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
        // 코멘트 및 파일 업로드 관련 변수
        $data = $request->except(['_token', 'comment_img']);
        $files = [
            'comment_img' => [
                'id' => null
            ]
        ];

        // 오늘 일자 하나의 포스트 기준 동일 IP의 코멘트 3개가 있으면 코멘트 저장할 수 없게 예외처리
        $ip = $request->ip();
        $commentTodayCount = $this->blogComment
            ->where([
                'ip' => $ip,
                'post_id' => $data['post_id']
            ])
            ->whereDate('created_at', now()->format('Y-m-d'))
            ->count();

        if($this->MAX_TODAY_COMMENT_COUNT <= $commentTodayCount) {
            return back()->with('message', "해당 글에서 오늘 하루 동일 IP($ip)로 쓸 수 있는 코멘트 횟수(총 $this->MAX_TODAY_COMMENT_COUNT 번)를 다쓰셨습니다.");
        }

        // 파일 업로드 및 코멘트 인서트
        try {
            if ($request->has('comment_img')) {
                $files = file_s3_upload(nowFiles: $files, requestFiles: $request->file(), path: 'comment');
            }

            $data['password'] = Hash::make($data['password']);
            $this->blogComment->create([
                ...$data,
                'ip' => $ip,
                'user_agent' => $request->server('HTTP_USER_AGENT'),
                'comment_file_id' => $files['comment_img']['id'],
            ]);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        return back()->with('message', '등록이 완료되었습니다.');
    }

    /**
     * 비밀번호 입력 페이지
     *
     * @param string $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function enter(string $id): Application|Factory|View|\Illuminate\Foundation\Application
    {
        return view('front.layouts.comment', ['commentId' => $id]);
    }

    /**
     * 비밀번호 체크 반환
     *
     * @param Request $request
     * @param string $id
     * @return array|bool
     */
    public function check(Request $request, string $id): array|bool
    {
        $password = $request->input('password');
        $comment = $this->blogComment
            ->find($id);

        if (empty($comment)) {
            return ['error' => '이미 삭제가 된 코멘트입니다.'];
        }

        // 비밀번호가 같으면 true 아니면 false
        if (Hash::check($password, $comment['password'])) {
            return true;
        }

        return false;
    }

    /**
     * 코멘트 편집 페이지
     *
     * @param Request $request
     * @param string $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse
     */
    public function edit(Request $request, string $id): Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse
    {
        $check = $this->check(request: $request, id: $id);

        if ($check) {
            $comment = $this->blogComment
                ->with(['commentFile'])
                ->find($id);

            return view('front.layouts.comment-edit', ['original_password' => $request->query('password'), 'comment' => $comment]);
        }

        return back()->withErrors(['error' => '비밀번호가 틀렸습니다.']);
    }

    /**
     * 코멘트 편집 내용 업데이트
     *
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $data = $request->except(['_token', '_method', 'comment_img', 'now_file_id', 'now_file']);
        $files = [
            'comment_img' => [
                'id' => $request->input('now_file_id') ?? null
            ]
        ];

        try {
            if ($request->has('comment_img')) {
                $files = file_s3_upload(nowFiles: $files, requestFiles: $request->file(), path: 'comment');
            }

            $data['password'] = Hash::make($data['password']);
            $this->blogComment
                ->find($id)
                ->update([
                    ...$data,
                    'ip' => "{$request->ip()}",
                    'user_agent' => $request->server('HTTP_USER_AGENT'),
                    'comment_file_id' => $files['comment_img']['id'],
                ]);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        return back()->with('message', '코멘트가 수정 되었습니다.');
    }

    /**
     * 코멘트 삭제
     *
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(Request $request, string $id): RedirectResponse
    {
        $check = $this->check(request: $request, id: $id);

        if (!empty($check['error'])) {
            return back()->withErrors(['error' => $check['error']]);
        }

        if ($check) {
            if ($this->blogComment->find($id)->delete()) {
                return back()->with('message', '삭제가 완료되셨습니다.');
            }
            return back()->with('message', '삭제가 안되었습니다. 관리자에게 문의해주세요.');
        }

        return back()->withErrors(['error' => '비밀번호가 틀렸습니다.']);
    }
}
