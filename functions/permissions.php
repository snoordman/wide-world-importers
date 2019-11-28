<?php
    function checkPermissions($permissionRank){
        if(checkLoggedIn() == true && isset($_SESSION[$permissionRank]) && $_SESSION[$permissionRank] == true){
            return true;
        }else{
            return false;
        }
    }

    function checkLoggedIn(){
        if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true){
            return true;
        }else{
            return false;
        }
    }