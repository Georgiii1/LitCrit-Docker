<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin-left: 100px;
            padding: 0;
            background-color: #f4f4f4;
        }

        .header {
            background-color: #333;
            color: #fff;
            padding: 15px 0;
            text-align: center;
            width: 80px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }

        .header h1 {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            font-size: 16px;
            margin: 0;
        }

        .header nav {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        .header nav a {
            color: #fff;
            text-decoration: none;
            margin: 10px 0;
            font-size: 18px;
            text-align: center;
        }

        .header nav a:hover {
            text-decoration: none;
            color:rgb(161, 161, 161);
        }
    </style>
</head>

<body>
    <div class="header">
        <nav>
            <a href="<?= ADMIN_URL ?>/dashboard">
            <i class="fa-solid fa-house"></i>
            <span>Начало</span>
            </a>
            <a href="<?= ADMIN_URL ?>sections/users/list.php">
                <i class="fa-solid fa-circle-user"></i>
                <span>Потребители</span>
            </a>
            <a href="<?= ADMIN_URL ?>sections/books/list.php">
                <i class="fa-solid fa-book-open"></i>
                <span>Книги</span>
            </a>
            <a href="<?= ADMIN_URL ?>sections/reviews/list.php">
                <i class="fa-solid fa-comments"></i>
                <span>Отзиви</span>
            </a>
            <a href="<?= WEBSITE_URL ?>">
                <i class="fa-solid fa-globe"></i>
                <span>Уебсайт</span>
            </a>
            <a href="#">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Изход</span>
            </a>
        </nav>
        <style>
            .header nav a {
                display: flex;
                flex-direction: column;
                align-items: center;
                color: #fff;
                text-decoration: none;
                margin: 10px 0;
                font-size: 18px;
                text-align: center;
            }

            .header nav a span {
                font-size: 12px;
                margin-top: 5px;
            }
        </style>
    </div>
</body>

</html>
</div>