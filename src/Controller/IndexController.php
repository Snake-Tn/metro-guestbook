<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

namespace Controller;


use Http\Response;

class IndexController
{
    public function index()
    {
        return new Response(file_get_contents(__DIR__ . '/../../assets/build/index.html'));
    }
}