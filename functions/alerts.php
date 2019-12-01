<?php
$successAlert = "alert-success";
$warningAlert = "alert-warning";
$errorAlert = "alert-danger";
// maak een functie aan die alle alerts echot die een een session staan.
function alert_msg(){
    if(isset($_SESSION["alertMsg"])){
        for($i = 0; $i < count($_SESSION["alertMsg"]["alert_type"]); $i++){
            echo"
                <div class='alert ".$_SESSION["alertMsg"]["alert_type"][$i]." alert-dismissable fade show'> 
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    ".$_SESSION["alertMsg"]["alert_message"][$i]."
                </div>
            ";
        }
    }
    unset($_SESSION['alertMsg']);
}

// maak een functie die alerts in een session pushed
function alert_msg_push($type, $alert){
    if(isset($_SESSION["alertMsg"])){
        array_push($_SESSION["alertMsg"]["alert_type"], $type);
        array_push($_SESSION["alertMsg"]["alert_message"], $alert);
    }else{
        $_SESSION['alertMsg']=
            array(
                "alert_type" => array (),
                "alert_message" => array()
            );
        array_push($_SESSION["alertMsg"]["alert_type"], $type);
        array_push($_SESSION["alertMsg"]["alert_message"], $alert);
    }
}

function checkRequiredInput($message, $fields, $alertType){
    for($i = 0; $i < count($fields); $i++){
        $message = $message . $fields[$i];
        if($i !== count($fields) - 1){
            $message = $message . ", ";
        }
    }
    alert_msg_push($alertType, $message);
}