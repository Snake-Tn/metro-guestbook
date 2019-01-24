<?php
/**
 * Created by PhpStorm.
 * User: a.kooli
 * Date: 23.01.19
 * Time: 21:15
 */

namespace Controller;


use Http\Response;

class IndexController
{
    public function index(){
        return new Response(file_get_contents(__DIR__.'/../../assets/build/index.html'));
    }
}