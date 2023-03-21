<?php

namespace App\Http\Controllers\Api\Post;

use App\Actions\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\Post\IndexPostResource;
use App\Models\Post;


class IndexPost extends Controller
{
    public function index(Auth $authAction)
    {
        $post = $authAction->role() === true ?
            Post::orderBy('created_at', 'DESC')->paginate(10) :
            Post::where('status', 0)->orderBy('created_at', 'DESC')->paginate(10);
        return IndexPostResource::collection($post);
    }
}
