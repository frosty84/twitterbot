<?php

namespace Application\Service;

use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;
use App\Exception\CouldNotConnectException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TwitterService
{
    private TwitterOAuth $twitterOAuth;
    private string $oauthCallback;
    private SessionInterface $session;

    public function __construct(TwitterOAuth $twitterOAuth, string $oauthCallback, SessionInterface $session)
    {
        $this->twitterOAuth = $twitterOAuth;
        $this->oauthCallback = $oauthCallback;
        $this->session = $session;
    }


    /**
     * @return string
     * @throws TwitterOAuthException
     * @throws CouldNotConnectException
     */
    public function redirect(): string
    {
        $requestToken = $this->twitterOAuth->oauth('oauth/request_token', ['oauth_callback' => $this->oauthCallback]);

        if ($this->twitterOAuth->getLastHttpCode() !== Response::HTTP_OK) {
            throw new CouldNotConnectException();
        }

        $this->session->set('oauth_token', $requestToken['oauth_token']);
        $this->session->set('oauth_token_secret', $requestToken['oauth_token_secret']);

        return $this->twitterOAuth->url('oauth/authorize', ['oauth_token' => $requestToken['oauth_token']]);
    }

    public function accessToken(string $oauthVerifier): array
    {
        $accessToken = $this->twitterOAuth->oauth("oauth/access_token", ["oauth_verifier" => $oauthVerifier]);

        if ($this->twitterOAuth->getLastHttpCode() !== Response::HTTP_OK) {
            throw new CouldNotConnectException();
        }

        $this->session->set('access_token', $accessToken);
        $this->session->remove('oauth_token');
        $this->session->remove('oauth_token_secret');

        return $accessToken;
    }

    public function verify()
    {
        return $this->twitterOAuth->get('account/verify_credentials', ['tweet_mode' => 'extended', 'include_entities' => 'true']);
    }

    public function status(string $idStr)
    {
        return $this->twitterOAuth->get('statuses/show', [
            'id' => $idStr,
            'tweet_mode' => 'extended',
            'include_entities' => 'true'
        ]);
    }
}
