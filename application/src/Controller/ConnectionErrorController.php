<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ConnectionErrorController extends AbstractController
{
    public function error(): Response
    {
        return $this->render('connection_error.html.twig');
    }
}
