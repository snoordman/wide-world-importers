<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Productnaam</title>

        <!--bootstrap-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!--bootstrap-->

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

        <link type="text/css" rel="stylesheet" href="css/chosen.css">

        <link type="text/css" rel="stylesheet" href="css/main.css">
        <link type="text/css" rel="stylesheet" href="css/css_stan.css">

        <!--bootstrap-->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <!--    bootstrap-->

        <script src="javascript/chosen.jquery.min.js"></script>

        <script src="javascript/main.js"></script>
    </head>
    <body>
        <div class="hetmenu">
            <div class="hoofd">
                <a href="index.php"><img src="afbeeldingen/WWI-logo.png" alt="Afbeelding"></a>
                <span class="titlewwikleur1">Wide World </span>
                <span class="titlewwikleur2">Importers</span>
                <a href="index.php"><img src="afbeeldingen/WWI-logo-ConvertImage.png" alt="Afbeelding"></a>
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
                </ul>
                        <form class="form-inline my-2 my-lg-0" method="get" action="browseproduct.php">
                            <input class="form-control mr-sm-2" type="search" name="searchValue" placeholder="Zoeken..">
                            <input type="submit" class="searchbutton" value="Zoek!" name="search">
                        </form>
                    <li class="nav-item"><a class="nav-link" href="loginpagina.php"><i class="fas fa-sign-in-alt"></i></a></li>
                    <li class="nav-item"><a class="nav-link" href="shoppingcart.php"><i class="fas fa-shopping-cart"></i></a></li>
                </div>
            </nav>
        </div>
        <div class="container page">
        <?php
            if (isset($viewFile) && file_exists($viewFile) ){
                require_once $viewFile;
            }
        ?>
        </div>
    </body>
</html>
<?php
