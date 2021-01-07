<?php

namespace App\Controller;

use Application\Service\TwitterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
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

        $url = $this->twitterService->redirect();
//        return new Response(
//            '<html><body><h1>TEST</h1></body></html>'
//        );

        // the template path is the relative file path from `templates/`
        return $this->render('index.html.twig', [
            // this array defines the variables passed to the template,
            // where the key is the variable name and the value is the variable value
            // (Twig recommends using snake_case variable names: 'foo_bar' instead of 'fooBar')
            'url' => $url,
        ]);
    }
}