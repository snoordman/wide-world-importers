<?php
require_once "config.php";
require_once "functions/sql.php";
$viewFile = "viewFile/beheerwijzigen.php";

$companyInformation = "";
if(checkPermissions("isSystemUser") || checkPermissions("isSalesPerson")) {

    $conn = createConn();
    $query = $conn->prepare("SELECT KVK, Naam, Adres, Postcode, Telefoon, Email, Plaats FROM Contactinformatie");
    $query->execute();
    $companyInformation = $query->get_result();

    $conn->close();

    if ($companyInformation->num_rows > 0) {
        $companyInformation = $companyInformation->fetch_all(MYSQLI_ASSOC)[0];
    } else {
        $companyInformation = "Geen data";
    }


    if (isset($_POST['submit'])) {
        $KVK = $_POST['KVK'];
        $Naam = $_POST['Naam'];
        $Adres = $_POST['Adres'];
        $Postcode = $_POST['Postcode'];
        $Telefoon = $_POST['Telefoon'];
        $Email = $_POST['Email'];
        $Plaats = $_POST['Plaats'];

        $conn = createConn();
        $query = $conn->prepare("
                    UPDATE contactinformatie
                    SET KVK = ?, Naam = ?, Adres = ?, Postcode = ?, Telefoon = ?, Email = ?, Plaats = ?
                    WHERE KVK = ?
                ");

        $query->bind_param("sssssss", $KVK, $Naam, $Adres, $Postcode, $Telefoon, $Email, $plaats);
        $query->execute();

        $conn->close();

    }
}else{
    alert_msg_push("alert-danger", "U heeft geen rechten om deze pagina te bezoeken");
    header("Location: index.php");
    exit;
}

require_once "template.php";