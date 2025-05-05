<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Broadcast;


Broadcast::routes(['middleware' => ['web', 'auth']]);

Broadcast::channel('private-user.{userId}', function ($user, $userId) {

    return (int) $user->id === (int) $userId;
});

