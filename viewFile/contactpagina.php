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
                <div class="resultaat">

                <h5><?php echo $result;  ?></h5>
                </div>
                <div class="resultaatfail">
                    <h5><?php echo $resultfail; ?></h5>
                </div>
            </form>
        </div>



        <div class="col-2"></div>
        <div class="col-2">
            <br>
            <b>Adres</b><br>
            Wide World Importers<br>
            Campus 2<br>
            8017 CA Zwolle<br>
            Tel: 088-4699911<br>
            E-mail: info@WWI.nl

            KVK: 85739857398
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








