<?php
    function createConn(){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $port = 3306;
        $databasename = "wideworldimporters";

        $conn = new mysqli($servername, $username, $password, $databasename, $port);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }

    // PRODUCTS //
    function getProducts($amountResults = 10){
        $conn = createConn();

        $query = $conn->prepare( "
            SELECT  si.StockItemId, si.StockItemName, si.RecommendedRetailPrice, sh.QuantityOnHand
            FROM    stockitems AS si 
            JOIN    stockitemholdings AS sh ON sh.StockItemId = si.StockItemId
            JOIN    stockitemstockgroups AS sisg ON sisg.StockItemID = si.StockItemID
        ");

        $query->execute();
        $products = $query->get_result();

        $conn->close();

        if($products->num_rows > 0){
            return $products->fetch_all(MYSQLI_ASSOC);
        }else{
            return "Geen resultaten";
        }
    }

    function getProductById($id){
        $conn = createConn();

        $query = $conn->prepare("
            SELECT  si.StockItemId, si.StockItemName, si.RecommendedRetailPrice, sh.QuantityOnHand
            FROM    stockitems AS si 
            JOIN    stockitemholdings AS sh ON sh.StockItemId = si.StockItemId
            JOIN    stockitemstockgroups AS sisg ON sisg.StockItemID = si.StockItemID
        ");
    }

    function getProductBySearch($search){
        $conn = createConn();

        $search = "%".$search."%";

        $query = $conn->prepare( "
            SELECT  StockItemId, StockItemName
            FROM    stockitems
            WHERE   StockItemId = ?
            OR      StockItemName LIKE ?
            OR      SearchDetails LIKE ? 
        ");

        $query->bind_param("iss", $search, $search, $search);
        $query->execute();
        $products = $query->get_result();

        $conn->close();

        if($products->num_rows > 0){
            return $products->fetch_all(MYSQLI_ASSOC);
        }else{
            return "Geen resultaten";
        }
    }

    function getProductByCategory($stockGroupId){
        $conn = createConn();
        $clause = implode(',', array_fill(0, count($stockGroupId), '?'));
        $types = str_repeat('i', count($stockGroupId));

        $query = $conn->prepare("
            SELECT si.StockItemId, si.StockItemName
            FROM stockitems AS si
            WHERE si.StockItemId IN (
                SELECT StockItemId
                FROM stockitemstockgroups
                WHERE StockGroupId IN ($clause) 
            )
        ");

        $query->bind_param($types, ...$stockGroupId);
        $query->execute();
        $products = $query->get_result();

        $conn->close();

        if($products->num_rows > 0){
            return $products->fetch_all(MYSQLI_ASSOC);
        }else{
            return "Geen resultaten";
        }
    }
    // PRODUCTS //

    // CATEGORIES //
    function getCategories(){
        $conn = createConn();
        $sql = "
            SELECT stockGroupId, StockGroupName
            FROM stockgroups
        ";

        $query = $conn->prepare($sql);
        $query->execute();
        $categories = $query->get_result()->fetch_all();
        $conn->close();

        if($categories->num_rows > 0){
            return $categories;
        }else{
            return "Geen resultaten";
        }
    }
    // CATEGORIES //
