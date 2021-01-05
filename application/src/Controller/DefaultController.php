<?php

namespace App\Controller;

use Application\Service\TwitterService;
use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    private TwitterService $twitterService;

    /**
     * DefaultController constructor.
     * @param TwitterService $twitterService
     */
    public function __construct(TwitterService $twitterService)
    {
        $this->twitterService = $twitterService;
    }


    public function index(): Response
    {

        $this->twitterService->start();
        return new Response(
            '<html><body><h1>TEST1</h1></body></html>'
        );
    }
}