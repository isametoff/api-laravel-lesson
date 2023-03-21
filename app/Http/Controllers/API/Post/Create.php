<?php

namespace App\Http\Controllers\Api\Post;

use App\Actions\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Models\Post;

class Create extends Controller
{
    public function store(StorePostRequest $request, Auth $authAction)
    {
        if ($authAction->role() === true) {
            $create = Post::create([
                'title' => $request['title'],
                'body' => $request['body'],
                'status' => $request['status'],
                'user_id' => auth()->id(),
            ])->exists();
            return response()->json(['create' => $create]);
        }
        return response()->json(['message' => 'No recording rights', 'create' => false]);
    }
}
