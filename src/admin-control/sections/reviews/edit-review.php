<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - Edit</title>
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #444;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1em;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            font-size: 1em;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            display: inline-block;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .success-message {
            text-align: center;
            color: green;
            font-weight: bold;
            margin-bottom: 1em;
        }
    </style>
</head>
<body>
    <?php
    include '../../includes.php';
    $rID = $_GET['reviewID'] ?? null;
    $stmt = $connection->prepare(
        "SELECT Reviews.*, Books.bookTitle AS bookTitle 
         FROM Reviews 
         LEFT JOIN Books ON Reviews.bookReviewID = Books.bookID
         WHERE Reviews.reviewID = ?"
    );
    $stmt->execute([$rID]);
    $review = $stmt->fetch(PDO::FETCH_ASSOC);

    // Handle form submission and update review
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $reviewID = $_POST['review_id'];
        $reviewText = $_POST['review_text'];
        $reviewStatus = $_POST['review_status'];

        $updateStmt = $connection->prepare(
            "UPDATE Reviews SET review = ?, status = ? WHERE reviewID = ?"
        );
        $updateStmt->execute([$reviewText, $reviewStatus, $reviewID]);

        // Optionally, reload the updated review
        $stmt->execute([$reviewID]);
        $review = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<div style='color: green; margin-bottom: 1em;'>Review updated successfully.</div>";
    }
    ?>
    <h1>Редактиране съдържание на отзив</h1>
    <form action="" method="POST">
        <div class="form-group">
            <label for="review_id">Review ID</label>
            <input type="text" id="review_id" name="review_id" value="<?php echo htmlspecialchars($review['reviewID']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="book_review_id">Заглавие на книга</label>
            <input type="text" id="book_review_id" name="book_review_id" value="<?php echo htmlspecialchars($review['bookTitle']); ?>" readonly>
        <div class="form-group">
            <label for="review_text">Отзив</label>
            <textarea id="review_text" name="review_text" rows="4"><?php echo htmlspecialchars($review['review']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="review_status">Статус</label>
            <select id="review_status" name="review_status">
                <option value="approved" <?php echo $review['status'] == 'approved' ? 'selected' : ''; ?>>Approved</option>
                <option value="declined" <?php echo $review['status'] == 'declined' ? 'selected' : ''; ?>>Declined</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit">Актуализирайте отзив</button>
        </div>
    </form>
    <div class="form-group">
        <a href="list.php">Обратно към всички отзиви</a>
    </div>
    
</body>
</html>