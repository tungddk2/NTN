<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function findPostByTag($hashtag) {
        return Post::with('profile')->with('comments')->with('tags')->with('likes')->whereRelation('tags', 'hashtag', $hashtag)->get();
    }

    public function findPostById($id) {
        return Post::where('id', $id)->with('profile')->with('comments')->with('tags')->with('likes')->first();
    }

    public function getPosts($user_id) {
        return Post::where('user_id', $user_id)->with('profile')->with('comments')->with('tags')->with('likes')->get();
    }

    public function getAll() {
        return Post::with('comments')->with('profile')->with('tags')->with('likes')->paginate(10);
    }

    public function store(StorePostRequest $request)
    {
        $files = $request->file('image');
        $path = null;
        if ($files) {
            $path = $files->store('/images', 'public');
        }
        $post = auth()->user()->posts()->create([
            'image' => $path,
            'content' => $request->content
        ]);

        foreach ($request->tags as $tag) {
            $id = Tag::firstOrCreate([
                'hashtag' => $tag
            ]);
            $post->tags()->attach($id);
        }

        return response([
            'message' => 'Created new post success.'
        ], 201);
    }

    public function update(UpdatePostRequest $request, $id)
    {
        auth()->user()->posts()->where('id', $id)->update([
            'content' => $request->content
        ]);

        return response([
            'message' => 'Post is edited.'
        ], 201);
    }

    public function destroy($id)
    {
        $message = "Post is deleted success.";
        $status = 200;
        try {
            auth()->user()->posts()->findOrFail($id);
        } catch(ModelNotFoundException $e) {
            $message = "Post is invalid.";
            $status = 404;
        }

        auth()->user()->posts()->where('id', $id)->delete();

        return response([
            'message' => $message
        ], $status);
    }
}
