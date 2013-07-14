<?php
session_start();
echo 'sharegoogle';
echo $_GET['baseAlbumId'];
echo $_GET['sourceURL'];
$shareURL=$_GET['sourceURL'];
header('location:https://plus.google.com/share?url='.$shareURL);
?>
