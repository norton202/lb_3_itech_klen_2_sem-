<?php 
require_once "connection.php";

$vendor=$_GET["vendor"];

try {
    $stmt = $dbh->prepare("SELECT Name FROM cars WHERE FID_Vendors = (SELECT ID_Vendors FROM vendors WHERE Name = :vendor)");
    $stmt->bindParam(':vendor', $vendor);
    $stmt->execute();
    $cursor = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: text/xml');
    echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
    echo "<cars>";
    foreach ($cursor as $car) {
        echo "<car>" . $car['Name'] . "</car>";
    }
    echo "</cars>";
} catch (PDOException $ex) {
    echo $ex->getMessage(); 
}

?>