<?php  include("./database/connection.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ЛитКрит - Начало</title>
    <link rel="icon" href="pictures/logo-ico.ico" type="image/x-icon">

</head>


<body>
    <?php include("./elements/header.php") ?>

    <div class="container-fluid">

        <div class="row motto-row">
            <div class="col-xl-12">

                <div class="carousel">
                    <div class="carousel-inner index-photo-inner">
                        <div>
                            <img src="pictures/index-photo.jpg" class="d-block w-100 index-photo" alt="...">
                            <div class="carousel-caption d-md-block">
                                <h5 class="index-title">ЛитКрит</h5>
                                <p class="index-motto">Открий следващата си любима книга</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php $data = $connection->query("Select b.*, g.bookGenre from Books b JOIN genre g on b.bookGenre = g.genreID ORDER BY b.rating_sum / NULLIF(b.rating_count, 0) DESC")->fetchAll(); ?>
        <div class="row most-popular">
            <div class="col-xl-12">
                <h2 class="categories-h">Най-популярни</h2>


                <!-- slider1 : big -->
                <?php if ($data) { ?>
                    <div id="carousel-popular" class="carousel slide slide-screen">
                        <div class="carousel-inner">
                            <?php include("./elements/slider-big.php"); ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-popular"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel-popular"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>



                    <!-- slider1 : middle -->

                    <div id="carousel-popular-middle" class="carousel slide slide-middle">
                        <div class="carousel-inner">

                            <?php include("./elements/slider-middle.php") ?>

                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-popular-middle"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel-popular-middle"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>


                    <!-- slider1 : mobile -->
                    <div id="carousel-popular-mobile" class="carousel slide slide-mobile">
                        <div class="carousel-inner">

                            <?php include("./elements/slider-mobile.php") ?>

                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-popular-mobile"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel-popular-mobile"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

                <div class="row view-more-row">
                    <div class="col-xl-12">
                        <a href="book-category.php?category=popular">
                            <button class="view-all-btn">ВИЖ ОЩЕ</button>
                        </a>
                    </div>
                </div>

                <?php
                } else {
                    echo "<h3 style='text-align: center;'> Все още няма добавени книги. </h3>";
                } ?>
            </div>
        </div>

        <br>
        <br>
        <br>

        <?php
        $data = $connection->query("SELECT b.*, g.bookGenre FROM Books b JOIN genre g ON b.bookGenre = g.genreID")->fetchAll();
        shuffle($data);
        ?>
        <div class="row suggested">
            <div class="col-xl-12">
                <h2 class="categories-h">Препоръчани за Вас</h2>

                <!-- slider2 : big -->
                <?php if ($data) { ?>
                    <div id="carousel-suggested" class="carousel slide slide-screen">
                        <div class="carousel-inner">
                            <?php include("./elements/slider-big.php") ?>

                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-suggested"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel-suggested"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>



                    <!-- slider2 : middle -->
                    <div id="carousel-suggested-middle" class="carousel slide slide-middle">
                        <div class="carousel-inner">

                            <?php include("./elements/slider-middle.php") ?>

                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-suggested-middle"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel-suggested-middle"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>



                    <!-- slider2 : mobile -->
                    <div id="carousel-suggested-mobile" class="carousel slide slide-mobile">
                        <div class="carousel-inner">

                            <?php include("./elements/slider-mobile.php") ?>

                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-suggested-mobile"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel-suggested-mobile"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>


                <div class="row view-more-row">
                    <div class="col-xl-12">
                        <a href="book-category.php?category=suggested">
                            <button class="view-all-btn">ВИЖ ОЩЕ </button>
                        </a>
                    </div>
                </div>

                <?php
                } else {
                    echo "<h3 style='text-align: center;'> Все още няма добавени книги. </h3>";
                } ?>
        </div>
    </div>

    <br>
    <br>
    <br>

    <?php $data = $connection->query("Select b.*, g.bookGenre from Books b JOIN genre g on b.bookGenre = g.genreID ORDER BY dateAdded DESC LIMIT 9")->fetchAll(); ?>
    <div class="row new">
        <div class="col-xl-12">
            <h2 class="categories-h">Нови</h2>

            <!-- slider3 : big -->

            <?php if ($data) { ?>
                <div id="carousel-new" class="carousel slide slide-screen">
                    <div class="carousel-inner">
                        <?php include("./elements/slider-big.php") ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-new" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel-new" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>



                <!-- slider3 : middle -->
                <div id="carousel-new-middle" class="carousel slide slide-middle">
                    <div class="carousel-inner">

                        <?php include("./elements/slider-middle.php") ?>

                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-new-middle"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel-new-middle"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>


                <!-- slider3 : mobile -->
                <div id="carousel-new-mobile" class="carousel slide slide-mobile">
                    <div class="carousel-inner">

                        <?php include("./elements/slider-mobile.php") ?>

                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-new-mobile"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel-new-mobile"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <div class="row view-more-row">
                <div class="col-xl-12">
                    <a href="book-category.php?category=new">
                        <button class="view-all-btn">ВИЖ ОЩЕ </button>
                    </a>
                </div>
            </div>
            <?php
            } else {
                echo "<h3 style='text-align: center;'> Все още няма добавени книги. </h3>";
            } ?>
        </div>
    </div>


    <?php include("./elements/footer.php") ?>

    </div>

</body>

</html>