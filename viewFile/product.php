<div >
    <?php
        echo "<p>".$product["StockItemName"]."</p>";
        foreach ($photos AS $photo){
            echo '<img src="data:image/jpeg;base64,'.base64_encode($photo["Photo"]) .'">';
        }
    ?>
</div>
<?php
