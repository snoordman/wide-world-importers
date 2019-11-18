<div >
    <div class="row">
        <div class="col-2">
            <h1>Producten</h1>
        </div>
        <div class="col-8">
        </div>
        <div class="col-2">
        </div>
    </div>
    <?php
        foreach ($products as $product){
            echo "
                <p>".$product["stockItemName"]."</p>
            ";
        }
    ?>
</div>
<?php
