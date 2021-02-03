<?php

namespace App\Http\Controllers\Website;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Notifications\Admin\CommentSubmitted;
use App\Http\Controllers\Traits\GoogleCaptcha;
use App\Http\Controllers\Traits\CRUDNotify;

class CommentsController extends WebsiteController
{
    use GoogleCaptcha, CRUDNotify;

    public function comment(Request $request)
    {
        $attributes = request()->validate(Comment::$rules);

        $commentable = input('commentable_type')::find(input('commentable_id'));

        if (!$commentable) {
            return json_response_error('Whoops', 'We could not find the commentable.');
        }

        // validate google captcha
        $response = $this->validateCaptcha($request);
        if ($response->isSuccess()) {

            $row = $this->createEntry(Comment::class, $attributes);
            notify_admins(CommentSubmitted::class, $row);

            return json_response('Thank you for your comment, an administrator will review your comment in due time.');
        }

        return $this->captchaResponse($response);
    }
}
