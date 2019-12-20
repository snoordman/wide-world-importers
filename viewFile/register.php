<div class="login-page">
    <form method="post" class="login-form">
        <h1 class="text-center">Registreer</h1>

        <br />
        <div class="form-group"><span class="red">*</span> = verplicht</div>

        <div class="form-group">
            <span class="red">*</span> <label for="firstName">Voornaam: </label>
            <input id="firstName" type="text" class="form-control" placeholder="Voornaam" name="firstName" required="required" <?php if(isset($_POST["firstName"])){ echo "value='".$_POST["firstName"] . "' ";}?>>
        </div>
        <div class="form-group">
            <span class="red">*</span> <label for="lastName">Achternaam: </label>
            <input id="lastName" type="text" class="form-control" placeholder="Achternaam" name="lastName" required="required" <?php if(isset($_POST["lastName"])){ echo "value='".$_POST["lastName"] . "' ";}?>>
        </div>
        <div class="form-group">
            <span class="red">*</span> <label for="email">Email: </label>
            <input id="email" type="text" class="form-control" placeholder="E-mailadres" name="email" required="required" <?php if(isset($_POST["email"])){ echo "value='".$_POST["email"] . "' ";}?>>
        </div>
        <div class="form-group">
            <span class="red">*</span> <label for="phoneNumber">Telefoon nummer: </label>
            <input id="phoneNumber" type="text" class="form-control" placeholder="Telefoonnummer" name="phoneNumber" <?php if(isset($_POST["phoneNumber"])){ echo "value='".$_POST["phoneNumber"] . "' ";}?>>
        </div>
        <div class="form-group">
            <span class="red">*</span> <label for="password">Wachtwoord: </label><br /><label>Moet bestaan uit: 1 klijne letter, 1 hoofletter, 1 cijfer en minimaal 6 karakters lang zijn</label>
            <input id="password" type="password" class="form-control" placeholder="Wachtwoord" name="password">
        </div>
        <div class="form-group">
            <span class="red">*</span> <label for="confirmPassword">Besvestig Wachtwoord: </label>
            <input id="confirmPassword" type="password" class="form-control" placeholder="Bevestig wachtwoord" name="confirmPassword">
        </div>
            <span class="red">*</span> <label for="countries">Land: </label>
            <select name="country" data-placeholder="<?php  echo $countryPlaceHolder ?>" id="country" class="chosen form-control">
                <?php
                foreach ($countries as $country){
                    if(isset($_POST["country"])){
                        echo "<option value='".htmlentities($country["CountryID"])."' ";
                        if($country["CountryID"] == $_POST["country"]){
                            echo "selected ";
                        }
                        echo ">".htmlentities($country["CountryName"])."</option>";
                    }else {
                        echo "<option value='" . htmlentities($country["CountryID"]) . "'>" . htmlentities($country["CountryName"]) . "</option>";
                    }
                }
                ?>
            </select>
        <div class="form-group">
            <span class="red">*</span> <label for="province">Provincie: </label>
            <select data-placeholder="<?php echo $provincePlaceHolder ?>" name="province" id="province" class="chosen">
                <?php
                foreach ($provinces as $province){
                    if(isset($_POST["province"])){
                        echo "<option value='".htmlentities($province["StateProvinceID"])."' ";
                        if($province["StateProvinceID"] == $_POST["province"]){
                            echo "selected ";
                        }
                        echo ">".htmlentities($province["StateProvinceName"])."</option>";
                    }else {
                        echo "<option value='" . htmlentities($province["StateProvinceID"]) . "'>" . htmlentities($province["StateProvinceName"]) . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <span class="red">*</span> <label for="city">Stad: </label>
            <select name="city" data-placeholder="<?php echo $cityPlaceHolder ?>" id="city" class="chosen">
                <?php
                foreach ($cities as $city){
                    if(isset($_POST["city"])){
                        echo "<option value='".htmlentities($city["CityID"])."' ";
                        if($city["CityID"] == $_POST["city"]){
                            echo "selected ";
                        }
                        echo ">".htmlentities($city["CityName"])."</option>";
                    }else {
                        echo "<option value='" . htmlentities($city["CityID"]) . "'>" . htmlentities($city["CityName"]) . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <span class="red">*</span> <label for="address">Adres: </label>
            <input type="text" class="form-control" name="address" id="address" <?php if(isset($_POST["address"])){ echo "value='".$_POST["address"] . "' ";}?>>
        </div>
        <div class="form-group">
            <span class="red">*</span> <label for="zip">Postcoce: </label>
            <input class="form-control" type="text" name="zip" id="zip" <?php if(isset($_POST["zip"])){ echo "value='".$_POST["zip"] . "' ";}?>>
        </div>
<!--        <div class="form-group">-->
<!--            <label for="deliveryMethod">Bezorg methode: </label>-->
<!--            <select name="deliveryMethod" data-placeholder="--><?php //echo $deliveryPlaceHolder ?><!--" id="deliveryMethod" class="chosen">-->
<!--                --><?php
//                foreach ($deliveryMethods as $deliveryMethod){
//                    echo "<option value='".htmlentities($deliveryMethod["DeliveryMethodID"])."'>".htmlentities($deliveryMethod["DeliveryMethodName"])."</option>";
//                }
//                ?>
<!--            </select>-->
<!--        </div>-->
        <?php
        if(checkPermissions("isSystemUser")){
        ?>
            <div class="form-check">
                <input id="systemUser" type="checkbox" class="form-check-input" name="permissions">
                <label for="zip">is SystemUser: </label>
            </div>
            <div class="form-check">

                <input id="systemUser" type="checkbox" class="form-check-input" name="permissions">
                <label for="zip">is SalesPerson: </label>
            </div>
            <div class="form-check">

                <input id="systemUser" type="checkbox" class="form-check-input" name="permissions">
                <label for="zip">is Employee: </label>
            </div>
        <?php
        }
        ?>
        <div class="form-group">
            <input type="submit" class="form-control btn-primary" value="Registreer" name="submitRegister">
        </div>
    </form>
</div>