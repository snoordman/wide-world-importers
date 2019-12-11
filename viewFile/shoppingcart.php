    <div class="row">
        <div class="col-6">
            Product
        </div>
        <div class="col-2">
            Prijs
        </div>
        <div class="col-2">
            Hoeveelheid
        </div>
        <div class="col-2">
            Subtotaal
        </div>
    </div>
<?php
    if(isset($_SESSION["shoppingCart"])){
        foreach ($products as $product) {
            echo "
            <form method='post' name='changeQuantity'>
                <div class='row'>
                    <div class='col-6'>
                        <div class='row'>
                            <div class='col-3'>
            ";
            if($product["photo"] !== null){
            echo "              <img class='img-fluid' src='data:image/jpeg;base64, " . base64_encode($product['photo']) . " ' />";
            }else{
            echo "  
                                <img class='img-fluid' src='afbeeldingen/no_image.jpg' alt='geen afbeelding aanwezig' />
            ";
            }
            echo "
                            </div>
                            <div class='col-9'>
                            " . htmlentities($product['StockItemName']) . "
                            </div>
                        </div>
                    </div>
                    <div class='col-2'>
                        " . htmlentities(number_format($product["UnitPrice"], 2, ',', '.')) . "
                    </div>
                    <div class='col-2'>
                        <div class='input-group quantity-buttons'>
                            <span class='input-group-btn'>
                                <button id='minusQuantity' type='button' class='btn btn-danger'>
                                    <i class='fas fa-minus'></i>
                                </button>
                            </span>
                                <input type='hidden' value='".$product["StockItemId"] . "' name='id' />
                                <input type='number' id='quantity' name='quantity' class='form-control input-number text-center' value='".$product["quantity"] . "' min='1'>
                            <span class='input-group-btn'>
                                <button id='plusQuantity' type='button' class='btn btn-success'>
                                    <i class='fas fa-plus'></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class='col-2'>
                        <div class='subtotal'>" . number_format($product["UnitPrice"] * $product["quantity"], 2, ",", ".") . "</div>
                    </div>
                </div>
            </form>
            ";
        }
    }else{
        echo "
            <div class='row'>
                <div class='col-12'>Geen producten in winkelwagen</div>
            </div>
        ";
    }


?>