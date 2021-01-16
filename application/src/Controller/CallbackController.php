<?php


namespace App\Controller;

use Application\Service\TwitterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CallbackController extends AbstractController
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


    public function callbackFromTwitter(Request $request): Response
    {
        if (null !== $request->query->get('denied')) {
            return $this->render('denied.html.twig');
        }

        $oauthToken = $request->query->get('oauth_token');
        $oauthVerifier = $request->query->get('oauth_verifier');

        if (!$oauthToken || !$oauthVerifier) {
            throw new \InvalidArgumentException(sprintf('oauth_token and oauth_verifier are required'));
        }

        printf("<p>oauthToken: %s</p>", $oauthToken);
        printf("<p>oauthVerifier: %s</p>", $oauthVerifier);
        $accessToken = $this->twitterService->accessToken($oauthVerifier);
        return $this->render('callback.html.twig', ['access_token' => $accessToken]);
    }
}
