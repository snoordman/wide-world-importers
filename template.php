<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Wide World Importers</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <link type="text/css" rel="stylesheet" href="css/chosen.css">

        <link type="text/css" rel="stylesheet" href="css/main.css">
        <link type="text/css" rel="stylesheet" href="css/css_stan.css">

        <link rel="icon" href="afbeeldingen/WWI-logo-links.png"/>

        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <!--bootstrap-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <!--    bootstrap-->
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
                    <li class="nav-item"><a class="nav-link" href="beheertoevoegen.php">Beheer</a></li>
                    <li class="nav-item"><a class="nav-link" href="beheerverwijderen.php">verwijderen</a></li>

                </ul>
                        <form class="form-inline my-2 my-lg-0" method="get" action="browseproduct.php">
                            <input class="form-control mr-sm-2" type="search" name="searchValue" placeholder="Zoeken..">
                            <input type="submit" class="searchbutton" value="Zoek!" name="search">
                        </form>
<?php
                    if(checkLoggedIn() == false) {
                        echo '
                            <li class="nav-item"><a class="nav-link" href="loginpagina.php">Login <i class="fas fa-sign-in-alt"></i></a></li>
                            <li class="nav-item"><a class="nav-link" href="register.php">Registreer <i class="fas fa-user-plus"></i></a></li>
                        ';
                    }else{
                        echo '<li class="nav-item"><a class="nav-link" href="loginpagina.php?logout=true">Log uit <i class="fas fa-sign-out-alt"></i></a></li>';
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
    </body>
</html>
<?php
