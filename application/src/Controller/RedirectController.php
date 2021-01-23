<?php

namespace App\Controller;

use Application\Service\TwitterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class RedirectController extends AbstractController
{
    private TwitterService $twitterService;
    private SessionInterface $session;

    public function __construct(TwitterService $twitterService, SessionInterface $session)
    {
        $this->twitterService = $twitterService;
        $this->session = $session;
    }


    public function redirectToTwitter(Request $request): Response
    {
        $data = [
            'url' => $this->twitterService->redirect(),
        ];

        $user = $this->session->get('user');
        $status = $this->session->get('status');
        if (null !== $request->query->get('reload')) {
            $user = $this->twitterService->verify();
            $status = [];
            if (property_exists($user, 'status')) {
                $status = $this->twitterService->status($user->status->id_str);
            }
            $this->session->set('user', $user);
            $this->session->set('status', $status);
        }

        if (null !== $user) {
            $data['json_user'] = \json_encode($user, true);
        }
        if (null !== $status) {
            $data['json_status'] = \json_encode($status, true);
        }

        return $this->render('redirect.html.twig', $data);
    }
}
