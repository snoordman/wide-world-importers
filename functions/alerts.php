<?php
// maak een functie aan die alle alerts echot die een een session staan.
function alert_msg(){
    // kijk of de session alertMsg gezet is zo ja loop er dan door de array alert_type in de session
    // en echo een alert div met een message er in voor elke alert die is gezet
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
    // kijk of de session alertMsg gezet is
    // zo ja push dan een nieuwe alert en alert type in de session alertMsg
    // zo niet maak dan de session en zet er 2 arrays in met de variable type en alert als waarde
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
    // loop door de meegestuurde array fields
    // zet de variable message voor het huidige item met de waarde van de variable message plus de index i van de fields array
    // als de variable i niet gelijk is aan de lengte van de array fields - 1 voeg dan een comma toe aan de variable message
    for($i = 0; $i < count($fields); $i++){
        $message = $message . $fields[$i];
        if($i !== count($fields) - 1){
            $message = $message . ", ";
        }
    }
    // roep de alert_msg_push function aan en zet de variable alerttype als type alert en de variable message als alert message
    alert_msg_push($alertType, $message);
}