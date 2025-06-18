<?php include("./database/connection.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛитКрит - Моят Профил</title>
    <link rel="icon" href="pictures/logo-ico.ico" type="image/x-icon">

</head>


<body>

    <div class="container-fluid">
        <?php include("./elements/header.php");
        if (!$user) {
            echo "<script>alert('User not found'); window.location.href='./index.php' </script>";
            exit();
        }


        ?>


        <!-- Section : Profile -->
        <div class="row my-profile" id="section-profile">

            <div class="col-xl-10 col-sm-12 user-info-col">
                <div class="container container-info">
                    <div class="user-info">
                        <h3 class="user-info-title">Потребителско име: </h3>
                        <h3 class="user-data"><?= $user['username'] ?></h3>
                        <br>
                        <h3 class="user-info-title">Имейл: </h3>
                        <h3 class="user-data"><?= $user['email'] ?></h3>
                        <br>
                    </div>


                    <div class="container">
                        <div class="button-group button-group2">
                            <?php
                            
                                $favouriteGenres = ( $user['favouriteGenre'] ? explode(',', $user['favouriteGenre'] ) : array() );
                            if ( count( $favouriteGenres ) == 0 ) {
                                
                                echo "<h3 class='no-reviews'>Нямате любими жанрове.</h3>";
                            } else {
                                foreach ($favouriteGenres as $favGenre) {
                                    echo "<div class='genre-button'>$favGenre</div>";
                                }
                            }
                            ?>
                        </div>
                        <input type="hidden" name="selectedGenres" id="selectedGenres" />
                    </div>

                </div>


                <div class="col-xl-2 col-sm-12 profile-picture">
                    <?php
                    $profilePicture = isset($user['profilePicture']) && !empty($user['profilePicture']) 
                        ? "images/usersPfp/" . $user['profilePicture'] 
                        : "images/usersPfp/default.jpg";
                    ?>
                    <img src="<?= $profilePicture ?>" alt="Профилна снимка">

                    <div class="edit-btn-container">
                        <a class="edit-profile-btn" href="account-edit-profile.php">Редактирай</a>
                        <a class="edit-profile-btn" href="logout.php">Изход</a>
                    </div>


                </div>
            </div>

        </div>


        <!-- Section : My Reviews -->
        <div class="row my-reviews" id="section-my-reviews">
            <div class="col-xl-12">

                <h2 class="categories-h">Моите отзиви</h2>


                <?php

                $stmt = $connection->prepare("SELECT r.*, u.* FROM Reviews r JOIN User u ON r.userID = u.userID WHERE r.userID = ? and status ='approved' LIMIT 4");
                $stmt->execute([$userId]);
                $reviews = $stmt->fetchAll();
                ?>

                <div class="container reviews-container">
                    <?php foreach ($reviews as $rev) { ?>
                        <div class="row book-row">
                            <div class="col-12">
                                <?php include "./elements/review-card.php"; ?>
                            </div>
                        </div>
                    <?php }
                    if (empty($reviews)) {
                        echo "<h3 class='no-reviews'>Нямате одобрени отзиви.</h3>";
                    } else {
                        ?>
                        <div class="row view-more-row">
                            <div class="col-xl-12">
                                <a href="my-reviews.php">
                                    <button class="view-all-btn">ВИЖ ВСИЧКИ</button>
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                    ?>




                </div>
            </div>
        </div>

        <br>
        <br>
        <br>

        <!-- Section : My Boooks -->
        <div class="row my-books" id="section-my-books">
            <div class="col-xl-12">

                <h2 class="categories-h">Моите книги</h2>

                <?php
                $stmt = $connection->prepare("SELECT b.*, g.bookGenre FROM Books b JOIN genre g ON b.bookGenre = g.genreID WHERE b.userID = ? AND status = 'approved' LIMIT 3");
                $stmt->execute([$userId]);
                $data = $stmt->fetchAll();
                ?>

                <div class="row custom-row">
                    <?php foreach ($data as $el) { ?>
                        <div class="col-xl-4 col-sm-6 col-12">
                            <?php include("./elements/book-card.php") ?>
                        </div>
                    <?php }
                    if (empty($data)) {
                        echo "<h3 style='text-align: center;'>Нямате одобрени книги.</h3>";
                    } else {
                        ?>
                        <div class="row view-more-row">
                            <div class="col-xl-12">
                                <a href="my-books.php">
                                    <button class="view-all-btn">ВИЖ ВСИЧКИ</button>
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>

            </div>

            <br>
            <br>
            <br>
        </div>

        <?php include("./elements/footer.php") ?>


    </div>
</body>

</html>