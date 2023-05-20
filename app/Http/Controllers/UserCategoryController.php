<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Responses\APIResponse;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCategoryController extends Controller
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
        $category = Category::where('context','LIKE',"%$request->search%")
                    ->paginate($limit);

        $category_collection =  CategoryCollection::collection($category);

        return APIResponse::json($data = $category_collection);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required','max:120','unique:categories,title'],
            'description' => ['string'],
        ]);

        $user = Auth::user();

        $new_category =$user->categories()->create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        $new_category_resource = new CategoryResource($new_category);


        return APIResponse::json('post created',$new_category_resource);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        $category_resource = new CategoryResource($category);
        return APIResponse::json($data=$category_resource);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => ['required','max:120','unique:categories,title'],
            'description' => ['string'],
        ]);

        $category = Category::findOrFail($id);

        $updated_category =$category->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        $updated_post_resorce = new CategoryResource($updated_category);

        return APIResponse::json('The post updated susccessfuly');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $category = Category::findOrFail($id);
        $category->delete();
        return APIResponse::json($message = 'The post deleted successfuly',$data=$category,$status=204);

    }
}
