<?php

namespace App\Controller;

use Application\Service\TwitterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RedirectController extends AbstractController
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


    public function redirectToTwitter(): Response
    {
        return $this->render('redirect.html.twig', [
            'url' => $this->twitterService->redirect(),
        ]);
    }
}
