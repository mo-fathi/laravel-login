<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Http\Responses\APIResponse;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCategoryController extends Controller
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
        return CategoryCollection::collection(Category::paginate($this->limit));
        // $categories = CategoryCollection::collection(Category::all())->paginate(10);
        // return APIResponse::json($data= $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request ->validate([
            'title' => ['required','string','unique:categories'],
            'description' => ['string']
        ]);

        $user = Auth::user();

        $new_category = $user->categories()->create([
            'title' => $request->title,
            'description' => $request->description
        ]);
        // return $new_category;
        return APIResponse::json('category created',false, new UserCategoryResource($new_category));
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
