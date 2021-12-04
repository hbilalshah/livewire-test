<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;

    public $newComment;

    public function addComment() 
    {
        $this->validate([
            'newComment' => 'required|min:3|max:255'
        ]);

        Comment::create([
            'body' => $this->newComment,
            'user_id' => 1,
        ]);

        $this->newComment = '';

        session()->flash('message', 'Comment added successfully!');
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::find($commentId);
        $comment->delete();

        session()->flash('message', 'Comment deleted successfully!');
    }

    public function render()
    {
        return view('livewire.comments', [
            'comments' => Comment::latest()->paginate(2),
        ]);
    }
}
