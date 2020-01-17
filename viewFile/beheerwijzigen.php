<h1>Wijzigen contactinformatie</h1>
<br>

<form action="contactpagina.php" method="post" class="formulier">
    <label for="KVK"><b>KVK:</b></label><br>
    <input id="naam" type="text" class="naam form-control" value="<?php if(is_array($companyInformation)){echo $companyInformation["KVK"];} ?>" name="KVK" ><br>

    <label for="Bedrijfsnaam"><b>Bedrijfsnaam:</b></label>
    <br><input id="Bedrijfsnaam" type="text" class="email form-control" name="Bedrijfsnaam" value="<?php if(is_array($companyInformation)){echo $companyInformation["Naam"];} ?>" ><br>

    <label for="Adres"><b>Adres:</b></label>
    <br><input id="Adres" type="text" class="email form-control" name="Adres" value="<?php if(is_array($companyInformation)){echo $companyInformation["Adres"];} ?>" ><br>

    <label for="Postcode"><b>Postcode:</b></label>
    <br><input id="Postcode" type="text" class="email form-control" name="Postcode" value="<?php if(is_array($companyInformation)){echo $companyInformation["Postcode"];} ?>" ><br>

    <label for="Telefoon"><b>Telefoon:</b></label>
    <br><input id="Telefoon" type="text" class="email form-control" name="Telefoon" value="<?php if(is_array($companyInformation)){echo $companyInformation["Telefoon"];} ?>" ><br>

    <label for="Email"><b>Email:</b></label>
    <br><input id="Email" type="text" class="email form-control" name="Email" value="<?php if(is_array($companyInformation)){echo $companyInformation["Email"];} ?> " ><br>

    <label for="Plaats"><b>Plaats:</b></label>
    <br><input id="Plaats" type="text" class="email form-control" name="Plaats" value="<?php if(is_array($companyInformation)){echo $companyInformation["Plaats"];} ?> " ><br>


    <input type="submit" name="submit" class="form-control btn-primary" value="Verzenden"><br><br>

</form>