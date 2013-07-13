<?php

session_start();
require 'lib/facebook/facebook.php';
require 'config/facebook.php';
set_time_limit(0);
$albums = new Facebook(array(
    'appId' => $fb['appID'],
    'secret' => $fb['appSecret']
        ));
$accessToken = $_SESSION['AccessToken'];

if ($accessToken) {
    $albums->setAccessToken($accessToken);
    $userId = $_SESSION['User']['id'];
}


$data = json_decode(stripslashes($_POST['albumId']));
$folderName = time();

if (file_exists($folderName)) {
    $folderName = time();
    mkdir($folderName);
} else {
    $folderName = time();
    mkdir($folderName);
}

foreach ($data as $d) {

    $returnAlbumName = $albums->api(array(
        'method' => 'fql.query',
        'query' => 'SELECT name FROM album where object_id="' . $d . ';',
    ));
    foreach ($returnAlbumName as $albumName) {
        
        if (file_exists($albumName['name'])) //if a folder with same name already exists
        {
           mkdir($folderName . '/' . $albumName['name']);
           rename($albumName['name'],$albumName['name'].'(1)'); //renaming the folder adding  (1)
        } 
        else 
        {
           mkdir($folderName . '/' . $albumName['name']); 
        }

        //mkdir($folderName . '/' . $albumName['name']);
        $returnAlbumPhotos = $albums->api(array(
            'method' => 'fql.query',
            'query' => 'SELECT src_big FROM photo where album_object_id="' . $d . ';',
        ));
        foreach ($returnAlbumPhotos as $photo) {
            $fp = fopen($folderName . '/' . $albumName['name'] . '/' . basename($photo['src_big']), 'w');
            fwrite($fp, file_get_contents($photo['src_big']));
            fclose($fp);
        }
    }
    unset($returnAlbumPhotos);
}
//zipping the folders
$sourcefolder = "./"; // Default: "./" 
$zipfilename = "MyAlbums.zip"; // Default: "myarchive.zip"
//$timeout = 0; // Default: 5000
// instantate an iterator (before creating the zip archive, just
// in case the zip file is created inside the source folder)
// and traverse the directory to get the file list.
$dirlist = new RecursiveDirectoryIterator($folderName);
$filelist = new RecursiveIteratorIterator($dirlist);
// set script timeout value 
// instantate object
$zip = new ZipArchive();
// create and open the archive 
if ($zip->open("$zipfilename", ZipArchive::CREATE) !== TRUE) {
    die("Could not open archive");
}
// add each file in the file list to the archive
foreach ($filelist as $key => $value) {
    $zip->addFile(realpath($key), $key) or die("ERROR: Could not add file: $key");
}
// close the archive
$zip->close();

//send the file to browser for download


$file_name = basename($zipfilename);
$size = filesize($zipfilename);

echo $zipfilename;


exit;
?>