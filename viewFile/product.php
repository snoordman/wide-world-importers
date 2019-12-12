<div class="row">
    <div class="col-4">
<?php
    if(!($image = loadDefault($photos))){
?>
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
<?php
                for ($i = 0; $i < count($photos); $i++) {
?>
                <div class="carousel-item <?php if($i == 0){echo "active";} ?>">
                    <img class="d-block w-100" src="data:image/jpeg;base64, <?php echo base64_encode($photos[$i]["Photo"]) ?>" alt="Slide <?php echo $i ?>">
                </div>
<?php
                }
?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <ol class="carousel-indicators carousel-outer">
<?php
            for ($i = 0; $i < count($photos); $i++) {
?>
            <li data-target="#carouselExampleControls" data-slide-to="<?php echo $i ?>" class="active" onclick="changeActive($(this))"> <img class="d-block w-100 img-fluid" src="data:image/jpeg;base64, <?php echo base64_encode($photos[$i]["Photo"]) ?>"></li>
<?php
            }
?>
    </ol>
<?php
}else {
?>
    <div id="carouselExampleControls" class="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="<?php echo $image ?>" alt="Slide 1">
            </div>
        </div>
    </div>
<?php
}
?>
    </div>
    <div class="col-2"></div>
    <div class="col-6">
        <div class="jumbotron">
            <div class="row">
                <h1><?php echo $product["StockItemName"] ?></h1>
            </div>
            <?php
                if(isset($product["MarketingComments"])){
                    displayProduct("Beschrijving: ", $product["MarketingComments"]);
                }else{
                    displayProduct("Beschrijving: ", "Niet aanwezig");
                }

                displayProduct("Prijs: €", $product["UnitPrice"]);
                displayProduct("Voorraad: ", $product["QuantityOnHand"]);
                if(isset($product["Size"]) && $product["Size"] !== ""){
                    if(checkWeightProduct($product["Size"])){
                        displayProduct("Groote: ", $product["Size"]);
                        if(isset($product["TypicalWeightPerUnit"]) && $product["TypicalWeightPerUnit"] !== ""){
                            $weight = $product["TypicalWeightPerUnit"];
                            if($weight < 1){
                                $weight = $weight * 100;
                                displayProduct("Gewicht: ", $weight. "g");
                            }else{
                                displayProduct("Gewicht: ", $weight. "kg");
                            }
                        }
                    }else{
                        displayProduct("Groote: ", $product["Size"]);
                    }
                }else{
                    if(isset($product["TypicalWeightPerUnit"]) && $product["TypicalWeightPerUnit"] !== ""){displayProduct("Gewicht: ", $product["TypicalWeightPerUnit"]. "kg");}
                }
                if(isset($product["Size"]) && $product["Size"] !== ""){displayProduct("Groote: ", $product["Size"]);}
                if(isset($product["ColorName"])){displayProduct("Kleur: ", $product["ColorName"]);}
                if(isset($product["Brand"]) && $product["Brand"] !== ""){displayProduct("Merk: ", $product["Brand"]);}
                if(isset($product["Brand"]) && $product["Brand"] !== ""){displayProduct("Merk: ", $product["Brand"]);}
            ?>
            <div class="row">
                <form method="POST">
                    Hoeveelheid:
                    <input type="number" min="1" max="<?php echo $product["QuantityOnHand"] ?>" name="amountProduct" id="amountProduct" pattern="\d+" value="1">
                    <input type="submit" name="submitProduct">
                </form>
            </div>
        </div>
    </div>
</div>

