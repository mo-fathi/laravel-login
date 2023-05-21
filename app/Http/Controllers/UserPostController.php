<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserPostResource;
use App\Http\Responses\APIResponse;
use App\Models\Post;
use BadMethodCallException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPostController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'limit' => ['numeric', 'min:1'],
            'search' => ['string'],
        ]);
        $limit = $request->limit ? $request->limit : 10;

        if ($request->search){
            $posts = Post::where('context','LIKE',"%$request->search%")
                        ->paginate($limit);
        }
        else
        {
            $posts = Post::paginate($request->query('per_page',$limit));
        }

        try{
            $post_collection =  PostCollection::collection($posts);
            return APIResponse::json($data = $post_collection);
        }
        catch(BadMethodCallException $exception)
        {
            $post_resource =  new PostCollection($posts);
            return APIResponse::json($data = $post_resource);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required','max:120'],
            'context' => ['required'],
            'category_id' => ['required','numeric','min:1','exists:categories,id']
        ]);

        $user = Auth::user();

        $new_post =$user->posts()->create([
            'title' => $request->title,
            'context' => $request->context,
            'category_id' => $request->category_id
        ]);

        $new_post_resource = new PostResource($new_post);


        return APIResponse::json('post created',$new_post_resource);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        $post_resource = new PostResource($post);
        return APIResponse::json($data=$post_resource);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => ['required','max:120'],
            'context' => ['required'],
            'category_id' => ['required','numeric','min:1','exists:categories,id']
        ]);

        $post = Post::findOrFail($id);

        $updated_post =$post->update([
            'title' => $request->title,
            'context' => $request->context,
            'category_id' => $request->category_id
        ]);

        $updated_post_resorce = new PostResource($updated_post);

        return APIResponse::json('The post updated susccessfuly');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return APIResponse::json($message = 'The post deleted successfuly',$data=$post,$status=204);
    }
}
