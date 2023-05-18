<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserPostResource;
use App\Http\Responses\APIResponse;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPostController extends Controller
{
    public $limit;

    public function __construct(
        Request $request
    )
    {
    
        $this->limit = ( $request->limit && $request->limit >= 1) ? $request->limit : 10;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post_collection =  UserPostResource::collection(Post::paginate($this->limit));

        return APIResponse::json($data = $post_collection);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required','max:120'],
            'context' => ['required'],
            'category_id' => ['required','numeric','min:1']
        ]);

        $user = Auth::user();
        
        $new_post =$user->posts()->create([
            'title' => $request->title,
            'context' => $request->context,
            'category_id' => $request->category_id
        ]);


        return APIResponse::json('post created',$new_post);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
