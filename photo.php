<?php
session_start();
//echo $_GET['albumId'];
require 'lib/facebook/facebook.php';
require 'config/facebook.php';
$ses_user = '';
$returnAlbumPhotos = array();
if (isset($_SESSION['User'])) {
    //echo "Session is not emty";
    $ses_user = $_SESSION['User'];
}
if (empty($ses_user)) {
    session_destroy();
    header("location: index.php");
} else {
    $albums = new Facebook(array(
        'appId' => $fb['appID'],
        'secret' => $fb['appSecret']
    ));
    try {
        $accessToken = $_SESSION['AccessToken'];

        if ($accessToken) {
            $albums->setAccessToken($accessToken);
            $userId = $_SESSION['User']['id'];
        }
        $returnAlbumPhotos = $albums->api(array(
            'method' => 'fql.query',
            'query' => 'SELECT src_big,src,src_big_width,src_big_height,caption FROM photo where album_object_id="' . $_GET['albumId'] . '";',
        ));
    } catch (Exception $e) {
        header("location: ErrorPage.php");
    }
    ?>
    <html>
        <title>
            Facebook Application
        </title>
        <head>
            <link href="styleAlbums.css" rel="stylesheet" type="text/css" ></link>
            <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" ></link>
            <link href="lib/liquidslider-master/css/liquid-slider.css" rel="stylesheet" type="text/css" media="screen" >
            <script src="js/jquery.min.js"></script>
            <script src="lib/liquidslider-master/js/jquery.easing.1.3.js"></script>
            <script src="lib/liquidslider-master/js/jquery.touchSwipe.min.js"></script>
            <script src="lib/liquidslider-master/js/jquery.liquid-slider.min.js"></script>
            <script>
                $(function() {
                  $('#slider-id').liquidSlider({
                      hoverArrows:false,
                      keyboardNavigation:true,
                      preloader:true,
                      autoSlideInterval:5000
                  });
                });
            </script> 
        </head>
        <body>
<div id="container" class="row-fluid">
            <div class="banner">
                <div class="details">
                    <div class="profilePic"><img src="https://graph.facebook.com/<?php echo $ses_user['id'] ?>/picture" width="30" height="30" style="border-radius:20px";/></div><div  class="profileName">Welcome <?php echo $ses_user['name'] ?>...!!</div>
                    <div class="logoutButton"><a href="<?php echo $_SESSION['logout'] ?>">Logout</a></div>
                    <br>
                </div>
            </div>
            <?php
            ?>
            <div class="sliderHolder">
                <div class="liquid-slider"  id="slider-id">
    <?php
    if (!empty($returnAlbumPhotos)) {
        foreach ($returnAlbumPhotos as $photo) {
            ?><div>
                                <p class="photoCaption"><?php echo $photo['caption'] ?></p>
                                <a target="blank" href="shareGoogle.php?sourceURL=<?php echo $photo['src_big']; ?>&baseAlbumId=<?php echo $_GET['albumId'] ?>" class="btn btn-primary">Share on Google+</a>
                                <img class="photoSlider" src="<?php echo $photo['src_big']; ?>" style=height:"<?php echo $photo['src_big_height'] ?>px";width:"<?php echo $photo['src_big_width'] ?>px"></img>
                            </div>
        <?php }
    }
} ?>
            </div>
        </div>
    </div> 
</body>
</html>
