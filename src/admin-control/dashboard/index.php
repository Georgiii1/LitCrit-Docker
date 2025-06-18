<?php
include("../includes.php");
// print_r($_SESSION);

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role']) || $_SESSION['user']['role'] != 'admin') {
    echo "<script>alert('Нямате достъп до съдържанието на страницата!'); window.location.href='". WEBSITE_URL . 'index.php' ."'</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Home</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        h2 {
            color: #4a4a8b;
        }

        .container {
            text-align: center;
            padding: 20px;
        }

        .wrapper {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 20px;
            padding: 20px;
        }

        .cont-1 {
            background-color: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .cont-1:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .cont-1 h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .cont-1 p {
            font-size: 1rem;
            line-height: 1.5;
        }

        .cont-1 p span {
            font-weight: bold;
            color: #4a4a8b;
        }

        .btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #4a4a8b;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #38386a;
        }

        header, footer {
            background-color: #4a4a8b;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }

        footer {
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .cont-1 {
                padding: 15px;
            }

            .cont-1 h2 {
                font-size: 1.2rem;
            }

            .cont-1 p {
                font-size: 0.9rem;
            }

            .btn {
                padding: 8px 16px;
            }
        }
    </style>
</head>

<body>
    <?php include("../includes/header.php"); ?>

    <div class="container">
        <h2>Welcome to the Admin Dashboard</h2>
        <p>Here you can manage users, books, and other sections of the website efficiently and effectively.</p>
    </div>

    <div class="wrapper">
        <div class="cont-1">
            <h2><i class="fa fa-users"></i> Registered Users</h2>
            <p>Number of registered users: <br>
                <span><?php
                $stmt = $connection->prepare("SELECT COUNT(*) FROM User");
                $stmt->execute();
                $userCount = $stmt->fetchColumn();
                echo htmlspecialchars($userCount);
                ?></span>
            </p>
            <!-- <a href="users.php" class="btn">View Details</a> -->
        </div>

        <div class="cont-1">
            <h2><i class="fa fa-book"></i> Books Added</h2>
            <p>Number of books: <br>
                <span><?php
                $stmt = $connection->prepare("SELECT COUNT(*) FROM Books");
                $stmt->execute();
                $bookCount = $stmt->fetchColumn();
                echo htmlspecialchars($bookCount);
                ?></span>
            </p>
            <!-- <a href="books.php" class="btn">View Details</a> -->
        </div>

        <div class="cont-1">
            <h2><i class="fa fa-clipboard-list"></i> Books Pending Review</h2>
            <p>Number of books: <br>
                <span><?php
                $stmt = $connection->prepare("SELECT COUNT(*) FROM Books WHERE status = 'pending'");
                $stmt->execute();
                $pendingBooks = $stmt->fetchColumn();
                echo htmlspecialchars($pendingBooks);
                ?></span>
            </p>
            <!-- <a href="pending-books.php" class="btn">Review Books</a> -->
        </div>

        <div class="cont-1">
            <h2><i class="fa fa-comments"></i> Reviews to Check</h2>
            <p>Number of reviews: <br>
                <span><?php
                $stmt = $connection->prepare("SELECT COUNT(*) FROM Reviews WHERE status = 'pending'");
                $stmt->execute();
                $pendingReviews = $stmt->fetchColumn();
                echo htmlspecialchars($pendingReviews);
                ?></span>
            </p>
            <!-- <a href="pending-reviews.php" class="btn">Check Reviews</a> -->
        </div>
    </div>

</body>

</html>
