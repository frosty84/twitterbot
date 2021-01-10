<?php

namespace Application\EventListener;

use Abraham\TwitterOAuth\TwitterOAuthException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Twig\Environment;

class ExceptionListener
{
    private Environment $twig;
    private LoggerInterface $logger;

    public function __construct(Environment $twig, LoggerInterface $logger)
    {
        $this->twig = $twig;
        $this->logger = $logger;
    }


    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $message = sprintf(
            'Exception: %s with code: %s',
            $exception->getMessage(),
            $exception->getCode()
        );


        if ($exception instanceof TwitterOAuthException) {
            $this->logger->error($message);
            $response = new Response();
            $response->setContent($this->twig->render('connection_error.html.twig'));
            $event->setResponse($response);
        }
    }
}
