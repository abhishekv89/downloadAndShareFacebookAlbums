<?php
        
        require_once 'config/config.php';
        session_start();
        $base_url=$config['base_url']; //Read the baseurl from the config.php file
        session_destroy();  //session destroy
        header('Location: '.$base_url);  //redirect to the home page
        ////Code working till here.
?>
