<?php
if(!isset($_SESSION['user_login'])&&$_SESSION['usertype']!='Vendor'){
        header("location:login.php");
    }