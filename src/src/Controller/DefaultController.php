<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    public function index(): Response
    {

        return new Response(
            '<html><body><h1>TEST</h1></body></html>'
        );
    }
}