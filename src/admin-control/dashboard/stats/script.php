<?php 
include("../../includes.php");

$sql = $connection->prepare("SELECT * from Reviews");
$sql->execute();


$data = [];

while($row = $rev->fetch(PDO::FETCH_ASSOC)) {
    array_push($data, $rev);
}

echo json_encode($data);