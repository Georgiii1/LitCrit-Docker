<?php
include("../../includes.php");
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
    <title>Admin | Users</title>
    <style>
        body {
            margin-left: 250px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            text-align: left;
        }

        table thead tr {
            color: #969696;
            text-align: center;
        }

        table th,
        table td {
            padding: 12px 15px;
            border: 1px solid #dddddd;
        }

        table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        table tbody tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        .edit-icon {
            color: #007bff;
            font-size: 18px;
            text-decoration: none;
        }

        .edit-icon:hover {
            color: #0056b3;
        }
    </style>
</head>

<body>
    <?php include "../../includes/header.php"; ?>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        try {
            $stmt = $connection->prepare("SELECT u.userID, u.username, u.email FROM User AS u");
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo json_encode(["error" => "Failed to fetch users: " . $e->getMessage()]);
            exit;
        }
    }
    ?>

    <h1>Потребители</h1>
    <div class="table-wrapper"></div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Потребителско име</th>
                <th>Имейл</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['userID']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td>
                            <a href="edit-user.php?userID=<?php echo urlencode($user['userID']); ?>" class="edit-icon"
                                title="Edit">
                                <i class="fa-solid fa-circle-user"></i>
                            </a>
                            <a style="color:red; margin: 5px;" href="delete.php?userID=<?php echo urlencode($user['userID']); ?>" class="edit-icon" title="delete">
                        <i class="fa-solid fa-trash"></i>
                        </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align:center;">Няма намерени потребители.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>