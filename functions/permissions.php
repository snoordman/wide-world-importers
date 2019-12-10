<?php
    function checkPermissions($permissionRank){
        if(checkLoggedIn() == true && isset($_SESSION["permissions"][$permissionRank]) && $_SESSION["permissions"][$permissionRank] == 1){
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