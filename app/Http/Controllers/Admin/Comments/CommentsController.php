<?php

namespace App\Http\Controllers\Admin\Comments;

use App\Models\Comment;
use Illuminate\View\View;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\Admin\AdminController;

class CommentsController extends AdminController
{
	/**
	 * Display a listing of comment.
	 *
	 * @return Factory|View
	 */
	public function index()
	{
		save_resource_url();

		return $this->view('comments.index')->with('items', Comment::all());
	}

	/**
	 * Show the form for creating a new comment.
	 *
	 * @return Factory|View
	 */
	public function create()
	{
		return $this->view('comments.create_edit');
	}

	/**
	 * Store a newly created comment in storage.
	 *
	 * @return RedirectResponse|Redirector
	 */
	public function store()
	{
        $attributes = request()->validate(Comment::$rules, Comment::$messages);

        $attributes['is_approved'] = (bool) input('is_approved');

        $comment = $this->createEntry(Comment::class, $attributes);

        return redirect_to_resource();
	}

	/**
	 * Display the specified comment.
	 *
	 * @param Comment $comment
	 * @return Factory|View
	 */
	public function show(Comment $comment)
	{
		return $this->view('comments.show')->with('item', $comment);
	}

	/**
	 * Show the form for editing the specified comment.
	 *
	 * @param Comment $comment
     * @return Factory|View
     */
    public function edit(Comment $comment)
	{
		return $this->view('comments.create_edit')->with('item', $comment);
	}

	/**
	 * Update the specified comment in storage.
	 *
	 * @param Comment  $comment
     * @return RedirectResponse|Redirector
     */
    public function update(Comment $comment)
	{
        if((bool) input('is_approved')){
            request()->merge([
                'approved_by' => user()->id,
                'approved_at' => \Carbon\Carbon::now()
            ]);
        }
        $attributes = request()->validate(Comment::$rules, Comment::$messages);

        $attributes['is_approved'] = (bool) input('is_approved');

        $comment = $this->updateEntry($comment, $attributes);

        return redirect_to_resource();
	}

	/**
	 * Remove the specified comment from storage.
	 *
	 * @param Comment  $comment
	 * @return RedirectResponse|Redirector
	 */
	public function destroy(Comment $comment)
	{
		$this->deleteEntry($comment, request());

        return redirect_to_resource();
	}
}
