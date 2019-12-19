    <div class="row">
        <div class="col-12"><h1>Bestellingen</h1></div>
    </div>
    <br />
    <br />
<?php
if($orders !== false){
    $subtotal = 0;
    for($i = 0; $i < count($orders); $i++){
        $subtotal += $orders[$i]["UnitPrice"];
        if($i == 0 || $orders[$i]["OrderID"] !== $orders[$i - 1]["OrderID"]) {
            echo '
                <div class="row bold">
                    <div class="col-12">Bestellingnummer: ' . $orders[$i]["OrderID"] . '</div>
                </div> 
                <div class="row">
                    <div class="col-3 bold">
                        Product
                    </div> 
                    <div class="col-2 bold">
                        Hoeveelheid
                    </div>                        
                    <div class="col-2 bold">
                        Besteldatum
                    </div>                     
                    <div class="col-3 bold">
                        Verwachte leverdatum
                    </div>
                    <div class="col-2 bold">
                        Prijs
                    </div>
                </div>
            ';
        }
        echo '
                <div class="row orders">
                    <div class="col-3">
                        ' . $orders[$i]["StockItemName"] . '
                        <div class="row">
                            <div class="col-12">'.  $orders[$i]["Description"] . '</div>
                        </div>
                    </div>
                                  
                    <div class="col-2">
                        ' . number_format($orders[$i]["PickedQuantity"], 2, ',', '.') . '
                    </div>                    
                    <div class="col-2">
                        ' . $orders[$i]["OrderDate"] . '
                    </div>                    
                    <div class="col-3">
                        ' . $orders[$i]["ExpectedDeliveryDate"] . '
                    </div>
                    <div class="col-2">
                        €' . $orders[$i]["UnitPrice"] . '
                    </div>  
                </div>
        ';
        if($i == (count($orders) - 1) || $orders[$i]["OrderID"] !== $orders[$i + 1]["OrderID"]) {
            echo '
                <div class="row orderTotal">
                    <div class="col-9"></div>
                    <div class="col-1 total">Totaal:</div>
                    <div class="col-2">€'.number_format($subtotal, 2, ',', '.').'</div>
                </div>
                <br />
            '
            ;
            $subtotal = 0;
        }
    }
}

