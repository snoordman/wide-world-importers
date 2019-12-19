<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Wide World Importers</title>

        <link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="fontawesome/css/all.css" crossorigin="anonymous">
        <link type="text/css" rel="stylesheet" href="css/chosen.css">

        <link type="text/css" rel="stylesheet" href="css/main.css">
        <link type="text/css" rel="stylesheet" href="css/css_stan.css">

        <link rel="icon" href="afbeeldingen/WWI-logo-links.png"/>

        <script src="javascript/jquery.js" crossorigin="anonymous"></script>
<!--    bootstrap   -->
        <script src="javascript/popper.min.js" crossorigin="anonymous"></script>
        <script src="javascript/bootstrap.min.js" crossorigin="anonymous"></script>
<!--    bootstrap   -->
        <script src="javascript/chosen.jquery.min.js"></script>

        <script src="javascript/main.js"></script>
    </head>
    <body>
        <div class="hetmenu">
            <div class="hoofd">
                <a href="index.php"><img src="afbeeldingen/WWI-logo-links.png" alt="Afbeelding"></a>
                <span class="titlewwikleur1">Wide World</span>
                <span class="titlewwikleur2">&nbsp;Importers</span>
                <a href="index.php"><img src="afbeeldingen/WWI-logo-rechts.png" alt="Afbeelding"></a>
            </div>
            <nav class="topnav navbar navbar-expand-lg navbar-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="mr-auto navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="browseproduct.php">Producten</a></li>
                    <li class="nav-item"><a class="nav-link" href="contactpagina.php">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="faqpagina.php">FAQ</a></li>

<?php
                    if(checkLoggedIn()){
                        echo '
                            <li class="nav-item"><a class="nav-link" href="orders.php">Bestellingen</a></li>
                        ';
                    }
                    if(checkPermissions("isSystemUser") || checkPermissions("isSalesPerson")) {
?>
                    <li class="nav-item"><a class="nav-link" href="beheertoevoegen.php">Toevoegen product</a></li>

<?php
                    }
 ?>
                </ul>
                    <form class="form-inline my-2 my-lg-0" method="get" action="browseproduct.php">
                        <input class="form-control mr-sm-2" type="search" name="searchValue" placeholder="Zoeken..">
                        <input type="submit" class="btn btn-primary" value="Zoek!" name="search">
                    </form>
<?php
                    echo '
                        <li class="nav-item shoppingCartButton">
                            <a class="nav-link" href="shoppingcart.php">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                    ';
                    if(isset($_SESSION["shoppingCart"])){
                        echo '<span class="shoppingCartAmount">' . count($_SESSION["shoppingCart"]) . '</span>';
                    }
                    echo '
                        </li>
                    ';
                    if(checkLoggedIn() == false) {
                        echo '
                            <li class="nav-item"><a class="nav-link" href="loginpagina.php">Login <i class="fas fa-sign-in-alt"></i></a></li>
                            <li class="nav-item"><a class="nav-link" href="register.php">Registreer <i class="fas fa-user-plus"></i></a></li>
                        ';
                    }else{
                        echo '<li class="nav-item"><a class="nav-link" href="loginpagina.php?logout=true">Log uit <i class="fas fa-sign-out-alt"></i></a></li>';
                        if(checkPermissions("isSystemUser")){
                            echo '<li class="nav-item"><a class="nav-link" href="register.php">Registreer <i class="fas fa-user-plus"></i></a></li>';
                        }
                    }
?>
                </div>
            </nav>
        </div>
        <div class="container page">
        <?php
        alert_msg();
        if (isset($viewFile) && file_exists($viewFile) ){
                require_once $viewFile;
            }
        ?>
        </div>
        <footer class="footer">
            <div class="row mr-0">
                <div class="col-4 footer-column">
                    <img class="img-fluid" src="afbeeldingen/WWI-logo.png">
                </div>
                <div class="col-8">
                    <br />
                    <div class="row">
                        <div class="col-12">
                            <b>Wide world importers</b><br>
                            Campus 2<br>
                            8017CA Zwolle<br>
                            Tel: 088-4699911<br>
                            E-mail: info@WWI.nl<br>
                            KVK: 85739857398
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mr-0">
                <div class="col-12 footer-column">
                    2019 WideWorldImporters - Alle rechten voorbehouden
                </div>
            </div>
        </footer>
    </body>
</html>
<?php
