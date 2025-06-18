<?php
include '../../includes.php';
$bID = $_GET['bookID'] ?? null;
if ($_SESSION['user']['role'] === "admin") {
    if ($bID) {
        try {
            $stmt = $connection->prepare("DELETE FROM Books WHERE bookID = :bookID");
            $stmt->bindParam(':bookID', $bID, PDO::PARAM_INT);
            $stmt->execute();
            echo "<script>alert('Книгата беше изтрита успешно.'); window.location.href = './list.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Грешка при изтриване на книгата: " . htmlspecialchars($e->getMessage()) . "');</script>";
        }
    } else {
        echo "<script>alert('Не е предоставен ID на книга.'); window.location.href = './list.php';</script>";
    }
} else {
    echo "<script>alert('Нямате права да изтривате книги.'); window.location.href = './list.php';</script>";
    exit;
}
?>