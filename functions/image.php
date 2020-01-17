<?php

// functie die kijkt of er een default image moet worden geladen of niet
function loadDefault($image, $single = false){
    // zet het pad voor de default image
    $rootPath = "afbeeldingen/";
    $noImagePath = "no_image";
    $extension = ".jpg";

    // kijk of single true is en image null is of image een string is en single false is
    // zo ja return het pad voor de default image en anders false
    if($single == true && $image == null || is_string($image) && $single == false){
        return $rootPath . $noImagePath . $extension;
    }else{
        return false;
    }
}
