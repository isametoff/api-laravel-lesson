<?php

namespace App\Http\Controllers\API\Notification;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\NotificationRequest;
use App\Http\Resources\User\NotificationMessagesResource;
use App\Models\UserNotifications;
use Illuminate\Support\Facades\Auth;

class Index extends Controller
{
    public function notificationMessages()
    {
        return NotificationMessagesResource::collection(UserNotifications::where('user_id', Auth::id())
            ->with('transaction')
            ->orderBy('created_at', 'DESC')->get());
    }
    public function read(NotificationRequest $request)
    {
        $userIsRead = 'true';
        foreach ($request['ids'] as $id) {
            UserNotifications::where('user_id', Auth::id())->where('id', $id)->update([
                'read' => 1,
            ]);
            UserNotifications::where('user_id', Auth::id())->where('id', $id)
                ->value('read') != 1 ? $userIsRead = 'false' : '';
        }
        return $userIsRead;
    }

    public function delete(NotificationRequest $request)
    {
        foreach ($request['ids'] as $id) {
            UserNotifications::where('user_id', Auth::id())->where('id', $id)->forceDelete();
        }
        return UserNotifications::where('user_id', Auth::id())
            ->whereIn('id', $request['ids'])->doesntExist() === true ? 'true' : 'false';
    }
}
