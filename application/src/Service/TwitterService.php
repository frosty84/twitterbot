<?php

namespace Application\Service;

use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;

class TwitterService
{
    private string $consumerKey;
    private string $consumerSecret;
    private string $oauthCallback;

    public function __construct(string $consumerKey, string $consumerSecret, string $oauthCallback)
    {
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
        $this->oauthCallback = $oauthCallback;
    }

    /**
     * @return string
     * @throws TwitterOAuthException
     */
    public function redirect(): string {
        //printf("<p>TEST: %s %s</p>", $this->consumerKey, $this->consumerSecret);
        $connection = new TwitterOAuth($this->consumerKey, $this->consumerSecret);
        try{
            $requestToken = $connection->oauth('oauth/request_token', array('oauth_callback' => $this->oauthCallback));
            return $connection->url('oauth/authorize', ['oauth_token' => $requestToken['oauth_token']]);
            //printf("<div><pre>response: \n %s</pre></div>", var_export($request_token, true));
        } catch (TwitterOAuthException $e) {
            //TODO: Add logger and throw exception further
            //printf("<div><pre>Exception!!!: \n %s</pre></div>", $e->getMessage());
            throw $e;
        }
    }
}