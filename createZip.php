<?php
session_start();
require 'lib/facebook/facebook.php';
require 'config/facebook.php';
try {
    $imageArray = array();
    $albums = new Facebook(array(
        'appId' => $fb['appID'],
        'secret' => $fb['appSecret']
    ));
    $accessToken = $_SESSION['AccessToken'];
    if ($accessToken) {
        $albums->setAccessToken($accessToken);
        $userId = $_SESSION['User']['id'];
    }
    $returnAlbumPhotos = $albums->api(array(
        'method' => 'fql.query',
        'query' => 'SELECT src_big FROM photo where album_object_id="' . $_GET['albumId'] . '";',
    ));
    foreach ($returnAlbumPhotos as $photo) { {
            $imageArray[] = $photo['src_big'];
        }
    }
    $zip = new ZipArchive();
    $tmp_file = '' . $_GET['albumName'] . '.zip'; //tempnam('.','');
    $zip->open($tmp_file, ZipArchive::CREATE);

    foreach ($returnAlbumPhotos as $photo) {

        $download_file = file_get_contents($photo['src_big']);

        $zip->addFromString(basename($photo['src_big']), $download_file);
    }

    $zip->close();

    $file_name = basename($tmp_file);
    $size = filesize($tmp_file);
    header("Content-Type: application/zip");
    header("Content-Disposition: attachment; filename=$file_name");
    readfile($tmp_file);
    unlink($tmp_file);
} catch (Exception $e) {
    header('Location:ErrorPage.php');
}
exit;
?>


