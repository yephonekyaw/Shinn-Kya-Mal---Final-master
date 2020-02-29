<?php

    //config.php

    //Include Google Client Library for PHP autoload file
    require_once 'vendor/autoload.php';

    //Make object of Google API Client for call Google API
    $google_client = new Google_Client();

    //Set the OAuth 2.0 Client ID
    $google_client->setClientId('348776879047-rt9b7oabr3hsja331go7c3ia63m8lkuf.apps.googleusercontent.com');

    //Set the OAuth 2.0 Client Secret key
    $google_client->setClientSecret('qCUSnfG57b_zBtysqx6sXsPn');

    //Set the OAuth 2.0 Redirect URI
    $google_client->setRedirectUri('http://localhost/Shinn-Kya-Mal---Final-master/GoogleLogin/index.php');

    //
    $google_client->addScope('email');

    $google_client->addScope('profile');

    //start session on web page
    session_start();

?>