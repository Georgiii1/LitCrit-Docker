<?php include("./database/connection.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛитКрит - Моите Книги</title>
    <link rel="icon" href="pictures/logo-ico.ico" type="image/x-icon">

</head>


<body>

    <div class="container-fluid">

        <?php include("./elements/header.php") ?>


        <div class="accepted-books">
            <h2 class="page-category-title">Моите книги</h2>

            <div class="row book-row">

                <?php
                $userId = $_SESSION['user']['userID'];
                $data = $connection->prepare("SELECT b.*, g.bookGenre FROM Books b JOIN genre g ON b.bookGenre = g.genreID WHERE b.userID = ? and status = 'approved' and b.userID = ?");
                $data->execute([$userId, $userId]);
                $data = $data->fetchAll();
                foreach ($data as $el) {
                    ?>
                    <div class="col-xl-4 col-sm-6 col-12">
                        <?php include("./elements/book-card.php") ?>
                    </div>
                    <?php
                }
                if (empty($data)) {
                    echo "<h3 style='text-align: center;'>Нямате одобрени книги.</h3>";
                }
                ?>



            </div>
        </div>

        <br><br><br>

        <div class="waiting-books">
            <h2 class="page-category-title">Изчакващи одобрение</h2>

            <div class="row book-row">
                <?php
                $data = $connection->prepare("SELECT b.*, g.bookGenre FROM Books b JOIN genre g ON b.bookGenre = g.genreID WHERE b.userID = ? and status = 'pending' and b.userID = ?");
                $data->execute([$userId, $userId]);
                $data = $data->fetchAll();
                foreach ($data as $el) {
                    ?>
                    <div class="col-xl-4 col-sm-6 col-12">
                        <?php include("./elements/book-card-waiting.php") ?>
                    </div>
                    <?php
                }
                if (empty($data)) {
                    echo "<h3 style='text-align: center;'>Нямате книги, изчакващи одобрение.</h3>";
                }
                ?>
            </div>
        </div>


        <?php include("./elements/footer.php") ?>

    </div>


</body>

</html>