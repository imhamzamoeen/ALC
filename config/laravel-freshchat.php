<?php

/*
 * Freshchat Configurations
 */
return [

    /*
     * Freshchat's Web Messenger Token.
     *
     * You can see that on Web Messenger Settings page of Freshchat Portal.
     */
    'token'      => env('FRESHCHAT_TOKEN', null),

    /*
     * Freshchat's Web Messenger Host Value. ( it would be different based on your data region)
     *
     * Few examples:
     *
     *	https://wchat.freshchat.com
     *	https://wchat.in.freshchat.com
     *
     * You can see that on Web Messenger Settings page of Freshchat Portal.
     */
    'host'       => env('FRESHCHAT_HOST', 'https://wchat.freshchat.com'),
];
