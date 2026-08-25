<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $this->authorize('view', $task);

        $validated = $request->validate([
            'comment' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

        $task->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $validated['comment'],
        ]);

        return back()->with(
            'success',
            'Comment added successfully.'
        );
    }

    public function destroy(Comment $comment)
    {
        $user = auth()->user();

        if (
            $user->role !== 'admin' &&
            $comment->user_id !== $user->id
        ) {
            abort(403);
        }

        $comment->delete();

        return back()->with(
            'success',
            'Comment deleted successfully.'
        );
    }
}