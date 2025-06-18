<?php include("./database/connection.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛитКрит - Добави Книга</title>
    <link rel="icon" href="pictures/logo-ico.ico" type="image/x-icon">

</head>

<?php
include("./elements/header.php");
if (isset($_POST['submit'])) {
    $user = $_SESSION['user']['userID'];

    if (!$user) {
        echo "<script>alert('No user is logged in!'); window.history.back();</script>";
        exit;
    }

    // Sanitize input
    $bookTitle = htmlspecialchars(trim($_POST['bookTitle']), ENT_QUOTES, 'UTF-8');
    $bookAuthor = htmlspecialchars(trim($_POST['bookAuthor']), ENT_QUOTES, 'UTF-8');
    $yearOfPublishing = filter_var($_POST['yearOfPublishing'], FILTER_SANITIZE_NUMBER_INT);
    $bookGenre = htmlspecialchars(trim($_POST['bookGenre']), ENT_QUOTES, 'UTF-8');
    $bookAnnotation = htmlspecialchars(trim($_POST['bookAnnotation']), ENT_QUOTES, 'UTF-8');

    // Check if book already exists
    $checkSql = "SELECT 1 FROM Books WHERE bookTitle = ? AND bookAuthor = ? AND bookGenre = ?";
    $checkStmt = $connection->prepare($checkSql);
    $checkStmt->execute([$bookTitle, $bookAuthor, $bookGenre]);
    if ($checkStmt->fetch()) {
        echo "<script>alert('Тази книга вече съществува!'); window.history.back();</script>";
        exit;
    }

    $file = $_FILES['bookCover'];
    $file_name = basename($_FILES['bookCover']['name']);
    $file_temp = $_FILES['bookCover']['tmp_name'];
    $file_type = $_FILES['bookCover']['type'];

    $target_file = null;

    function areEmpty($bookTitle, $bookAuthor, $yearOfPublishing, $bookGenre, $bookAnnotation, $fileName)
    {
        if (empty($bookTitle) || empty($bookAuthor) || empty($yearOfPublishing) || empty($bookGenre) || empty($bookAnnotation) || empty($fileName)) {
            return "Полетата са задължителни";
        }
        return "";
    }

    if (!empty($file_name)) {
        if ($file_type != "image/jpeg" && $file_type != "image/png" && $file_type != "image/jpg") {
            echo "Прикачете снимка във формат jpeg или png<br><br>";
            exit;
        }

        $unique_name = uniqid() . ".jpg";

        if (move_uploaded_file($file_temp, "images/" . $unique_name)) {
            $target_file = "images/" . $unique_name;
        } else {
            echo "Неуспешно качване на файла. <br><br>";
            exit;
        }

        $genreQuery = "SELECT genreID FROM genre WHERE bookGenre = ?";
        $genreStmt = $connection->prepare($genreQuery);
        $genreStmt->execute([$bookGenre]);
        $genreRow = $genreStmt->fetch(PDO::FETCH_ASSOC);

        if (!$genreRow) {
            echo "Невалиден жанр!<br><br>";
            exit;
        }
        $genreID = $genreRow['genreID'];
        $userId = $_SESSION['user']['userID'];

        // INSERT заявка към базата, с която се записват полетата

        $sql = "INSERT INTO Books (bookTitle, bookAuthor, yearOfPublishing, bookGenre, bookAnnotation, bookCover, dateAdded, userID) VALUES (?,?,?,?,?,?, CURRENT_TIMESTAMP, ?)";

        $sth = $connection->prepare($sql);

        try {
            $sth->execute([
                $bookTitle,
                $bookAuthor,
                $yearOfPublishing,
                $genreID,
                $bookAnnotation,
                $target_file,
                $userId
            ]);
            echo "<script>alert('Книгата е добавена успешно!');</script>";
        } catch (PDOException $e) {
            echo "Грешка при добавяне на книгата: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }
    }
}

?>

<body>

    <div class="container-fluid">



        <form method="post" enctype="multipart/form-data">

            <div class="container py-5">
                <div class="row align-items-center">

                    <!-- Left: Book Cover -->
                    <div class="col-4 cover-details">
                        <!-- Drag and Drop Area -->
                        <div id="drop-area" class="drop-area">
                            <p>*Изберете снимка</p>
                            <label for="file-input" class="upload-label">Търсене в устройството</label>
                            <input name="bookCover" type="file" id="file-input" accept="image/*" class="file-input"
                                style="display: none;">
                            <img id="cover-preview" src="" alt="cover" class="img-fluid cover-2">

                        </div>
                    </div>

                    <div class="col-1 empty-col"></div>

                    <!-- Right: Form -->
                    <div class="col-7 text-details">

                        <div class="container page-label-div">
                            <h2 class="PageTitle">Добавяне на книга</h2>
                            <br>
                        </div>


                        <div class="form-group">
                            <label for="bookTitle"
                                class="detail-title add-book-label"><strong>*Заглавие:</strong></label>
                            <input name="bookTitle" type="text" class="form-control" id="bookTitle" required
                                placeholder="Въведете заглавието на книгата">
                        </div>

                        <div class="form-group">
                            <label for="bookAuthor" class="detail-title add-book-label"><strong>*Автор:</strong></label>
                            <input name="bookAuthor" type="text" class="form-control" id="bookAuthor" required
                                placeholder="Въведете името на автора">
                        </div>

                        <div class="form-group">
                            <label for="bookYear" class="detail-title add-book-label"><strong>*Година:</strong></label>
                            <input name="yearOfPublishing" type="number" class="form-control" id="yearOfPublishing"
                                required placeholder="Въведете годината на издаване">
                        </div>


                        <div class="form-group">
                            <label for="bookGenre" class="detail-title add-book-label"
                                required><strong>*Жанр:</strong></label>
                            <select name="bookGenre" class="form-control" id="bookGenre">
                                <option value="" disabled selected>Изберете жанр</option>

                                <option id="1" value="Поезия">Поезия</option>
                                <option id="2" value="Проза">Проза</option>
                                <option id="3" value="Роман">Роман</option>
                                <option id="4" value="Детска Литература">Детска Литература</option>
                                <option id="5" value="Романтика">Романтика</option>
                                <option id="6" value="Комедия">Комедия</option>
                                <option id="7" value="Криминалистика">Криминалистика</option>
                                <option id="8" value="Фантастика">Фантастика</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="bookAnnotation"
                                class="detail-title add-book-label"><strong>Анотация:</strong></label>
                            <textarea name="bookAnnotation" class="form-control annotation-input" id="bookAnnotation"
                                rows="4" placeholder="Въведете анотация"></textarea>
                        </div>


                        <button name="submit" type="submit" class="btn edit-profile-btn mt-3"
                            onclick="toggleBookPopup()">Добави книга</button>

                        <div id="bookPopup" class="popup">
                            <div class="popup-content book-popup-content">
                                <span class="close-btn close-book-popup-btn" onclick="toggleBookPopup()">&times;</span>
                                <h2 class="page-category-title my-books-title">Моите книги</h2>

                                <div class="book-card book-card-popup">
                                    <img class="img-fluid book-cover" src="images/677ff17ba16a2.jpg" alt="корица">
                                    <div class="book-card-body">
                                        <h5 class="title">Заглавие</h5>
                                        <h4 class="author">Автор</h4>
                                        <h4 class="genre">Жанр</h4>
                                        <p class="rating">
                                        <div class="rating" style="position:relative; top:-60px; height:0px">
                                            <h5 class="rating-txt">Оценка:</h5>
                                            <div class="stars-landing" id="stars-box" style="--rating: 3; height:0px">
                                                ⭐⭐⭐⭐⭐</div>
                                        </div>
                                        </p>
                                    </div>
                                </div>


                                <a href="my-books.php" class="view-all-btn popup-open-book-btn">Преглед</a>
                            </div>
                        </div>

                        <!-- IF THE BOOK ALREADY EXISTS??! -->

                    </div>

                </div>

        </form>
    </div>


    <?php include("./elements/footer.php") ?>


    <script>
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('file-input');
        const coverPreview = document.getElementById('cover-preview');

        // Prevent default behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Highlight drop area
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => dropArea.classList.add('drag-over'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => dropArea.classList.remove('drag-over'), false);
        });

        // Handle dropped files
        dropArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            handleFiles(files);
        }

        // Handle file input change
        fileInput.addEventListener('change', (e) => {
            handleFiles(fileInput.files);
        });

        function handleFiles(files) {
            const file = files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = () => {
                    coverPreview.src = reader.result;
                    coverPreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }
    </script>


    <script>
        function toggleBookPopup() {
            const popup = document.getElementById('bookPopup');
            popup.style.display = popup.style.display === 'flex' ? 'none' : 'flex';
        }

    </script>
    </div>

</body>

</html>