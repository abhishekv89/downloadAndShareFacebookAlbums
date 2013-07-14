<?php
session_start();
require 'lib/facebook/facebook.php';
require_once 'config/config.php';
require_once 'config/facebook.php';
$base_url = $config['base_url']; //Read the baseurl from the config.php file
$facebook = new Facebook(array(
    'appId' => $fb['appID'],
    'secret' => $fb['appSecret']
        ));
$accessToken = $facebook->getAccessToken();
$facebook->setAccessToken($accessToken);
$user = $facebook->getUser(); // Get the facebook user id 
if ($user) {
    try {
        $user_profile = $facebook->api('/me');  //Get the facebook user profile data
        //Code working till here.
        $params = array(//'next' => $base_url.'logout.php'
            'next' => 'http://'.$_SERVER['HTTP_HOST'].'/logout.php',
            'access_token' => $facebook->getAccessToken()
        );
        $ses_user = array('User' => $user_profile,
            'logout' => $facebook->getLogoutUrl($params)   //generating the logout url for facebook 
        );
        $_SESSION['User'] = $ses_user['User'];
        $_SESSION['AccessToken'] = $accessToken;
        $_SESSION['logout'] = $ses_user['logout'];
        //print_r($_SESSION);
        error_log($_SESSION);
        session_commit();
        header('Location: ' . $base_url);
        die(0);
    } catch (FacebookApiException $e) {
        //print_r($e);
        error_log($e);
    }
}
header('Location: ' . $base_url);
?>
