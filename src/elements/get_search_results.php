<?php
header('Content-Type: application/json');
include("../database/connection.php");

$search = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($search !== '') {
    $stmt = $connection->prepare("SELECT * FROM Books WHERE bookTitle LIKE ? OR bookAuthor LIKE ? LIMIT 10");
    $stmt->execute(['%' . $search . '%', '%' . $search . '%']);
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'books' => $books]);
} else {
    echo json_encode(['success' => true, 'books' => []]);
}

?>