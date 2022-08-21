<?php

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
// event broadcastOn name chanel
Broadcast::channel('SendMessageChanel', function () {
    return [
        'message'=> $this->message
    ];
});

//chanel

//https://www.youtube.com/watch?v=qdhnC_FUBbs
//1:05:00
