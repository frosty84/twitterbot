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


    public function start() {
        printf("<p>TEST: %s %s</p>", $this->consumerKey, $this->consumerSecret);
        $connection = new TwitterOAuth($this->consumerKey, $this->consumerSecret);
        try{
            $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => $this->oauthCallback));
            printf("<div><pre>response: \n %s</pre></div>", var_export($request_token, true));
        } catch (TwitterOAuthException $e) {
            printf("<div><pre>Exception!!!: \n %s</pre></div>", $e->getMessage());
        }
        //$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token, $access_token_secret);
        //$content = $connection->get("account/verify_credentials");
    }
}