<?php
include '../../includes.php';
$rID = $_GET['reviewID'] ?? null;
if ($_SESSION['user']['role'] === "admin") {
    if ($rID) {
            try {
                $stmt = $connection->prepare("DELETE from Reviews where reviewID = :reviewID");
                $stmt->bindParam(':reviewID', $rID, PDO::PARAM_INT);
                $stmt->execute();
                echo "<script>alert('Отзивът беше изтрит успешно.'); window.location.href = './list.php';</script>";
            } catch (Exception $e) {
                echo "<script>alert('Грешка при изтриване на книгата: " . htmlspecialchars($e->getMessage()) . "');</script>";
            }
        } else {
            echo "<script>alert('Не е предоставен ID на отзив.'); window.location.href = './list.php';</script>";
        }
    } else {
    echo "<script>alert('Нямате права да изтривате отзиви.'); window.location.href = './list.php';</script>";
    exit;
    }

?>