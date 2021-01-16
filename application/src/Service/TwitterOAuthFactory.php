<?php


namespace Application\Service;


use Abraham\TwitterOAuth\TwitterOAuth;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TwitterOAuthFactory
{
    private string $consumerKey;
    private string $consumerSecret;
    private SessionInterface $session;

    /**
     * TwitterOAuthFactory constructor.
     * @param string $consumerKey
     * @param string $consumerSecret
     * @param SessionInterface $session
     */
    public function __construct(string $consumerKey, string $consumerSecret, SessionInterface $session)
    {
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
        $this->session = $session;
    }


    public function create(): TwitterOAuth
    {
        $oauthToken = $this->session->get('oauth_token');
        $oauthTokenSecret = $this->session->get('oauth_token_secret');

        $accessToken = $this->session->get('access_token');
        if (null !== $accessToken) {
            //printf("<h3>Access Token found</h3>");
            $oauthToken = $accessToken['oauth_token'];
            $oauthTokenSecret = $accessToken['oauth_token_secret'];
        }

        //printf("<h3>2access token: %s</h3>", $oauthToken);
        //printf("<h3>2access token secret: %s</h3>", $oauthTokenSecret);

        return new TwitterOAuth($this->consumerKey, $this->consumerSecret, $oauthToken, $oauthTokenSecret);
    }

}
