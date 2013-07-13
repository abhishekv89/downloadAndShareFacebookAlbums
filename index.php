<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Facebook Application</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"></meta>
        <link href="lib/bootstrap/css/bootstrap-responsive.css" rel="stylesheet"></link>
        <link href="styleAlbums.css" rel="stylesheet" type="text/css" ></link>
        <link href="lib/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" ></link>
        <script src="js/jquery.min.js"></script>
        <script src="lib/bootstrap/js/bootstrap.js"></script>
        <script src="lib/spin/spin.js"></script>
        <script src="js/jquery.touchSwipe.min.js"></script>
        <script src="js/commonfunctions.js"></script>
        <script>
               function checkBoxes()
                {
                    var domObjects = $("#container input:checkbox").get();
                    var idArray = [];  //array that would hold the id of all the checkBoxes
                    var nameArray = [];  //array that would hold the name of the checkboxes

                    $("#container input:checkbox:checked").each(function() {
                        idArray.push(this.id);
                    });

                    var idArrayLength = idArray.length;

                    if (idArrayLength > 0)
                    {
                        callAjaxScript(idArray);
                    }
                    else
                    {
                        $("#link").append('<p>Your have not selected any album </p>');
                        $('#myModal').modal();

                        $('#myModal').on('hidden', function() {
                }
                function downloadAll()
                {
                    var domObjects = $("#container input:checkbox").get();

                    var idArray = [];
                    $("#container input:checkbox").each(function() {
                        idArray.push(this.id);
                    });

                    var idArrayLength = idArray.length;

                    console.log(idArray);
                    console.log(idArrayLength);
                    if (idArrayLength > 0)
                    {
                        callAjaxScript(idArray);
                        alert('Your Compelte Album would be downloaded shortly...!!');
                    }
                    else
                    {
                        alert('You Have Not Selected Any Album To Download...!!');
                    }
                }
                function callAjaxScript(idArray)
                {

                    var opts = {
                        lines: 11, // The number of lines to draw
                        length: 36, // The length of each line
                        width: 6, // The line thickness
                        radius: 30, // The radius of the inner circle
                        corners: 1, // Corner roundness (0..1)
                        rotate: 19, // The rotation offset
                        direction: 1, // 1: clockwise, -1: counterclockwise
                        color: '#000', // #rgb or #rrggbb
                        speed: 0.9, // Rounds per second
                        trail: 73, // Afterglow percentage
                        shadow: true, // Whether to render a shadow
                        hwaccel: false, // Whether to use hardware acceleration
                        className: 'spinner', // The CSS class to assign to the spinner
                        zIndex: 2e9, // The z-index (defaults to 2000000000)
                        top: 'auto', // Top position relative to parent in px
                        left: 'auto' // Left position relative to parent in px
                    };
                    var target = document.getElementById('container');
                    var spinner = new Spinner(opts).spin(target);  //initializing the spinner
                    $("#grid").css('visibility', 'hidden');
                    $(".downloadSelected").css('visibility', 'hidden');

                    var jsonString = JSON.stringify(idArray);

                    $.ajax({
                        url: "downloadSelected.php",
                        type: "POST",
                        data: {albumId: jsonString},
                        complete: function(data) {
                            $("#grid").css('visibility', 'visible');
                            $(".downloadSelected").css('visibility', 'visible');
                            $("#link").append('<a href=' + data.responseText + ' onclick="removeLink();">Your Download Link</a>');
                            $('#myModal').modal();
                            spinner.stop();
                            $('#myModal').on('hidden', function() {
                                removeLink();
                            })

                        },
                        error: function(data) {
                            $("#grid").css('visibility', 'visible');
                            $(".downloadSelected").css('visibility', 'visible');
                            $("#link").append('<p>There seems to be some problem.Please try again later.<p>');
                            $('#myModal').modal();
                            spinner.stop();
                            $('#myModal').on('hidden', function() {
                                removeLink();
                            })
                        }
                    })
                }
                function removeLink()
                {
                    var html = ''
                    $("#link").html(html);
                    $('#myModal').modal('hide');
                    $('#myModal').on('hidden', function() {
                        uncheckBoxes();
                    })
                }
                function uncheckBoxes()
                {
                    (function($) {

                        $.fn.checked = function(value) {
                            if (value === true || value === false) {
                                // Set the value of the checkbox
                                $(this).each(function() {
                                    this.checked = value;
                                });
                            } else if (value === undefined || value === 'toggle') {
                                // Toggle the checkbox
                                $(this).each(function() {
                                    this.checked = !this.checked;
                                });
                            }
                        };
                    })(jQuery);
                    $(function() {
                        $("#container input:checkbox").each(function() {
                            $(':checkbox').checked(false);
                        });
                    });
                }
                function preloader()
                {
                    var opts = {
                        lines: 11, // The number of lines to draw
                        length: 36, // The length of each line
                        width: 6, // The line thickness
                        radius: 30, // The radius of the inner circle
                        corners: 1, // Corner roundness (0..1)
                        rotate: 19, // The rotation offset
                        direction: 1, // 1: clockwise, -1: counterclockwise
                        color: '#000', // #rgb or #rrggbb
                        speed: 0.9, // Rounds per second
                        trail: 73, // Afterglow percentage
                        shadow: true, // Whether to render a shadow
                        hwaccel: false, // Whether to use hardware acceleration
                        className: 'spinner', // The CSS class to assign to the spinner
                        zIndex: 2e9, // The z-index (defaults to 2000000000)
                        top: 'auto', // Top position relative to parent in px
                        left: 'auto' // Left position relative to parent in px
                    };
                    var target = document.getElementById('container');
                    var spinner = new Spinner(opts).spin(target);  //initializing the spinner
                    $("#grid").css('visibility', 'hidden');
                    $(".downloadSelected").hide();
                    var setTimer = setTimeout(function() {
                        spinner.stop();
                        $("#grid").css('visibility', 'visible');
                        clearTimeout(setTimer);
                        $(".downloadSelected").show();
                    }, 10000);
                }
            </script>
        <?php

        require_once 'config/config.php';
        $base_url = $config['base_url'];
        session_start();
        $ses_user = '';

        if (isset($_SESSION['User'])) {
            //echo "Session is not emty";
            $ses_user = $_SESSION['User'];
        }

        if (!empty($ses_user)) {
            require 'album.php';
            ?>
            
    </head>
        <body>            
            <div id="container" class="row-fluid">
                <div class="row-fluid show-grid">
                    <div class="span6">
                        <div class="profilePic" href="index.php"><img src="https://graph.facebook.com/<?php echo $ses_user['id'] ?>/picture" width="30" height="30" style="border-radius:20px";/></div><div  class="profileName"><span style="font-size: 17px;">Welcome</span> <?php echo $ses_user['name'] ?>...!!</div>
                        <div class="logoutButton"><a href="<?php echo $_SESSION['logout'] ?>">Logout</a></div>
                        <br>
                    </div>
                    <div class="span6">
                        <div id="downloadSelected"><button class="downloadSelected" type="button" data-backdrop="" onclick="checkBoxes();">Download Selected</button></div>
                        <div id="downloadAll"><button class="downloadSelected" type="button" data-backdrop="" onclick="downloadAll();">Download All</button></div>
                    </div>
                </div>
                <?php
                if ($returnVar['albums']['data']) {
                    $totalAlbums = count($returnVar['albums']['data']);
                    ?>
                    <div id="grid" class="albumHolder row-fluid show-grid">
                    <?php
                    for ($i = 0; $i < $totalAlbums; $i++) {
                        $sourceImage = $returnVar['albums']['data'][$i]['photos']['data'][0]['source'];
                        ?>
                            <div class="coverHolder">
                                <img  class="albumCoverPhoto" src=<?php echo $sourceImage ?>></img>
                                <div class="coverPicTitleHolder">
                                    <div class="spoiler">
                                        <div class="arrow"></div>
                                    </div>
                                    <div class="titleText">
                                        <input id="<?php echo $returnVar['albums']['data'][$i]['id'] ?>" type="checkbox" data="<?php echo $returnVar['albums']['data'][$i]['name'] ?>" style="position:relative;display:inline-block;margin-bottom: 11px;"/>
                                        <a style="text-decoration: none;color:black;font-size: 18px;" href="photo.php?albumId=<?php echo $returnVar['albums']['data'][$i]['id'] ?>"><?php echo $returnVar['albums']['data'][$i]['name'] ?></a>
                                    </div>
                                    <div class="downloadButton"><a style="text-decoration: none;color:black;font-size: 12px;" onclick="preloader();" href="createZip.php?albumId=<?php echo $returnVar['albums']['data'][$i]['id'] ?>&albumName=<?php echo $returnVar['albums']['data'][$i]['name'] ?>">Download Album</a></div>
                                </div>
                           </div>
                        <?php
                    }
                } 
                else 
                {
                    header("location: ErrorPage.php");
                }
            } 
            else 
            {
                ?>
                    <div class="row-fluid show-grid" style="position:fixed;">
                        <div class="loginButton">
                            <img src='images/facebook.png' id='facebook' style='cursor:pointer;float:left;margin-left:550px'/>
                        </div>
                    </div>
                    <div class="introScreen"> View and Download Your Albums..!!Simple
                    </div>
            <?php }
            ?>    
                <!-- Modal -->
                <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <h3 id="myModalLabel" class="fontStyle" style="text-align: center;">Attention Please..!!!</h3>
                    </div>
                    <div class="modal-body">
                        <p id="link" style="text-align: center;"></p>
                    </div>
                </div>
                  <!-- Modal Ends -->

                <div id="fb-root"></div>
                <script type="text/javascript">
                    <?php
                    require "config/facebook.php";
                    ?>
                    window.fbAsyncInit = function() {
                        //Initiallize the facebook using the facebook javascript sdk
                        FB.init({
                            appId: '<?php echo $fb['appID']; ?>', // App ID 
                            cookie: true, // enable cookies to allow the server to access the session
                            status: true, // check login status
                            xfbml: true, // parse XFBML
                            oauth: true //enable Oauth 
                        });
                    };
                    //Read the baseurl from the config.php file
                    (function(d) {
                        var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
                        if (d.getElementById(id)) {
                            return;
                        }
                        js = d.createElement('script');
                        js.id = id;
                        js.async = true;
                        js.src = "//connect.facebook.net/en_US/all.js";
                        ref.parentNode.insertBefore(js, ref);
                    }(document));
                    //Onclick for fb login
                    $('#facebook').click(function(e) {
                        FB.login(function(response) {
                            if (response.authResponse) {
                                parent.location = '<?php echo $base_url; ?>login.php'; //redirect uri after closing the facebook popup
                            }
                        }, {scope: 'user_location,user_photos,friends_photos,publish_actions'}); //permissions for facebook
                    });
                </script>
            </div>
        </body>
</html>