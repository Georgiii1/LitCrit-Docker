<?php include("./database/connection.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛитКрит - Моите отзиви</title>
    <link rel="icon" href="pictures/logo-ico.ico" type="image/x-icon">
</head>

<body>
    <div class="container-fluid">

        <?php include("./elements/header.php"); ?>

        <!-- Accepted Reviews Section -->
        <div class="accepted-reviews">
            <h2 class="page-category-title">Моите отзиви</h2>
            <div class="container reviews-container">
                <?php
                $stmt = $connection->prepare("SELECT r.*, u.* FROM Reviews r JOIN User u ON r.userID = u.userID WHERE r.status = 'approved' and r.userID = ?");
                $stmt->execute([$_SESSION['user']['userID']]);
                $reviews = $stmt->fetchAll();

                foreach ($reviews as $rev) {
                    include("./elements/review-card.php");
                }
                if (empty($reviews)) {
                    echo "<h3 class='no-reviews'>Нямате одобрени отзиви.</h3>";
                }
                ?>
            </div>
        </div>

        <br><br><br>

        <!-- Waiting for Approval Section -->
        <div class="waiting-reviews">
            <h2 class="page-category-title">Изчакващи одобрение</h2>
            <div class="container reviews-container">
                <?php
                $stmt = $connection->prepare("SELECT r.*, u.* FROM Reviews r JOIN User u ON r.userID = u.userID WHERE r.status = 'pending' and r.userID = ?");
                $stmt->execute([$_SESSION['user']['userID']]);
                $reviews = $stmt->fetchAll();

                foreach ($reviews as $rev) {
                    include("./elements/review-card-waiting.php");
                }
                if (empty($reviews)) {
                    echo "<h3 class='no-reviews'>Нямате отзиви, изчакващи одобрение.</h3>";
                }
                ?>
                
            </div>
        </div>

        <?php include("./elements/footer.php"); ?>

    </div>
</body>

</html>