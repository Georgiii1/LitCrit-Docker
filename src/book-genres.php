<?php include("./database/connection.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛитКрит - GENRE </title> <!-- !!! -->
    <link rel="icon" href="pictures/logo-ico.ico" type="image/x-icon">

</head>



<body>

    <div class="container-fluid">

        <?php include("./elements/header.php");
        $genreID = $_GET['genreID'];
        $stmt = $connection->prepare(" SELECT bookGenre from genre g WHERE g.genreID = ?");
        $stmt->execute([$genreID]);
        $genre = $stmt->fetch();
        ?>

    

        <h2 class="page-category-title"><?= $genre["bookGenre"]; ?></h2>

        <div class="row book-row">
            <?php
            $stmt = $connection->prepare("SELECT b.*, g.bookGenre FROM Books b JOIN genre g ON b.bookGenre = g.genreID WHERE g.genreID = ?");
            $stmt->execute([$genreID]);
            $books = $stmt->fetchAll();

            if ($books) {
            foreach ($books as $el) {
                ?>
                <div class="col-xl-4 col-sm-6 col-12">
                <?php include("./elements/book-card.php") ?>
                </div>
                <?php
            }
            } else {
            echo "<h3 style='text-align: center;'>Все още няма публикувани книги.</h3>";
            }
            ?>
        </div>



        <?php include("./elements/footer.php") ?>
    </div>

</body>

</html>