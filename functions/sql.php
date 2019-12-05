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
            SELECT  DISTINCT si.StockItemId, si.StockItemName, si.RecommendedRetailPrice, sh.QuantityOnHand
            FROM    stockitems AS si 
            JOIN    stockitemholdings AS sh ON sh.StockItemId = si.StockItemId
            JOIN    stockitemstockgroups AS sisg ON sisg.StockItemID = si.StockItemID
            WHERE   Active = 1
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
            SELECT  si.StockItemId, si.StockItemName, si.SupplierID, si.ColorID, si.UnitPackageID, si.OuterPackageID, si.RecommendedRetailPrice, sh.QuantityOnHand, c.ColorName, si.Size, isChillerStock, Brand, LeadTimeDays
            FROM    stockitems AS si 
            JOIN    stockitemholdings AS sh ON sh.StockItemId = si.StockItemId
            JOIN    stockitemstockgroups AS sisg ON sisg.StockItemID = si.StockItemID
            LEFT JOIN    colors AS c on si.ColorId = c.ColorId
            WHERE   si.StockItemId = ? 
            AND     Active = 1
        ");

        $query->bind_param("i", $id);
        $query->execute();
        $products = $query->get_result();

        $conn->close();

        if($products->num_rows > 0){
            return $products->fetch_assoc();
        }else{
            return "Geen resultaten";
        }
    }

    function getPhotosProduct($stockItemId){
        $conn = createConn();

        $query = $conn->prepare("
            SELECT Photo
            FROM stockItemPhotos sp
            JOIN photos p ON sp.PhotoId = p.PhotoId
            WHERE sp.StockItemId = ?
        ");

        $query->bind_param("i", $stockItemId);
        $query->execute();
        $products = $query->get_result();

        $conn->close();

        if($products->num_rows > 0){
            return $products->fetch_all(MYSQLI_ASSOC);
        }else{
            return "Geen resultaten";
        }
    }

    function getProductBySearch($search){
        $conn = createConn();

        $search1 = $search;
        $search = "%".$search."%";

        $query = $conn->prepare( "
            SELECT  StockItemId, StockItemName
            FROM    stockitems
            WHERE   Active = 1
            AND (
                StockItemId = ?
                OR      StockItemName LIKE ?
                OR      SearchDetails LIKE ? 
            )
        ");

        $query->bind_param("iss", $search1, $search, $search);
        $query->execute();
        $products = $query->get_result();

        $conn->close();

        if($products->num_rows > 0){
            return $products->fetch_all(MYSQLI_ASSOC);
        }else{
            return "Geen resultaten";
        }
    }

    function getProductByFilter($stockGroupId, $price = null){
        $conn = createConn();
        $filters = [];
        $types = "";

        $categoriesFilter = "";
        if($stockGroupId !== null){
            $clause = implode(',', array_fill(0, count($stockGroupId), '?'));
            $types = str_repeat('i', count($stockGroupId));
            $filters = $stockGroupId;

            $categoriesFilter = "
                AND si.StockItemId IN (
                SELECT StockItemId
                FROM stockitemstockgroups
                WHERE StockGroupId IN ($clause) 
            )
            ";
        }

        $priceFilter = "";
        if($price !== null){
            array_push($filters, $price);
            $priceFilter = " 
                AND RecommendedRetailPrice <= ?
            ";
            $types = $types . "s";
        }

        $query = $conn->prepare("
            SELECT si.StockItemId, si.StockItemName
            FROM stockitems AS si
            WHERE Active = 1
            $categoriesFilter
            $priceFilter
        ");

        if(count($filters) !== 0){
            $query->bind_param($types, ...$filters);
        }

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

        $query = $conn->prepare("
            SELECT StockGroupId, StockGroupName
            FROM stockgroups
        ");
        $query->execute();
        $categories = $query->get_result();

        $conn->close();

        if($categories->num_rows > 0){
            return $categories->fetch_all(MYSQLI_ASSOC);
        }else{
            return "Geen resultaten";
        }
    }
    // CATEGORIES //

    // MOST POPULAR POPULAR PRODUCTS //
    function fetchMostPopulairItems(){
        $conn = createConn();

        //Met onderstaande query worden de VAAKST verkochte items gedisplayed
        $query = $conn->prepare("
                SELECT st.StockItemID, st.StockItemName, COUNT(*) AS meest_verkocht
                FROM stockitems AS st
                JOIN orderlines AS o ON st.StockItemID = o.StockItemID
                WHERE Active = 1
                GROUP BY o.StockItemID
                ORDER BY meest_verkocht DESC LIMIT 3
            ");

        //Met onderstaande query worden de MEEST verkochte items gedisplayed (LET OP: dit zijn dus de items waarvan de grootste hoeveelheid verkocht
        //is. Echter duurt deze query veelste lang om steeds aan te roepen bij het laden van de pagina.
//        $query = $conn->prepare("
//                SELECT st.StockItemID, st.StockItemName, SUM(quantity) AS totaal_verkocht
//                FROM stockitems AS st
//                JOIN orderlines AS o ON st.StockItemID = o.StockItemID
//                GROUP BY o.StockItemID
//                ORDER BY totaal_verkocht DESC LIMIT 3
//                ");

        $query->execute();
        $products = $query->get_result();

        $conn->close();

        if($products->num_rows > 0){
            return $products->fetch_all(MYSQLI_ASSOC);
        }else{
            return "Geen resultaten";
        }
    }
    // MOST POPULAR POPULAR PRODUCTS //

    // USERS //
    function checkUserExists($logonName){
        $conn = createConn();

        $query = $conn->prepare("
            SELECT  PersonId
            FROM    people
            WHERE   LogonName = ?
        ");

        $query->bind_param("s", $logonName);
        $query->execute();
        $result = $query->get_result();

        $conn->close();

        if($result->num_rows == 0){
            return false;
        }else{
            return true;
        }
    }

    function addUser($firstName, $lastName, $password, $email, $phoneNumber, $userId, $deliveryMethod, $deliveryLocation, $permissions = null){
        $conn = createConn();

        $fullName = $firstName . " " . $lastName;
        $searchName = $firstName . " " . $fullName;
        $logonName = $email;

        $deliveryCityId = $deliveryLocation[0];
        $deliveryAddressLine2 = $deliveryLocation[2];
        $deliveryPostalCode = $deliveryLocation[3];

        $postalCityId = $deliveryLocation[0];
        $postalAddressLine2 = $deliveryLocation[1];
        $postalPostalCode = $deliveryLocation[2];

        if($password !== false){
            $isSystemUser = 0;
            $isEmployee = 0;
            $isSalesperson = 0;

            if($permissions !== null){
                $isSystemUser = $permissions[0];
                $isEmployee = $permissions[1];
                $isSalesperson = $permissions[2];
            }

            $maxIdCustomer = "
                SELECT max(PersonId) maxId 
                FROM people p
                UNION ALL 
                SELECT max(PersonId) maxId 
                FROM people_archive pa
                ORDER BY maxId DESC
                LIMIT 1
            ";

            $maxIdPeople = "
                SELECT max(CustomerId) maxId 
                FROM customer c
                UNION ALL 
                SELECT max(CustomerId) maxId 
                FROM customers_archive ca
                ORDER BY maxId DESC
                LIMIT 1
            ";

            $query = $conn->prepare("
                INSERT INTO people(PersonId, FullName, PreferredName, SearchName, IsPermittedToLogon, LogonName, IsExternalLogonProvider, 
                HashedPassword, IsSystemUser, IsEmployee, IsSalesperson, PhoneNumber, EmailAddress, LastEditedBy, ValidFrom, ValidTo)
                VALUES(($maxIdPeople) + 1, ?, ?, ?, 1, ?, 0, ?, ?, ?, ?, ?, ?, ?, '".date('Y-m-d H:i:s')."' , '9999-12-31 23:59:59');
                
                INSERT INTO customers(CustomerId, CustomerName, BillToCustomerId, CustomerCategoryId, PrimaryContactPersonId, DeliveryMethodId, 
                DeliveryCityId, PostalCityId, AccountOpendDate, StandardDiscountPercentage, PhoneNumber, 
                DeliveryAddressLine2, DeliveryPostalCode, DeliveryLocation, PostalAddressLine2, PostalPostalCode, LastEditedBy)
                VALUES(($maxIdCustomer), ?, ($maxIdPeople + 1), 9, ($maxIdPeople + 1), ?, ?, ?, '".date('Y-m-d H:i:s') . "', 0.000, ?, ?, ?, ?, ?, ?, ?);
            ");

            $query->bind_param("sssssssiisi
                                      siiissssssi
           ",
                $fullName, $firstName, $searchName, $logonName, $password, $isSystemUser, $isEmployee, $isSalesperson, $phoneNumber, $email, $userId,
                $fullName, $deliveryMethod, $deliveryCityId, $postalCityId, $phoneNumber, $deliveryAddressLine2, $deliveryPostalCode, $postalAddressLine2, $postalPostalCode, $userId
            );

            $result = $query->execute();

            $conn->close();

            return $result;
        }else{
            return false;
        }
    }

    function checkValidLogin($logonName, $password){
        $conn = createConn();

        $query = $conn->prepare("
            SELECT  PersonId, HashedPassword, IsSystemUser, IsEmployee, IsSalesPerson
            FROM    people
            WHERE   LogonName = ?
        ");

        $query->bind_param("s", $logonName);
        $query->execute();
        $result = $query->get_result();

        $conn->close();

        if($result->num_rows !== 0 && password_verify($password, $result->fetch_all(MYSQLI_ASSOC)[0]["HashedPassword"])){
            return $result->fetch_all(MYSQLI_ASSOC)[0];
        }else{
            return false;
        }
    }
    // USERS //

    // LOCATION //

    function getCountries(){
        $conn = createConn();

        $query = $conn->prepare("
            SELECT  PersonId, HashedPassword, IsSystemUser, IsEmployee, IsSalesPerson
            FROM    people
            WHERE   LogonName = ?
        ");
    }

    // LOCATION //