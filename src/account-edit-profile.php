<?php
include("./admin-control/includes.php");
define('UPLOAD_DIR', __DIR__ . '/images/usersPfp/');

$errorsArray = array();
$userId = $_SESSION['user']['userID'];
$stmt = $connection->prepare("Select * from User where userID = ? ");

$stmt->execute([$userId]);
$user = $stmt->fetch();


if (!$user) {
    echo "<script>alert('За да редактирате профила си, моля първо влезте в него!');</script>";
    exit();
}

if (isset($_POST['save'])) {
    $username = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $oldPass = htmlspecialchars($_POST['old-pass'], ENT_QUOTES, 'UTF-8');
    $newPass = htmlspecialchars($_POST['new-pass'], ENT_QUOTES, 'UTF-8');
    $confirmPass = htmlspecialchars($_POST['confirm-pass'], ENT_QUOTES, 'UTF-8');
    $newPfp = $_FILES['newPfp'];
    $selectedGenres = htmlspecialchars($_POST['selectedGenres'], ENT_QUOTES, 'UTF-8');


    if ($newPfp['name']) {
        $fileTmpPath = $newPfp['tmp_name'];
        $fileName = basename($newPfp['name']);
        $fileType = mime_content_type($fileTmpPath);

        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (in_array($fileType, $allowedTypes)) {
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $uniqueName = uniqid('user_', true) . '.' . $fileExtension;
            $destination = UPLOAD_DIR . $uniqueName;

            print_r($destination);

            if (move_uploaded_file($fileTmpPath, $destination)) {
                $newPfp['name'] = $uniqueName;
            } else {
                echo "<p>Грешка при запазването на новата профилна снимка.</p>";
            }
        } else {
            echo "<p>Error: Невалиден снимков формат. Позволени: JPEG, PNG.</p>";
        }
    }

    $newPfpName = ($newPfp['name'] ? $newPfp['name'] : $user['profilePicture']);

    $finalPasswordHash = $user['passwordHashed'];

    if (!empty($oldPass) || !empty($newPass) || !empty($confirmPass)) {
        if (!password_verify($oldPass, $user['passwordHashed'])) {
            $errorsArray["oldPass"] = "Невалидна текуща парола.";
        }

        if ($newPass !== $confirmPass) {
            $errorsArray["newPass"] = "Новата парола и потвърждението не съвпадат.";
        }

        if (strlen($newPass) < 6) {
            $errorsArray["newPassLength"] = "Новата парола трябва да е поне 6 символа.";
        }

        if (empty($errorsArray)) {
            $finalPasswordHash = password_hash($newPass, PASSWORD_DEFAULT);
        }
    }

    function displayErrors($errorsArray)
    {
        ?>
        <div class="error-messages">
            <ul>
                <?php foreach ($errorsArray as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }

    if (empty($errorsArray)) {
        $updateStmt = $connection->prepare("UPDATE User SET username = ?, email = ?, passwordHashed = ?, profilePicture = ?, favouriteGenre = ? WHERE userID = ?");
        $updateStmt->execute([$username, $email, $finalPasswordHash, $newPfpName, $selectedGenres, $userId]);

        // Update session
        $stmt = $connection->prepare("SELECT * FROM User WHERE userID = ?");
        $stmt->execute([$userId]);
        $_SESSION['user'] = $stmt->fetch();

        echo "<script>alert('Промените са запазени успешно!'); window.location.href='account.php';</script>";
        exit();
    }

}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛитКрит - Редактирйте профил</title>
    <link rel="icon" href="pictures/logo-ico.ico" type="image/x-icon">
</head>

<body>
    <style>
        .error-messages {
            background: #ffeaea;
            border: 1px solid #ff5c5c;
            color: #b30000;
            padding: 16px 24px;
            margin: 24px auto;
            border-radius: 8px;
            max-width: 600px;
            font-size: 1.1em;
            box-shadow: 0 2px 8px rgba(255, 92, 92, 0.08);
            z-index: 20000;
        }

        .error-messages ul {
            margin: 0;
            padding-left: 20px;
        }

        .error-messages li {
            margin-bottom: 6px;
            list-style: disc inside;
        }
    </style>
    <div class="container-fluid">
        <?php include("./elements/header.php") ?>


        <!-- Section: Profile -->
        <div class="row my-profile" id="section-profile">
            <div class="col-xl-12 col-12 edit-user-info-col">
                <form method="post" enctype="multipart/form-data">
                    <div class="edit-container">

                        <div class="col-xl-6 col-12 edit-user-info">

                            <div class="edit-data-container">
                                <div class="edit-data-container-1">
                                    <label class="user-info-title">Потребителско име:</label>
                                    <input class="user-edit-input" type="text" name="name"
                                        value="<?= htmlspecialchars($user['username']); ?>"><br>

                                    <label class="user-info-title">Имейл:</label>
                                    <input class="user-edit-input" type="email" name="email"
                                        value="<?= htmlspecialchars($user['email']); ?>"><br>
                                </div>


                                <div class="edit-data-container-2">
                                    <label class="user-info-title">Парола:</label>
                                    <input class="user-edit-input" type="password" name="old-pass"
                                        placeholder="Въвеждане..."><br>

                                    <label class="user-info-title">Нова парола:</label>
                                    <input class="user-edit-input" type="password" name="new-pass"
                                        placeholder="Въвеждане..."><br>

                                    <label class="user-info-title">Потвърждаване на парола:</label>
                                    <input class="user-edit-input" type="password" name="confirm-pass"
                                        placeholder="Въвеждане..."><br><br>
                                </div>
                            </div>

                            <!-- Add hidden field -->
                            <div class="container">
                                <div class="button-group">
                                    <?php
                                    try {
                                        $stmt = $connection->prepare("SELECT * FROM Genre");
                                        $stmt->execute();
                                        $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);



                                        $userFavouriteGenres = explode(',', $user['favouriteGenre']);

                                        foreach ($genres as $genre) {
                                            $genreName = htmlspecialchars($genre['bookGenre']);
                                            $isSelected = in_array($genreName, $userFavouriteGenres) ? 'selected' : '';
                                            echo "<div class='genre-button {$isSelected}' onclick='toggleSelect(this)'>{$genreName}</div>";
                                        }
                                    } catch (PDOException $e) {
                                        echo "<p>В момента не можем да заредим жанровете. Моля опитайте по-късно.</p>";
                                    }
                                    ?>
                                </div>
                                <input type="hidden" name="selectedGenres" id="selectedGenres"
                                    value="<?= htmlspecialchars($user['favouriteGenre']); ?>" />
                            </div>





                        </div>

                        <div class="col-xl-6 col-12 profile-picture edit-picture">



                            <div class="pfp-image-upload">
                                <input type="file" name="newPfp" id="imageUpload2" accept="image/*" hidden>
                                <label for="imageUpload2" class="image-drop-area image-drop-area2">
                                    <img id="previewImage2" class="edit-image"
                                        src="images/usersPfp/<?= $user['profilePicture'] ?>" alt="Профилна снимка">
                                </label>
                            </div>

                            <?php
                            if (!empty($errorsArray)) {
                                displayErrors($errorsArray);
                            }
                            ?>


                            <div class="edit-btn-container edit-btns-big">
                                <!-- <a class="edit-profile-btn" name="save" href="account.php">Запази промените</a> -->
                                <a href="./account.php"><input type="submit" class="edit-profile-btn" name="save"
                                        value="Запази промените"></a>


                                <!-- if there are any changes -->
                                <a class="edit-profile-btn" href="account.php">Назад</a>
                            </div>
                        </div>

                        <div class="edit-btn-container edit-btns-sm">
                            <a class="edit-profile-btn" href="account.php">Запази промените</a>
                            <!-- if there are any changes -->
                            <a class="edit-profile-btn" href="account.php">Назад</a>
                        </div>


                    </div>
                </form>
            </div>
        </div>


        <!-- Section : My Reviews -->
        <div class="row my-reviews" id="section-my-reviews">
            <div class="col-xl-12">

                <h2 class="categories-h">Моите отзиви</h2>


                <?php

                $stmt = $connection->prepare("SELECT r.*, u.* FROM Reviews r JOIN User u ON r.userID = u.userID WHERE r.userID = ? and r.status = 'approved' LIMIT 4");
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
                    } ?>

                </div>
            </div>
            <br>
            <br>
            <br>
        </div>
        <?php include("./elements/footer.php") ?>
    </div>
    </div>


    <!-- Select Genre Bubbles JS -->
    <script>
        function toggleSelect(button) {
            button.classList.toggle('selected');
            const selectedGenres = Array.from(document.querySelectorAll('.genre-button.selected'))
                .map(btn => btn.textContent)
                .join(',');
            document.getElementById('selectedGenres').value = selectedGenres;
        }

        const imageUpload2 = document.getElementById('imageUpload2');
        const previewImage2 = document.getElementById('previewImage2');
        const dropAreaPFP2 = document.querySelector('.image-drop-area2');

        imageUpload2.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage2.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        dropAreaPFP2.addEventListener('dragover', function (e) {
            e.preventDefault();
            dropAreaPFP2.classList.add('dragging');
        });

        dropAreaPFP2.addEventListener('dragleave', function () {
            dropAreaPFP2.classList.remove('dragging');
        });

        dropAreaPFP2.addEventListener('drop', function (e) {
            e.preventDefault();
            dropAreaPFP2.classList.remove('dragging');
            const file = e.dataTransfer.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage2.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

    </script>



</body>
</html>