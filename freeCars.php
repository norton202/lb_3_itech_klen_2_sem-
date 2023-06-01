<?php 
require_once "connection.php";

$date=$_GET["freeDate"];

try {
    $stmt = $dbh->prepare("SELECT Name FROM cars WHERE ID_Cars NOT IN (SELECT FID_Car FROM rent WHERE Date_start <= :date AND Date_end >= :date)");
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    $cursor = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($cursor);
} catch (PDOException $ex) {
    echo $ex->getMessage(); 
}

?>