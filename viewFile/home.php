<!doctype html>
<html lang="en">
<head>

    <?php include 'index.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<form action="home.php" method="get">
    <input type="text" name="zoekopdracht">
    <input type="submit" value="Zoeken">
</form>

<?php displayProducts($products); ?>

</body>
</html>