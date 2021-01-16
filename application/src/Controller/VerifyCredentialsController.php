<?php


namespace App\Controller;

use Application\Service\TwitterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class VerifyCredentialsController extends AbstractController
{
    private TwitterService $twitterService;
    private SessionInterface $session;

    public function __construct(TwitterService $twitterService, SessionInterface $session)
    {
        $this->twitterService = $twitterService;
        $this->session = $session;
    }


    public function verify(): Response
    {
        $user = $this->twitterService->verify();

        $status = [];
        if (property_exists($user, 'status')) {
            $status = $this->twitterService->status($user->status->id_str);
        }
        $this->session->set('user', $user);
        $this->session->set('status', $status);

        return $this->render('verify.html.twig', [
            'json_user' => \json_encode($user, true),
        ]);
    }
}
