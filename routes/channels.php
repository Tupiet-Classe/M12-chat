<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat-between.{token}', function (User $user, string $token) {
    return ['id' => $user->id, 'name' => $user->name];
});

Broadcast::channel('chat.{userId}', function (User $user, int $userId) {
    return ['id' => $user->id, 'name' => $user->name];
});