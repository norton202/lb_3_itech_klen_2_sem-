<?php 
require_once "connection.php";

$date=$_GET["date"];

try {
    $stmt = $dbh->prepare("SELECT SUM(Cost) FROM rent WHERE Date_start <= :date AND Date_end >= :date");
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    $cursor = $stmt->fetch(PDO::FETCH_ASSOC);
    header('Content-Type: text/plain');
    if(isset($cursor["SUM(Cost)"])){
        echo "<p>Дохід з прокату на дату $date складає: " . $cursor["SUM(Cost)"] . "</p>";
    } else {
        echo "<p>Доходу з прокату на дату $date немає. </p>";
    }
} catch (PDOException $ex) {
    echo $ex->getMessage(); 
}

?>