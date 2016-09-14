<?php
require_once('fb.php');
require_once('dal/user.php');

if (!Auth::isLoggedIn()) {
    $fb = FB::getApp();
    $helper = $fb->getRedirectLoginHelper();
    $accessToken = $helper->getAccessToken();

    if (!$accessToken) {
        if ($helper->getError()) {
            Server::sendStatus(401, [
                'Error' => $helper->getError(),
                'Error Code' => $helper->getErrorCode(),
                'Error Reason' => $helper->getErrorReason(),
                'Error Description' => $helper->getErrorDescription()
            ]);
        } else {
            Server::sendStatus(400);
            echo 'Bad request';
        }
        exit;
    }

    $oAuth2Client = $fb->getOAuth2Client();
    $tokenMetadata = $oAuth2Client->debugToken($accessToken);
    $tokenMetadata->validateAppId(FB::getAppID());
    $tokenMetadata->validateExpiration();
    if (!$accessToken->isLongLived()) {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    }

    $response = $fb->get('/me?fields=id,name,first_name,middle_name,last_name,email', $accessToken);
    $fb_user = $response->getGraphUser()->asArray();
    list($user, $is_first_login) = DAL_User::lookupOrCreate($fb_user);
    Auth::login($accessToken, $user, $is_first_login);
}

$redirect_url = array_get($_GET, 'r', 'index.php');
Server::redirect($redirect_url);
