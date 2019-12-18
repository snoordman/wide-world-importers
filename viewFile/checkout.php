<div class="checkout">
    <form method="post" class="login-form">
        <div class="form-group">
            <span class="red">*</span> <label for="phoneNumber">Telefoon nummer: </label>
            <input id="phoneNumber" type="text" class="form-control" placeholder="Telefoonnummer" name="phoneNumber" <?php echo "value='".$user["phoneNumber"] . "' "; ?>>
        </div>
        <span class="red">*</span> <label for="countries">Land: </label>
        <select name="country" data-placeholder="<?php  echo $countryPlaceHolder ?>" id="country" class="chosen form-control">
            <?php
            foreach ($countries as $country){
                echo "<option value='".htmlentities($country["CountryID"])."' ";
                if($country["CountryID"] == $user["country"]){
                    echo "selected ";
                }
                echo ">".htmlentities($country["CountryName"])."</option>";
            }
            ?>
        </select>
        <div class="form-group">
            <span class="red">*</span> <label for="province">Provincie: </label>
            <select data-placeholder="<?php echo $provincePlaceHolder ?>" name="province" id="province" class="chosen">
                <?php
                foreach ($provinces as $province){
                    echo "<option value='".htmlentities($province["StateProvinceID"])."' ";
                    if($province["StateProvinceID"] == $user["province"]){
                        echo "selected ";
                    }
                    echo ">".htmlentities($province["StateProvinceName"])."</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <span class="red">*</span> <label for="city">Stad: </label>
            <select name="city" data-placeholder="<?php echo $cityPlaceHolder ?>" id="city" class="chosen">
                <?php
                foreach ($cities as $city){
                    echo "<option value='".htmlentities($city["CityID"])."' ";
                    if($city["CityID"] == $user["city"]){
                        echo "selected ";
                    }
                    echo ">".htmlentities($city["CityName"])."</option>";
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
            <input class="form-control" type="text" name="zip" id="zip" <?php echo "value='".$user["zip"] . "' "?>>
        </div>
        <div class="form-group">
            <input type="submit" class="form-control btn-primary" value="Registreer" name="submitRegister">
        </div>
    </form>
</div>