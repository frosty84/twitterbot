<?php

namespace Application\EventListener;

use Abraham\TwitterOAuth\TwitterOAuthException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class ExceptionListener
{

    private RouterInterface $router;
    private Environment $twig;

    /**
     * ExceptionListener constructor.
     * @param RouterInterface $router
     * @param Environment $twig
     */
    public function __construct(RouterInterface $router, Environment $twig)
    {
        $this->router = $router;
        $this->twig = $twig;
    }


    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $message = sprintf(
            'My Error says: %s with code: %s',
            $exception->getMessage(),
            $exception->getCode()
        );


        if ($exception instanceof TwitterOAuthException) {
            $uri = $this->router->generate('connection_error');
            $response = new RedirectResponse($uri);
            $response->setContent($this->twig->render('redirect302.html.twig', [
                'uri' => $uri,
            ]));
            $event->setResponse($response);
        }
    }
}
