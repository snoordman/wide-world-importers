<?php

function loadDefault($image, $single = false){
    $rootPath = "afbeeldingen/";
    $noImagePath = "no_image";
    $extension = ".jpg";

    if($single == true && $image == null || is_string($image)){
        return $rootPath . $noImagePath . $extension;
    }else{
        return false;
    }
}
