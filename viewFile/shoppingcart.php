    <div class="row">
        <div class="col-5">
            Product
        </div>
        <div class="col-2">
            Prijs
        </div>
        <div class="col-3">
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
            <div class='row'>
                <div class='col-5'>
                    <div class='row'>
                        <div class='col-4'>
            ";
            if(!($image = loadDefault($product['photo'], true))){
                echo "             
                            <img class='img-fluid' src='data:image/jpeg;base64, " . base64_encode($product["photo"]) . " ' />
                ";
            }else{
                echo "  
                            <img class='img-fluid' src='" . $image . "' alt='geen afbeelding aanwezig' />
                ";
            }
            echo "
                        </div>
                        <div class='col-8'>
                        " . htmlentities($product['StockItemName']) . "
                        </div>
                    </div>
                </div>
                <div class='col-2'>
                    " . htmlentities(number_format($product["UnitPrice"], 2, ',', '.')) . "
                </div>
                <div class='col-3'>
                    <div class='row'>
                        <div class='col-md-8 col-xs-8 col-sm-6'>
                            <form method='post' name='changeQuantity" . $product["StockItemId"] . "'>
                                <div class='input-group quantity-buttons'>
                                    <span class='input-group-btn'>
                                        <button id='minusQuantity".$product["StockItemId"]."' onclick='changeNumber($(\"#quantity".$product["StockItemId"]."\"), false)' type='button' class='btn btn-danger'>
                                            <i class='fas fa-minus'></i>
                                        </button>
                                    </span>
                                        <input type='hidden' value='".$product["StockItemId"] . "' name='id' />
                                        <input type='number' id='quantity".$product["StockItemId"]."' name='quantity' class='form-control input-number text-center quantity' value='".$product["quantity"] . "' min='1'>
                                    <span class='input-group-btn'>
                                        <button id='plusQuantity".$product["StockItemId"]."' onclick='changeNumber($(\"#quantity".$product["StockItemId"]."\"), true)' type='button' class='btn btn-success'>
                                            <i class='fas fa-plus'></i>
                                        </button>
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div class='col-md-4 col-xs-4 col-sm-6'>
                            <form method='post' name='deleteItem" . $product["StockItemId"] . "'>
                                <span class='input-group-btn'>
                                    <button id='deleteItem".$product["StockItemId"]."' name='deleteItem' type='submit' class='btn btn-danger'>
                                        <i class='fas fa-trash-alt'></i>
                                    </button>
                                </span>
                                <input type='hidden' value='".$product["StockItemId"] . "' name='itemId' />

                            </form>
                        </div>
                    </div>
                </div>
                <div class='col-2'>
                    <div class='subtotal'>" . number_format($product["subTotal"], 2, ",", ".") . "</div>
                </div>
            </div>
            ";
        }
        ?>
            <br />
            <div class="jumbotron shoppingCart">
                <div class="row">
                    <div class="col-auto mr-auto"></div>
                    <div class="col-auto">
                        <table class="table">
                            <thead>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="col">Totaal artikelen(<?php echo number_format($totalProducts, 2, ',', '.') ?>): </th>
                                <td></td>
                                <td><?php echo count($products) ?></td>
                            </tr>
                            <tr>
                                <th scope="col">Verzendkosten:</th>
                                <td></td>
                                <td>€3,95</td>
                            </tr>
                            <tr>
                                <th>Totaal</th>
                                <td></td>
                                <td>€<?php echo number_format($total, 2, ',', '.') ?></td>
                            </tr>
                            </tbody>
                        </table>
                        <form method='post' class='ml-auto' name='purchaseShoppingCart'>
                            <input type="submit" class="btn btn-primary ml-auto" value='Verder naar bestellen' name='submitPurchase' />
                        </form>
                    </div>
                </div>
            </div>
    <?php
    }else{
        echo "
            <div class='row'>
                <div class='col-12'>Geen producten in winkelwagen</div>
            </div>
        ";
    }
?>
