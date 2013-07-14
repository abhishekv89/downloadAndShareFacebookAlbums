<?php
session_start();
session_destroy();
?>
<html>
    <head>
        <link href="lib/bootstrap/css/bootstrap-responsive.css" rel="stylesheet"></link>
        <link href="lib/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" ></link>
        <link href="styleAlbums.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="container">
            <div class="row-fluid">
                <div class="span4">
                    <div class="btn btn-success">There</div>     
                    <div class="btn btn-info" >Seems </div>
                    <div class="btn btn-inverse">To</div>
                    <div class="btn btn-warning">Be</div>
                    <div class="btn btn-success">An</div>
                    <div class="btn btn-danger">Error..!!!</div>
                    <div class="span8"><a href="index.php">Return to Home Page</a></div>
            </div>
    </body>
</html>


