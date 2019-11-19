<?php

function loadDefault($image){
    $rootPath = "afbeeldingen/";
    $noImagePath = "no_image";
    $extension = ".jpg";

    if(is_string($image)){
        return $rootPath . $noImagePath . $extension;
    }else{
        return false;
    }
}