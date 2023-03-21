<?php

namespace App\Http\Controllers\Api\Post;

use App\Actions\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\idPostRequest;
use App\Http\Requests\Post\EditPostRequest;
use App\Http\Requests\Post\FixPostRequest;
use App\Models\Post;
use Illuminate\Http\Client\Request;

class Edit extends Controller
{
    public function update(EditPostRequest $request, Auth $authAction)
    {
        if ($authAction->role() === true) {
            $update = Post::where('id', $request['id'])
                ->update(
                    [
                        'title' => $request['title'],
                        'body' => $request['body'],
                        'status' => $request['status'],
                    ]
                );
            return response()->json(['update' => $update]);
        }
        return response()->json(['message' => 'No recording rights', 'update' => false]);
    }

    public function fix(idPostRequest $request, Auth $authAction)
    {
        if ($authAction->role() === true) {
            $fix = Post::where('id', $request['id'])->value('fix') === 0 ? 1 : 0;
            $fix = Post::where('id', $request['id'])
                ->update(
                    ['fix' => $fix]
                );
            return response()->json(['fix' => $fix]);
        }
        return response()->json(['message' => 'No recording rights', 'fix' => false]);
    }
    public function delete(idPostRequest $request, Auth $authAction)
    {
        if ($authAction->role() === true) {
            $delete = Post::where('id', $request['id'])
                ->delete();
            return response()->json(['delete' => $delete]);
        }
        return response()->json(['message' => 'No delete', 'delete' => false]);
    }
}
