<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ClearSessionController extends AbstractController
{
    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }


    public function clear(): Response
    {
        $this->session->clear();
        return $this->redirectToRoute('redirect');
    }
}
