<?php
require '../vendor/autoload.php';
session_start();

// Landing on the page for the first time, setup connection with private application details registered with unsplash and redirect user to authenticate
if (!isset($_GET['code']) && !isset($_SESSION['token'])) {

    \Unsplash\HttpClient::init([
        'applicationId'	=> 'rL2pkCScoonc0-AWvT4Kw5zoIyr2hwC2ku8fx2dup2U',
        'secret'		=> 'QLVY_yiWz9weuAYyhrlBBKCNdJQaTrI5iYJThQeJhpk',
        'callbackUrl'	=> 'http://test.loc/'
    ]);
    $httpClient = new \Unsplash\HttpClient();
    $scopes = ['write_user', 'public'];

    header("Location: ". $httpClient::$connection->getConnectionUrl($scopes));
    exit;
}


// Unsplash sends user back with ?code=XXX, use this code to generate AccessToken
if (isset($_GET['code']) && !isset($_SESSION['token'])) {
    \Unsplash\HttpClient::init([
        'applicationId'	=> 'rL2pkCScoonc0-AWvT4Kw5zoIyr2hwC2ku8fx2dup2U',
        'secret'		=> 'QLVY_yiWz9weuAYyhrlBBKCNdJQaTrI5iYJThQeJhpk',
        'callbackUrl'	=> 'http://unsplash-api.dev'
    ]);

    try {
        $token = \Unsplash\HttpClient::$connection->generateToken($_GET['code']);
    } catch (Exception $e) {
        print("Failed to generate access token: {$e->getMessage()}");
        exit;
    }

    // Store the access token, use this for future requests
    $_SESSION['token'] = $token;
}

// Send requests to Unsplash
\Unsplash\HttpClient::init([
    'applicationId'	=> '{clientId}',
    'secret'		=> '{clientSecret}',
    'callbackUrl'	=> 'http://unsplash-api.dev'
], [
    'access_token' => $_SESSION['token']->getToken(),
    'expires_in' => 30000,
    'refresh_token' => $_SESSION['token']->getRefreshToken()
]);

$httpClient = new \Unsplash\HttpClient();
$owner = $httpClient::$connection->getResourceOwner();

print("Hello {$owner->getName()}, you have authenticated successfully");