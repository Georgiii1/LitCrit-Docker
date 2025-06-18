<?php
include '../../includes.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            background: #eaeaea;
            /* background-color: #548ca0; */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 420px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            background-color: #548ca0;
            color: white;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            padding: 32px 28px 28px 28px;
        }

        h1 {
            text-align: center;
            color: bla;
            margin-bottom: 28px;
            font-size: 2rem;
            letter-spacing: 1px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        label {
            font-weight: 500;
            color: #444;
            margin-bottom: 2px;
            color: white;
        }

        input[type="text"],
        input[type="email"],
        select {
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            background: #fafafa;
            transition: border-color 0.2s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus {
            border-color: #007bff;
            outline: none;
        }

        button[type="submit"] {
            margin-top: 10px;
            padding: 12px 0;
            background-color:rgba(211, 83, 83, 0.92);
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.08);
            transition: background 0.2s;
        }

        button[type="submit"]:hover {
            background-color:rgba(211, 83, 83, 0.74);
        }

        img {
            display: block;
            margin: 0 auto 18px auto;
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #007bff;
            background: #e9ecef;
        }
        a {
            text-decoration: none;
            color: white;
            font-weight: 500;
            text-align: center;
            margin-top: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Редакция на потребителски профил</h1>
        <form action="" method="POST">
            <?php
            $uID = $_GET['userID'];
            $stmt = $connection->prepare("SELECT * FROM User WHERE userID = ?");
            $stmt->execute([$uID]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>

            <img src="../../../images/usersPfp/<?= $user['profilePicture'] ?>" alt="User Profile Picture">

            <input type="hidden" name="userID" value="<?= $user['userID']; ?>">
            <div class="form-group">
                <label for="username">Потребителско име:</label>
                <input type="text" id="username" name="username" value="<?= $user['username']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Имейл:</label>
                <input type="email" id="email" name="email" value="<?= $user['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="role">Роля:</label>
                <select id="role" name="role">
                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="user" <?= $user['role'] == 'user' ? 'selected' : ''; ?>>User</option>
                </select>
            </div>
            <button type="submit">Актуализирайте информацията</button>
            <a href="./list.php">Обратно към всички потребители</a>
        </form>
    </div>
</body>

</html>