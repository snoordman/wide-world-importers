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

    <link type="text/css" rel="stylesheet" href="css/main.css">

    <!--bootstrap-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!--    bootstrap-->

    <script src="main.js"></script>
</head>
<body>

<section class="hetmenu">
    <div class="hoofd">
        <a href=""><img src="afbeeldingen/WWI-logo.png" alt="Afbeelding"></a>
        <span class="titlewwikleur1">Wide World </span>
        <span class="titlewwikleur2">Importers</span>
        <a href=""><img src="afbeeldingen/WWI-logo-ConvertImage.png" alt="Afbeelding"></a>
    </div>
    <div class="topnav">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="Bladeren-door-product-pagina.php">Producten</a></li>
            <li><a href="">Contact</a></li>
            <li><a href="">FAQ</a></li>
        </ul>
    </div>
    <form action="/action_page.php" id="carform">
        Firstname:<input type="text" name="fname">
        <input type="submit">
        <br>
        <select name="carlist" form="carform">
            <option value=10>10</option>
            <option value=25>25</option>
            <option value=50>50</option>
            <option value=100>100</option>
        </select>
    </form>

    <p>The drop-down list is outside the form element, but should still be a part of the form.</p>
</section>

</body>
</html>