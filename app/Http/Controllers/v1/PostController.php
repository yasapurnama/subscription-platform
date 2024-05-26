<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function store(StorePostRequest $request)
    {
        Post::create($request->validated());

        return response()->json(null, Response::HTTP_CREATED);
    }
}
