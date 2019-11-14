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

    function closeConn(mysqli $conn) {
        $conn->close();
    }

    function getProducts(mysqli $conn){
        $sql = "
            SELECT  si.StockItemId, si.StockItemName, si.RecommendedRetailPrice, sh.QuantityOnHand
            FROM    stockitems AS si 
            JOIN    stockitemholdings AS sh ON sh.StockItemId = si.StockItemId
            JOIN    stockitemstockgroups AS sisg ON sisg.StockItemID = si.StockItemID
        ";
        $query = $conn->prepare($sql);

        return $query->get_result()->fetch_all();
    }

    function getProductByCategory(mysqli $conn, $stockGroupId){
        $clause = implode(',', array_fill(0, count($stockGroupId), '?'));
        $types = str_repeat('i', count($stockGroupId));

        $stmt = $conn->prepare("
            SELECT si.StockItemId, si.StockItemName
            FROM stockitems AS si
            WHERE si.StockItemId IN (
                SELECT StockItemId
                FROM stockitemstockgroups
                WHERE StockGroupId IN ($clause) 
            )
        ");

        $stmt->bind_param($types, ...$stockGroupId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all();
    }

    function getCategories(mysqli $conn, $stockGroupId){
        $sql = "
            SELECT stockGroupId, StockGroupName
            FROM stockgroups
        ";

        $query = $conn->prepare($sql);
        $query->bind_param('i', $stockGroupId);

        return $query->get_result()->fetch_all();
    }

    function selectProducts(mysqli $conn){
        $sql = "
            SELECT StockItemName
            FROM stockitems
            ";

        $query = $conn->prepare($sql);

        return $query->get_result()->fetch_all();
    }