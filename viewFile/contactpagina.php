<?php
require_once "functions/sql.php";
$viewFile = "viewFile/contactpagina.php";
?>

<div class="contact">
    <div class="row">
        <div class="col-5">
            <h1>Contactformulier</h1>
        </div>
        <div class="col-2"></div>
        <div class="col-5">
            <h1>Onze bedrijfsgegevens</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-5">
            <br>
            <form action="contactpagina.php" method="post" class="formulier">
                <label for="naam"><b>Uw naam:</b></label><br>
                <input id="naam" type="text" class="naam form-control" name="naam" placeholder="naam" required><br>

                <label for="email"><b>Uw e-mail adres:</b></label>
                <br><input id="email" type="email" class="email form-control" name="email" placeholder="e-mail" required><br>

                <label for="Type vraag"><b>Type vraag:</b></label><br>

                <select name="typevraag" id="typevraag" class="typevraag form-control" required onchange="this.form.submit()">
                    <option value="Vraag product" name="Vraag product>">Vraag product</option>
                    <option value="Klacht" name="Klacht">Klacht</option>
                    <option value="Opmerking product" name="Opmerking product">Opmerking product</option>
                </select><br>

                <label for="vraag"><b>Uw vraag:</b></label>
                <br><textarea id="vraag" name="message" rows="3" class="message form-control" required></textarea><br>

                <input type="submit" name="submit" class="form-control btn-primary" value="Verzenden"><br><br>
            </form>
        </div>
        <div class="col-2"></div>
        <div class="col-2">
            <br>
            <?php


            $conn = createConn();
            $query = $conn->prepare("SELECT KVK, Naam, Adres, Postcode, Telefoon, Email, Plaats FROM Contactinformatie");
            $query->execute();
            $query = $query->get_result();

           while ($rows = $query->fetch_assoc()){
               $KVK = $rows['KVK'];
               $Naam = $rows['Naam'];
               $Adres = $rows['Adres'];
               $Postcode = $rows['Postcode'];
               $Telefoon = $rows['Telefoon'];
               $Email = $rows['Email'];
               $Plaats = $rows['Plaats'];

               echo "KVK: " . $KVK . "<br>";
           echo "Bedrijfsnaam: " . $Naam . "<br>";
           echo "Adres: " . $Adres . "<br>";
           echo "Postcode: " . $Postcode . "<br>";
           echo "Telefoon: ". $Telefoon . "<br>";
           echo "Email: " . $Email . "<br>";
           echo "Plaats: " . $Plaats;
           }
           $conn->close();

            if(checkPermissions("isSystemUser") || checkPermissions("isSalesPerson")) {
              echo "<br>";
                echo  "<a href='beheerwijzigen.php." . $rows . "' ><i class=\"fas fa-edit\"></i>Wijzigen</a>";
            }

           ?>

            <br>
            <br>
            <b>Social media</b>
            <br>
            <br>
            <img src="afbeeldingen/instagram.jpg" class="instagram" alt="instagram">
            <br>
            <br>
            <img src="afbeeldingen/facebook.png" class="facebook" alt="facebook">
            <br>
            <br>
            <img src="afbeeldingen/linkedin.jpg" class="linkedin" alt="linkedin">
        </div>
        <div class="col-3">
            <br>
            <div style="width: 100%"><iframe width="100%" height="600" src="https://maps.google.com/maps?width=100%&height=600&hl=nl&q=Campus%202%2C%208017%20CA%20Zwolle+(Windesheim)&ie=UTF8&t=&z=14&iwloc=B&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"><a href="https://www.mapsdirections.info/nl/maak-een-google-map/">Maak een Google Map</a> van <a href="https://www.mapsdirections.info/nl/">Nederland Kaart</a></iframe></div><br />
        </div>
    </div>
</div>
<?php
require_once "template.php";
?>








