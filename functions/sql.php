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
    function getProducts($amountResults = 10, $offset = 0){
        $conn = createConn();

        $query = $conn->prepare( "
            SELECT  si.StockItemId, si.StockItemName, si.UnitPrice, sh.QuantityOnHand
            FROM    stockitems AS si 
            LEFT JOIN    stockitemholdings AS sh ON sh.StockItemId = si.StockItemId
            WHERE   Active = 1
            LIMIT   ?
            OFFSET  ?
        ");

        $query->bind_param("ii", $amountResults, $offset);

        $query->execute();
        $products = $query->get_result();

        $conn->close();

        if($products->num_rows > 0){
            return $products->fetch_all(MYSQLI_ASSOC);
        }else{
            return "Geen resultaten";
        }
    }

    function getMultipleProducts($ids){
        $conn = createConn();

        $clause = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));
        $filters = $ids;

        $query = $conn->prepare( "
            SELECT  StockItemId, StockItemName, UnitPrice, UnitPackageID, TaxRate
            FROM    stockitems
            WHERE   Active = 1
            AND     StockItemId IN ($clause)
        ");

        $query->bind_param($types, ...$filters);
        $query->execute();
        $products = $query->get_result();

        $conn->close();

        if($products->num_rows > 0){
            return $products->fetch_all(MYSQLI_ASSOC);
        }else{
            return "Geen resultaten";
        }
    }

    function getMinMaxPrice(){
        $conn = createConn();

        $query = $conn->prepare( "
                SELECT  min(unitPrice) minPrice, max(unitPrice) maxPrice
                FROM    stockitems
                WHERE   Active = 1
            ");

        $query->execute();
        $products = $query->get_result();

        $conn->close();

        if($products->num_rows > 0){
            return $products->fetch_assoc();
        }else{
            return "Geen resultaten";
        }
    }

    function getProductById($id){
        $conn = createConn();

        $query = $conn->prepare("
            SELECT  si.StockItemId, si.StockItemName, si.SupplierID, si.ColorID, si.UnitPackageID, si.OuterPackageID, si.UnitPrice, si.RecommendedRetailPrice, si.TypicalWeightPerUnit, si.MarketingComments, sh.QuantityOnHand, c.ColorName, si.Size, isChillerStock, Brand, LeadTimeDays
            FROM    stockitems AS si 
            LEFT JOIN    stockitemholdings AS sh ON sh.StockItemId = si.StockItemId
            LEFT JOIN    stockitemstockgroups AS sisg ON sisg.StockItemID = si.StockItemID
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

    function getPhotosProduct($stockItemId, $onlyOne = false){
        $conn = createConn();

        if($onlyOne == true){
            $limit = " LIMIT 1";
        }else{
            $limit = "";
        }

        $query = $conn->prepare("
            SELECT Photo
            FROM stockitemphotos sp
            JOIN photos p ON sp.PhotoId = p.PhotoId
            WHERE sp.StockItemId = ?
            $limit
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

        $query = $conn->prepare(
            "
            SELECT  si.StockItemId, si.StockItemName, si.UnitPrice, sh.QuantityOnHand
            FROM    stockitems AS si 
            LEFT JOIN    stockitemholdings AS sh ON sh.StockItemId = si.StockItemId
            WHERE   Active = 1
            AND (
                si.StockItemId = ?
                OR      si.StockItemName LIKE ?
                OR      si.SearchDetails LIKE ? 
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
                AND UnitPrice <= ?
            ";
            $types = $types . "s";
        }

        $query = $conn->prepare("
            SELECT si.StockItemId, si.StockItemName, si.UnitPrice
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

        $conn->autocommit(FALSE);

        $fullName = $firstName . " " . $lastName;
        $searchName = $firstName . " " . $fullName;
        $logonName = $email;

        $deliveryCityId = $deliveryLocation[0];
        $deliveryAddressLine2 = $deliveryLocation[1];
        $deliveryPostalCode = $deliveryLocation[2];

        $postalCityId = $deliveryLocation[0];
        $postalAddressLine2 = $deliveryLocation[1];
        $postalPostalCode = $deliveryLocation[2];

        $isSystemUser = 0;
        $isEmployee = 0;
        $isSalesperson = 0;

        if($permissions !== null){
            $isSystemUser = $permissions[0];
            $isEmployee = $permissions[1];
            $isSalesperson = $permissions[2];
        }

        $maxIdPeople = "
            SELECT max(PersonId) maxId 
            FROM people p
            UNION ALL 
            SELECT max(PersonId) maxId 
            FROM people_archive pa
            ORDER BY maxId DESC
            LIMIT 1
        ";

        $maxIdCustomer = "
            SELECT max(CustomerId) maxIdCustomer
            FROM customers c
            UNION ALL 
            SELECT max(CustomerId) maxIdCustomer
            FROM customers_archive ca
            ORDER BY maxIdCustomer DESC
            LIMIT 1
        ";

        $customerCategory = $conn->prepare("
            SELECT  CustomerCategoryID
            FROM    customercategories
            WHERE   CustomerCategoryName = 'customer'
        ");

        $customerCategory->execute();
        $customerCategory = $customerCategory->get_result();
        if($customerCategory->num_rows > 0){
            $customerCategory = $customerCategory->fetch_assoc()["CustomerCategoryID"];
        }else{
            $customerCategory = null;
        }

        $query = $conn->prepare("
            INSERT INTO people(PersonID, FullName, PreferredName, SearchName, IsPermittedToLogon, LogonName, IsExternalLogonProvider, 
            HashedPassword, IsSystemUser, IsEmployee, IsSalesperson, PhoneNumber, EmailAddress, LastEditedBy, ValidFrom, ValidTo)
            VALUES(($maxIdPeople) + 1, ?, ?, ?, 1, ?, 0, ?, ?, ?, ?, ?, ?, ?, '".date('Y-m-d H:i:s')."' , '9999-12-31 23:59:59');
        ");

        $query2 = $conn->prepare("
            INSERT INTO customers(CustomerID, CustomerName, BillToCustomerID, CustomerCategoryID, PrimaryContactPersonID, DeliveryMethodID, 
            DeliveryCityID, PostalCityID, AccountOpenedDate, StandardDiscountPercentage, PhoneNumber, 
            DeliveryAddressLine2, DeliveryPostalCode, PostalAddressLine2, PostalPostalCode, LastEditedBy, ValidFrom, ValidTo)
            VALUES(($maxIdCustomer) + 1, ?, ($maxIdCustomer) + 1, $customerCategory , ($maxIdPeople), ?, ?, ?, '".date('Y-m-d H:i:s') . "', 0.000, ?, ?, ?, ?, ?, ?, '".date('Y-m-d H:i:s')."' , '9999-12-31 23:59:59');
        ");


        $query->bind_param("sssssssiisi",
            $fullName, $firstName, $searchName, $logonName, $password, $isSystemUser, $isEmployee, $isSalesperson, $phoneNumber, $email, $userId
        );
        $query2->bind_param("siiisssssi",
            $fullName, $deliveryMethod, $deliveryCityId, $postalCityId, $phoneNumber, $deliveryAddressLine2, $deliveryPostalCode, $postalAddressLine2, $postalPostalCode, $userId
        );

        $result1 = $query->execute();
        $result2 = $query2->execute();

        if($result2 == true && $result2 == true){
            $conn->commit();
        }

        $conn->close();

        if($result1 == false){
            return $result1;
        }else{
            return $result2;
        }
    }

    function checkValidLogin($logonName, $password){
        $conn = createConn();

        $query = $conn->prepare("
            SELECT  PersonID, HashedPassword, IsSystemUser, IsEmployee, IsSalesPerson
            FROM    people
            WHERE   LogonName = ?
        ");

        $query->bind_param("s", $logonName);
        $query->execute();
        $result = $query->get_result();

        $conn->close();

        $account = $result->fetch_all(MYSQLI_ASSOC);
        if($result->num_rows !== 0 && password_verify($password, $account[0]["HashedPassword"])){
            return $account[0];
        }else{
            return false;
        }
    }
    // USERS //

    // LOCATION //
    function getCountries(){
        $conn = createConn();

        $query = $conn->prepare("
            SELECT  CountryID, CountryName
            FROM    Countries
        ");

        $query->execute();
        $result = $query->get_result();

        $conn->close();

        if($result->num_rows !== 0 ){
            return $result->fetch_all(MYSQLI_ASSOC);
        }else{
            return false;
        }
    }

    function getProvincesByCountry($countryId, $returnJson = false)
    {
        $conn = createConn();

        $query = $conn->prepare("
            SELECT  StateProvinceId, StateProvinceName
            FROM    stateprovinces
            WHERE   countryID = ?
        ");

        $query->bind_param("i", $countryId);
        $query->execute();
        $result = $query->get_result();

        $conn->close();

        if($result->num_rows !== 0 ){
            if($returnJson == true){
                echo json_encode($result->fetch_all(MYSQLI_ASSOC));
            }else{
                return $result->fetch_all(MYSQLI_ASSOC);
            }
        }else{
            if($returnJson == true){
                echo json_encode(array());
            }else{
                return false;
            }
        }
    }
    // ajax call
    if(isset($_GET["getProvinces"])){
        getProvincesByCountry($_GET["CountryID"], true);
    }

    function getCitiesByProvince($provinceId, $returnJson = false){
        $conn = createConn();

        $query = $conn->prepare("
            SELECT  CityID, CityName
            FROM    cities
            WHERE   StateProvinceID = ?
        ");

        $query->bind_param("i", $provinceId);
        $query->execute();
        $result = $query->get_result();

        $conn->close();

        if($result->num_rows !== 0 ){
            if($returnJson == true){
                echo json_encode($result->fetch_all(MYSQLI_ASSOC));
            }else{
                return $result->fetch_all(MYSQLI_ASSOC);
            }
        }else{
            if($returnJson == true){
                echo json_encode(array());
            }else{
                return false;
            }
        }
    }
    // ajax call
    if(isset($_GET["getCities"])){
        getCitiesByProvince($_GET["ProvinceID"], true);
    }
    // LOCATION //

    // DELIVERY METHODS //
    function getDeliveryMethods(){
        $conn = createConn();

        $query = $conn->prepare("
                    SELECT  DeliveryMethodID, DeliveryMethodName
                    FROM    deliverymethods
    
                ");

        $query->execute();
        $products = $query->get_result();

        $conn->close();

        if($products->num_rows > 0){
            return $products->fetch_all(MYSQLI_ASSOC);
        }else{
            return false;
        }
    }
    // DELIVERY METHODS //

    // customers //
    function getCustomerId($peopleId){
        $conn = createConn();

        $query = $conn->prepare("
                SELECT  CustomerID
                FROM    customers
                WHERE   PrimaryContactPersonID = ?
            ");

        $query->bind_param("i", $peopleId);

        $query->execute();
        $products = $query->get_result();

        $conn->close();

        if($products->num_rows > 0){
            return $products->fetch_assoc()["CustomerID"];
        }else{
            return false;
        }
    }
    // customers //


    // ORDERS //
    function getMaxExpectedDelivery($products){
        $conn = createConn();

        $clause = implode(',', array_fill(0, count($products), '?'));
        $types = str_repeat('i', count($products));
        $filters = $products;

        $query = $conn->prepare( "
            SELECT  max(lea)
            FROM    stockitems
            WHERE   Active = 1
            AND     StockItemId IN ($clause)
        ");

        $query->bind_param($types, ...$filters);
        $query->execute();
        $products = $query->get_result();

        $conn->close();

        if($products->num_rows > 0){
            return $products->fetch_all(MYSQLI_ASSOC);
        }else{
            return "Geen resultaten";
        }
    }
    function insertOrder($productId){
        $conn = createConn();
        $peopleId = $_SESSION["account"]["id"];
        $customerId = getCustomerId($peopleId);

        $getMaxOrderId = "
                SELECT  MAX(OrderID) 
                FROM    orders
            ";

        $query1 = $conn->prepare("
                INSERT INTO orders(OrderID, CustomerID, SalesPersonID, PickedByPersonID, ContactPersonID, BackOrderID, OrderDate, 
                ExpectedDeliverDate, CustomerPurchaseOrderNumber, IsUnderSupplyBackordered, PickingCompletedWhen)
                VALUES(($getMaxOrderId) + 1, $customerId , 0, 0, $peopleId , 0, " . date('Y-m-d') . " , " . $product['LeadTimeDays'] . " , 0, 1, ?, " . date('Y-m-d H:i:s') . " )
            ");

        //$query->bind_param("i", );
    }
    // ORDERS //


    //Fetch the stockitem prices from the database
    function getPriceForDiscount(){
        $conn = createConn();

        $query = $conn->prepare( "
                SELECT  StockItemId, UnitPrice, RecommendedRetailPrice
                FROM    stockitems
        ");

        $query->execute();
        $products = $query->get_result();

        $conn->close();

        if($products->num_rows > 0){
            return $products->fetch_assoc();
        }else{
            return "Geen resultaten";
        }
    }



