<div class="container">
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
                        <img class="d-block w-100" src="data:image/jpeg;base64, <?php echo base64_encode($photos[$i]["Photo"]) ?>" alt="First slide">
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
                    <img class="d-block w-100" src="<?php echo $image ?>" alt="First slide">
                </div>
            </div>
        </div>
<?php
    }
?>
        </div>
        <div class="col-2"></div>
        <div class="col-6">
            <h1><?php echo $product["StockItemName"] ?></h1>
            <p>€ <?php echo $product["RecommendedRetailPrice"] ?></p>
        </div>
    </div>
</div>

