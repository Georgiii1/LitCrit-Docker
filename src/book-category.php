<?php
include("./admin-control/includes.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛитКрит - Най-популярни</title>
    <link rel="icon" href="pictures/logo-ico.ico" type="image/x-icon">

</head>


<body>
    <div class="container-fluid">

        <?php include("./elements/header.php") ?>

        <?php
        $data = $connection->query("
        SELECT b.*, g.bookGenre 
        FROM Books b 
        JOIN genre g ON b.bookGenre = g.genreID")->fetchAll();

        $category = $_GET['category'];

        function defineCategory($categoryToDefine)
        {
            switch ($categoryToDefine) {
                case 'popular':
                    return "Най-популярни";
                case 'suggested':
                    return "Препоръчани за Вас";
                case 'new':
                    return "Нови заглавия";
            }
        }
        ?>

        <h2 class="page-category-title"><?php echo defineCategory($category); ?></h2>
        <?php
        defineCategory($category);

        ?>


        <?php
        if (isset($category) && $category == 'new') {
            $data = $connection->query("SELECT b.*, g.bookGenre 
            FROM Books b 
            JOIN genre g ON b.bookGenre = g.genreID
            ORDER BY b.dateAdded DESC")->fetchAll();
        } elseif (isset($category) && $category == 'suggested') {

            
            
            $favGenres = array_map('trim', explode(',', $_SESSION['user']['favouriteGenre']));
            
            if ( isset( $_SESSION['user']['favouriteGenre'] ) && strlen( $_SESSION['user']['favouriteGenre'] ) >0 &&   count($favGenres) > 0) { //if > 0

                $placeholders = implode(',', array_fill(0, count($favGenres), '?'));
                $stmt = $connection->prepare("SELECT b.*, g.bookGenre 
                    FROM Books b 
                    JOIN genre g ON b.bookGenre = g.genreID
                    WHERE g.bookGenre IN ($placeholders)");
                $stmt->execute($favGenres);
                $data = $stmt->fetchAll();
                shuffle($data);
            } else {

                echo "<h3 class='no-suggestions'>Няма книги съвпадащи с вашите интереси, или все още не сте избрали предпочитани жанрове в профила си!</h3>";
                $data = $connection->query("SELECT b.*, g.bookGenre 
            FROM Books b 
            JOIN genre g ON b.bookGenre = g.genreID ")->fetchAll();
            }
        } elseif (isset($category) && $category == 'popular') {
            $data = $connection->query("
            SELECT b.*, g.bookGenre 
            FROM Books b 
            JOIN genre g ON b.bookGenre = g.genreID 
            ORDER BY b.rating_sum / NULLIF(b.rating_count, 0) DESC")->fetchAll();
        } else {
            // Default case if no category is set
            $data = [];
            echo "<h3 class='no-suggestions'>Няма книги съвпадащи с вашите интереси, или все още не сте избрали предпочитани жанрове в профила си!</h3>";
        }

        ?>

        <div class="row book-row">
            <?php foreach ($data as $el) { ?>
                <div class="col-xl-4 col-sm-6 col-12">
                    <?php include("./elements/book-card.php") ?>
                </div>
            <?php } ?>

            <div class="col-xl-4 col-sm-6 col-12">
                <?php include("./elements/book-card.php") ?>
            </div>

            <div class="col-xl-4 col-sm-6 col-12">
                <?php include("./elements/book-card.php") ?>
            </div>
        </div>


        <?php include("./elements/footer.php") ?>

    </div>

</body>

</html>