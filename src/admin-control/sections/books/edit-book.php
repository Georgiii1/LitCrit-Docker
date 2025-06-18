<?php
include("../../includes.php");
define("UPLOAD_DIR", PATH . "images/covers/");
include("../../includes/header.php");

if (!isset($_GET['bookID'])) {
    die("Error: Book ID is missing.");
}

$bookID = $_GET['bookID'];
$stmt = $connection->prepare("SELECT b.*, g.bookGenre, g.genreID FROM Books b JOIN genre g ON b.bookGenre = g.genreID WHERE bookID = ?");
$stmt->execute([$bookID]);
$book = $stmt->fetch();

if (!$book) {
    die("Error: Book not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];
    $genre = $_POST['genre'];
    $annotation = $_POST['annotation'];
    $status = $_POST['status'];
    $cover = $book['bookCover'];

    if (!empty($_FILES['cover']['name'])) {
        $file = $_FILES['cover'];
        $fileTmpPath = $file['tmp_name'];
        $fileName = $file['name'];
        $fileType = $file['type'];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (in_array($fileType, $allowedTypes)) {
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $uniqueName = uniqid() . '.' . $fileExtension;
            $destination = UPLOAD_DIR . $uniqueName;

            if (move_uploaded_file($fileTmpPath, $destination)) {
                $cover = "images/covers/" . $uniqueName;
            } else {
                echo "<p>Error uploading the cover image. Keeping existing cover.</p>";
            }
        } else {
            echo "<p>Error: Invalid image format. Please upload a JPEG or PNG file.</p>";
        }
    }

    // Update book details
    $updateStmt = $connection->prepare("UPDATE Books SET bookTitle = ?, bookAuthor = ?, yearOfPublishing = ?, bookGenre = ?, bookAnnotation = ?, bookCover = ?, status = ? WHERE bookID = ?");
    $updateStmt->execute([$title, $author, $year, $genre, $annotation, $cover, $status, $bookID]);
    echo "<p>Book details updated successfully!</p>";

    // Refresh book data
    $stmt->execute([$bookID]);
    $book = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book - <?= htmlspecialchars($book["bookTitle"]) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .book-container {
            display: flex;
            flex-direction: row;
            gap: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .form2 {
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 100%;
        }

        label {
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus,
        textarea:focus {
            border-color: #327bca;
            outline: none;
            box-shadow: 0 0 5px rgba(50, 123, 202, 0.5);
        }

        textarea {
            resize: none;
        }

        button {
            background-color: #327bca;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #285a8e;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #327bca;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .book-cover {
            position: relative;
            cursor: pointer;
            width: 300px;
            height: 450px;
            flex-shrink: 0;
        }

        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 5px;
        }

        .book-cover input {
            display: none;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 18px;
            border-radius: 5px;
        }

        .book-cover:hover .overlay {
            opacity: 1;
        }

        @media (max-width: 768px) {
            .book-container {
                flex-direction: column;
                align-items: center;
            }

            .book-cover {
                width: 100%;
                height: auto;
            }

            .book-cover img {
                height: auto;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Редактиране на съдържание на книга</h2>

        <form method="POST" enctype="multipart/form-data">
            <div class="book-container">
                <div class="book-cover" id="coverContainer">
                    <img id="coverPreview" src="<?= COVERS_PATH . htmlspecialchars($book['bookCover']) ?>" alt="Book Cover">
                    <div class="overlay">Натиснете, за да промените</div>
                    <input type="file" id="coverInput" name="cover" accept="image/*">
                </div>

                <span class="form2">
                    <label>Заглавие:</label>
                    <input type="text" name="title" value="<?= htmlspecialchars($book['bookTitle']) ?>" required>

                    <label>Автор:</label>
                    <input type="text" name="author" value="<?= htmlspecialchars($book['bookAuthor']) ?>" required>

                    <label>Година:</label>
                    <input type="number" name="year" value="<?= htmlspecialchars($book['yearOfPublishing']) ?>" required>

                    <label>Жанр:</label>


                    <select name="genre" required>
                        <?php
                        $genresStmt = $connection->prepare("SELECT genreID, bookGenre FROM genre");
                        $genresStmt->execute();
                        $genres = $genresStmt->fetchAll();
                        foreach ($genres as $g) {
                            $selected = $g['genreID'] == $book['genreID'] ? 'selected' : '';
                            echo "<option value='{$g['genreID']}' $selected>" . htmlspecialchars($g['bookGenre']) . "</option>";
                        }
                        ?>
                    </select>

                    <label>Статус:</label>
                    <select name="status" required>
                        <option value="pending" <?= $book['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="approved" <?= $book['status'] == 'approved' ? 'selected' : '' ?>>Approved</option>
                        <option value="declined" <?= $book['status'] == 'declined' ? 'selected' : '' ?>>Declined</option>
                    </select>

                    <label>Анотация:</label>
                    <textarea name="annotation" rows="4" required><?= htmlspecialchars($book['bookAnnotation']) ?></textarea>

                    <button type="submit">Запазете промените</button>
                </span>
            </div>
        </form>

        <a href="./list.php">Обратно към всички книги</a>
    </div>

    <script>
        document.getElementById('coverContainer').addEventListener('click', function () {
            document.getElementById('coverInput').click();
            alert("1");
        });

        document.getElementById('coverInput').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('coverPreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>
