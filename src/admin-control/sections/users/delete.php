<?php
include '../../includes.php';
$uID = $_GET['userID'] ?? null;
if ($_SESSION['user']['role'] === "admin") {
    if ($uID) {
        try {
            $stmt = $connection->prepare("DELETE FROM User WHERE userID = :userID");
            $stmt->bindParam(':userID', $uID, PDO::PARAM_INT);
            $stmt->execute();
            echo "<script>alert('Потребителят е изтрит успешно.'); window.location.href = './list.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Грешка при изтриване на потребителя: " . htmlspecialchars($e->getMessage()) . "');</script>";
        }
    } else {
        echo "<script>alert('Не е предоставен ID на потребителя.'); window.location.href = './list.php';</script>";
    }
} else {
    echo "<script>alert('Нямате права за изтриване на потребители.'); window.location.href = './list.php';</script>";
    exit;
}


?>