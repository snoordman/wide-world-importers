<?php
    // Functie voor het maken van de database connectie
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
    // functie voor het ophalen van de producten per pagina
    function getProducts($amountResults = 10, $offset = 0){
        // open de connectie met de database
        $conn = createConn();

        // prepare de query die moet worden uitgevoerd
        // aan de vraagtekens worden de parameters gebind
        $query = $conn->prepare( "
            SELECT  si.StockItemId, si.StockItemName, si.UnitPrice, sh.QuantityOnHand
            FROM    stockitems AS si 
            LEFT JOIN    stockitemholdings AS sh ON sh.StockItemId = si.StockItemId
            WHERE   Active = 1
            ORDER BY si.StockItemId
            LIMIT   ?
            OFFSET  ?
        ");

        // bind de parameters voor de query
        $query->bind_param("ii", $amountResults, $offset);

        // voer de query uit, haal de resultaten op en sluit de connectie met de database
        $query->execute();
        $products = $query->get_result();
        $conn->close();

        // kijk of de opgehaalde resultaten meer dan 1 zijn.
        // zo ja stuur dan een assocative array terug met de resultaten
        // zo niet stuur geen resultaten terug
        if($products->num_rows > 0){
            return $products->fetch_all(MYSQLI_ASSOC);
        }else{
            return "Geen resultaten";
        }
    }

    function getMultipleProducts($filters){
        $conn = createConn();

        // maak een string met voor iedere key in de array $filters een vraagteken en seperate die met een ,
        $clause = implode(',', array_fill(0, count($filters), '?'));
        // maak een string die de letter i er inzet. De hoeveelhijd i is de lengte van de array filters
        $types = str_repeat('i', count($filters));

        $query = $conn->prepare( "
            SELECT  StockItemID, StockItemName, UnitPrice, UnitPackageID, TaxRate, MarketingComments  
            FROM    stockitems
            WHERE   Active = 1
            AND     StockItemID IN ($clause)
        ");

        // Bind de parameters
        // Door de ... voor de variable filters te gebruiken wordt de call_user_function_array toegepast voor de variable
        // Deze functie geeft de array door als apparte argumenten
        // Dit wordt gedaan omdat je niet een array mee kan sturen met de bind_param maar wel individuele argumenten
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

        // zet of er 1 of meer fotos opgehaald moeten worden
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

        // zet de search
        // voor de id hoeven er geen procent tekens voor maar voor de naam en
        // beschrijving wel omdat daar er karakters voor mogen komen
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

        // standaard is de categoriefilter leeg omdat deze niet geselecteerd hoeft te zijn
        $categoriesFilter = "";
        // maak de string die in de query komt om te kijken of de categorieid in de array stockGroupID zit
        if ($stockGroupId !== null) {
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

        // standaard is de priceFilter leeg omdat deze niet geselecteerd hoeft te zijn
        $priceFilter = "";
        // maak de string die in de query komt om te kijken of de prijs onder of gelijk is aan de megegeven prijs
        if ($price !== null) {
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

        // kijk of de filters niet leeg zijn en als dat niet zo is bind die dan
        if (count($filters) !== 0) {
            $query->bind_param($types, ...$filters);
        }

        $query->execute();
        $products = $query->get_result();

        $conn->close();

        if ($products->num_rows > 0) {
            return $products->fetch_all(MYSQLI_ASSOC);
        } else {
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

        if ($categories->num_rows > 0) {
            return $categories->fetch_all(MYSQLI_ASSOC);
        } else {
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

    function checkNameExists($fullName){
        $conn = createConn();

        $query = $conn->prepare("
            SELECT  CustomerId
            FROM    customers
            WHERE   CustomerName = ?
        ");

        $query->bind_param("s", $fullName);
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

        // zorg dat wanneer je een query uitvoert die niet automatisch gecommit wordt
        // zo kun je handmatig de weizigingen opslaan zodat je 2 querys uit kunt voeren
        // en pas kunt opslaan wanneer ze alle 2 goed gaan
        $conn->autocommit(FALSE);

        // maak de fullname, searchname van de firstname en lastname
        $fullName = $firstName . " " . $lastName;
        $searchName = $firstName . " " . $fullName;

        $logonName = $email;

        // zet de locatie array in variable
        $deliveryCityId = $deliveryLocation[0];
        $deliveryAddressLine2 = $deliveryLocation[1];
        $deliveryPostalCode = $deliveryLocation[2];

        $postalCityId = $deliveryLocation[0];
        $postalAddressLine2 = $deliveryLocation[1];
        $postalPostalCode = $deliveryLocation[2];

        // zet de standaard rechten en als die permissions variable niet null is zet dan de meegestuurde permission als rechten
        $isSystemUser = 0;
        $isEmployee = 0;
        $isSalesperson = 0;

        if($permissions !== null){
            $isSystemUser = $permissions[0];
            $isEmployee = $permissions[1];
            $isSalesperson = $permissions[2];
        }

        // maak een string met een query die de max person id selecteerd
        $maxIdPeople = "
            SELECT max(PersonId) maxId 
            FROM people p
            UNION ALL 
            SELECT max(PersonId) maxId 
            FROM people_archive pa
            ORDER BY maxId DESC
            LIMIT 1
        ";

        // maak een string met een query die de max customer id selecteerd
        $maxIdCustomer = "
            SELECT max(CustomerId) maxIdCustomer
            FROM customers c
            UNION ALL 
            SELECT max(CustomerId) maxIdCustomer
            FROM customers_archive ca
            ORDER BY maxIdCustomer DESC
            LIMIT 1
        ";

        // maak een query die de CustomerCategoryID ophaalt waar de naam customer is
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

        // maak een query voor het toevoegen van een people record
        $query = $conn->prepare("
            INSERT INTO people(PersonID, FullName, PreferredName, SearchName, IsPermittedToLogon, LogonName, IsExternalLogonProvider, 
            HashedPassword, IsSystemUser, IsEmployee, IsSalesperson, PhoneNumber, EmailAddress, LastEditedBy, ValidFrom, ValidTo)
            VALUES(($maxIdPeople) + 1, ?, ?, ?, 1, ?, 0, ?, ?, ?, ?, ?, ?, ?, '".date('Y-m-d H:i:s')."' , '9999-12-31 23:59:59');
        ");

        // maak een query voor het toevoegen van een customer record
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

        // als bijde querys goed zijn gegaan sla de weizigingen dan op
        if($result1 == true && $result2 == true){
            $conn->commit();
        }

        var_dump($conn->error);
        $conn->close();

        if($result1 == false){
            return $result1;
        }else{
            return $result2;
        }
    }

    // functie om te kijken voor een geldige login
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
        // kijk of de resultaten groter zijn dan 0 en met de
        // functie password_verify het verstuurde wachtwoord klopt met het opgehaalde wachtwoord
        if($result->num_rows !== 0 && password_verify($password, $account[0]["HashedPassword"])){
            return $account[0];
        }else{
            return false;
        }
    }

    function getUserInfo($userID){
        $conn = createConn();

        $query = $conn->prepare("
            SELECT p.PhoneNumber , c.DeliveryCity, c.PostalCity, c.DeliveryAddressLine2, c.DeliveryPostalCode
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

    // functie begin updaten user
    // werkt nog niet en wordt ook neit gebruikt
    function updateUser($peopleID, $phoneNumber, $deliveryCity, $postalCity, $address, $zip){
        $conn = createConn();
        $conn->autocommit(FALSE);

        $query1 = $conn->prepare("
           SELECT   CustomerID
           FROM     customers
           WHERE    PrimaryContactPersonID = ?
        ");

        $query1->execute();
        $customerID = $query1->get_result();
        if($customerID->num_rows !== 0){
            $customerID = $customerID->fetch_assoc()["CustomerID"];
        }else{
            $customerID = null;
        }
    }
    // USERS //

    // LOCATION //
    // functie voor het ophalen van de landen
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

    // functie voor het ophalen van de provincies
    function getProvincesByCountry($countryId, $returnJson = false)
    {
        $conn = createConn();

        $query = $conn->prepare("
            SELECT  StateProvinceID, StateProvinceName
            FROM    stateprovinces
            WHERE   countryID = ?
        ");

        $query->bind_param("i", $countryId);
        $query->execute();
        $result = $query->get_result();

        $conn->close();

        if($result->num_rows !== 0 ){
            if($returnJson == true){
                // stuur json terug als de variable returnJson true is
                echo json_encode($result->fetch_all(MYSQLI_ASSOC));
                return true;
            }else{
                return $result->fetch_all(MYSQLI_ASSOC);
            }
        }else{
            if($returnJson == true){
                // stuur json terug als de variable returnJson true is
                echo json_encode(array());
                return false;
            }else{
                return false;
            }
        }
    }

    // ajax call
    // deze wordt aangeroepen als de getProvinces gezet is in de GET
    // dit wordt gedaan in de javascript file bij de ajax call
    if(isset($_GET["getProvinces"])){
        getProvincesByCountry($_GET["CountryID"], true);
    }

    // functie voor het ophalen van de provincies
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
                return true;
            }else{
                return $result->fetch_all(MYSQLI_ASSOC);
            }
        }else{
            if($returnJson == true){
                echo json_encode(array());
                return false;
            }else{
                return false;
            }
        }
    }

    // ajax call
    // deze wordt aangeroepen als de getCities gezet is in de GET
    // dit wordt gedaan in de javascript file bij de ajax call
    if(isset($_GET["getCities"])){
        getCitiesByProvince($_GET["ProvinceID"], true);
    }
    // LOCATION //

    // DELIVERY METHODS //
    // functie om de delivery methodes op te halen
    // wordt niet gebruikt
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
    // functie op customerId op te halen op basis van een peopleId
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
            return null;
        }
    }
    // customers //


    // ORDERS //
    // functie om de maximale verwachte lervertijd op te halen op basis van meerdere meegestuurde StockItemID
    function getMaxExpectedDelivery($products){
        $conn = createConn();

        $clause = implode(',', array_fill(0, count($products), '?'));
        $types = str_repeat('i', count($products));
        $filters = $products;

        $query = $conn->prepare( "
            SELECT  max(LeadTimeDays) as MaxLeadTimeDays
            FROM    stockitems
            WHERE   Active = 1
            AND     StockItemID IN ($clause)
        ");

        $query->bind_param($types, ...$filters);
        $query->execute();
        $products = $query->get_result();

        $conn->close();

        if($products->num_rows > 0){
            return $products->fetch_assoc()["MaxLeadTimeDays"];
        }else{
            return null;
        }
    }

    // functie om producten toe te voegen
    function insertOrder($products){
        $conn = createConn();
        $conn->autocommit(FALSE);

        // haal het peopleID op van de ingelogde gebruiker
        $peopleId = $_SESSION["account"]["id"];
        // haal het customerID op voor de ingelogde gebruiker
        $customerId = getCustomerId($peopleId);

        $productIds = [];
        // voor ieder product stop het StockItemID in een array
        foreach ($products as $product){
            array_push($productIds, $product["StockItemID"]);
        }
        // haal de maximale levertijd op voor de meegestuurde producten
        $deliveryTime = getMaxExpectedDelivery($productIds);
        // maak van de maximale levertijd een leverdatum als de levertijd niet null is
        if($deliveryTime !== null){
            $deliveryTime = strtotime("+" . $deliveryTime . " days");
            $deliveryTime = "'" . date("Y-m-d", $deliveryTime) . "'";
        }

        // string met een query voor de maximale orderID
        $getMaxOrderId = "
            SELECT  MAX(OrderID) 
            FROM    orders o
        ";

        // string met een query voor de maximale orderLineID
        $getMaxOrderLineId = "
            SELECT MAX(OrderLineID)
            FROM orderlines ol
        ";

        // query voor het toevoegen van orders
        $query1 = $conn->prepare("
            INSERT INTO orders(OrderID, CustomerID, SalespersonPersonID, PickedByPersonID, ContactPersonID, OrderDate, 
            ExpectedDeliveryDate, PickingCompletedWhen, LastEditedWhen, LastEditedBy)
            VALUES(($getMaxOrderId) + 1, $customerId , 1, 1, $peopleId , '" . date('Y-m-d') . "' , " . $deliveryTime . " , '" . date('Y-m-d H:i:s') . "' , '" . date('Y-m-d H:i:s') . "' , 1 )
        ");

        $success = $query1->execute();

        // voor ieder product insert een record in orderlines als de eerste query goed is gegaan
        // zo niet jump dan uit de foreach
        foreach ($products as $product){
            if($success == true){
                $queryProduct = $conn->prepare("
                    INSERT INTO orderlines
                    VALUES(($getMaxOrderLineId) + 1, ($getMaxOrderId) , " . $product['StockItemID'] . " , '" . $product['MarketingComments'] . "' , " . $product["UnitPackageID"] . " , " . $product["quantity"] .
                    " , " . $product["UnitPrice"] . " , " . $product["TaxRate"] . " , " . $product["quantity"] . " , '" . $product["pickCompletedWhen"] .
                    "' , 1 , '" . date('Y-m-d H:i:s')."')"
                );
                $success = $queryProduct->execute();
            }else{
                break;
            }
        }

        // als alle querys goed zijn gegaan sla de weizigingen dan op
        if($success == true){
            $conn->commit();
        }
        $conn->close();

        return $success;
    }
    // ORDERS //


    // functie voor het ophalen van de prijzen voor producten
    // wordt niet gebruikt
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

    // Pagination //
    // query voor het ophalen van de hoeveelheid records
    function getAmountProducts(){
        $conn = createConn();

        $query = $conn->prepare("
            SELECT Count(StockItemID) as StockItemID
            FROM stockitems
        ");
        $query->execute();
        $result = $query->get_result();

        $conn->close();

        if($result->num_rows > 0){
            // stuur de hoeveelheid stockItemIDs terug
            return $result->fetch_assoc()["StockItemID"];
        }else{
            return false;
        }
    }

    // functie voor het ophalen van alle orders
    function getOrders(){
        $conn = createConn();

        $query = $conn->prepare("
            SELECT o.OrderID, OrderDate, ExpectedDeliveryDate, Description, StockItemName, PickedQuantity, ol.UnitPrice 
            FROM orders o
            JOIN orderlines ol ON o.OrderID = ol.OrderID 
            JOIN stockitems si ON ol.StockItemID = si.StockItemID 
            WHERE ContactPersonID = " . $_SESSION["account"]["id"]
        );

        $query->execute();
        $result = $query->get_result();

        $conn->close();

        if($result->num_rows > 0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }else{
            return false;
        }
    }

