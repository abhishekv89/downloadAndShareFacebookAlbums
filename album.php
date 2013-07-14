<?php
require 'lib/facebook/facebook.php';
require 'config/facebook.php';
//session_start();
    $albums = new Facebook(array(
        'appId' => $fb['appID'],
        'secret' => $fb['appSecret']
    ));
    try{
    $accessToken = $_SESSION['AccessToken'];
    if ($accessToken) {
        $albums->setAccessToken($accessToken);
        $userId = $_SESSION['User']['id'];
    }
    $returnVar = $albums->api('/' . $userId . '?fields=id,name,albums.fields(cover_photo,photos,name,count)');
    
    }catch(Exception $e)
    {
        error_log($e);
        header("location: ErrorPage.php");
    }
    
