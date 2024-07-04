<?php

namespace App\Controllers;

use Nouracea\Nouramework\Http\Response;

class PostController
{
    public function show(int $id): Response
    {
        $content = "<h1>Post id -- $id</h1>";

        return new Response($content);
    }
}
