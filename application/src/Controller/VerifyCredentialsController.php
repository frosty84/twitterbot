<?php


namespace App\Controller;


use Application\Service\TwitterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyCredentialsController extends AbstractController
{
    private TwitterService $twitterService;

    /**
     * RedirectController constructor.
     * @param TwitterService $twitterService
     */
    public function __construct(TwitterService $twitterService)
    {
        $this->twitterService = $twitterService;
    }

    public function verify(): Response
    {
        return $this->render('verify.html.twig');
    }
}
