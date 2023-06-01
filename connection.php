<?php 

$host = 'localhost';
$dbname = 'lb_pdo_rent';
$username = 'root';
$password = '';

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname;", $username, $password);
} catch (PDOException $ex) {
    echo $ex->getMessage(); 
}

?>