<?php

return [

    // Error

    'BAD_REQUEST' => [
        'CODE' => 400,
        'MESSAGE' => 'Bad request',
    ],

    'UNAUTHORIZED' => [
        'CODE' => 401,
        'MESSAGE' => 'Unauthorized',
    ],

    'NOT_FOUND' => [
        'CODE' => 404,
        'MESSAGE' => 'Not found',
    ],

    'SERVER_ERROR' => [
        'CODE' => 500,
        'MESSAGE' => 'Internal server error',
    ],


    // Success

    'SUCCESS' => [
        'CODE' => 200,
        'MESSAGE' => 'Operation completed successfully',
    ],

    'CREATED' => [
        'CODE' => 201,
        'MESSAGE' => 'Created successfully',
    ],

    'NO_CONTENT' => [
        'CODE' => 204,
        'MESSAGE' => 'No content',
    ],


    // Authentication

    'REGISTRATION_SUCCESSFUL' => 'Registration successful',

    'REGISTRATION_UNSUCCESSFUL' => 'Registration unsuccessful',

    'LOGIN_SUCCESSFUL' => 'Login successful',

    'LOGIN_UNSUCCESSFUL' => 'Invalid credentials',

    'LOGOUT_SUCCESSFUL' => 'Logout successful',

    'LOGOUT_UNUCCESSFUL' => 'Logout unsuccessful',

    'USER_NOT_FOUND' => 'User not found',

    'CHAT_ROOM_CREATE_MESSAGE_SUCCESSFUL' => 'Message delivered',

    'CHAT_ROOM_CREATE_MESSAGE_UNSUCCESSFUL' => 'Message delivered',

    'CHAT_ROOMS_EMPTY' => 'No rooms available',

    'CHAT_ROOM_NOT_FOUND' => 'Room not found',

    'CHAT_ROOM_MESSAGES_EMPTY' => 'No messages available',

];
