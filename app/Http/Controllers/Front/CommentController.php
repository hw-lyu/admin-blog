<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCommentRequest;
use App\Models\BlogComment;

class CommentController extends Controller
{
    public function __construct(BlogComment $blogComment)
    {
    }

    public function store(BlogCommentRequest $request) {

        // $request->all()
        // HTTP_USER_AGENT
        // $request->ip()
    }
}
