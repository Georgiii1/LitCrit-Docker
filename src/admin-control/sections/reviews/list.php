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
    <title>Admin | Reviews</title>

    <style>
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

        /* Badge styles */
        .status-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: bold;
            display: inline-block;
        }

        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }

        .status-declined {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        /* Edit icon styles */
        .edit-icon {
            color: #007bff;
            font-size: 18px;
            text-decoration: none;
        }

        .edit-icon:hover {
            color: #0056b3;
        }

        /* Check automatically */
        .checkAuto {
            background-color: red;
            color: white;
            border-radius: 10px;
            padding: 15px;
            text-decoration: none;
            margin: 20px 0;
        }
    </style>
</head>

<body>

    <?php include "../../includes/header.php"; ?>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        try {
            $stmt = $connection->prepare("
                SELECT Reviews.*, Books.bookTitle AS bookTitle 
                FROM Reviews 
                LEFT JOIN Books ON Reviews.bookReviewID = Books.bookID
            ");
            $stmt->execute();
            $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo json_encode(["error" => "Failed to fetch reviews: " . $e->getMessage()]);
            exit;
        }
    }
    ?>

    <h1>Отзиви</h1>
    <div class="table-wrapper"></div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Отзив</th>
                <th>Заглавие на книга</th>
                <th>Дата на добавяне</th>
                <th>Добавено от потребител</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($review['reviewID']); ?></td>
                        <td><?php echo htmlspecialchars($review['review']); ?></td>
                        <td><?php echo htmlspecialchars($review['bookTitle']); ?></td>
                        <td><?php echo htmlspecialchars($review['dateAdded']); ?></td>
                        <td><?php echo htmlspecialchars($review['userID']); ?></td>
                        <td>
                            <?php
                            $status = strtolower($review['status']);
                            $statusClass = 'status-badge ';
                            if ($status === 'approved') {
                                $statusClass .= 'status-approved';
                            } elseif ($status === 'declined') {
                                $statusClass .= 'status-declined';
                            } elseif ($status === 'pending') {
                                $statusClass .= 'status-pending';
                            } else {
                                $statusClass .= 'status-pending';
                            }
                            ?>
                            <span class="<?php echo $statusClass; ?>">
                                <?php echo ucfirst($status); ?>
                            </span>
                        </td>
                        <td>
                            <a href="edit-review.php?reviewID=<?php echo urlencode($review['reviewID']); ?>" class="edit-icon"
                                title="Edit">
                                <i class="fa-solid fa-comment"></i>
                            </a>
                            <a style="color:red; margin: 5px;"
                                href="delete.php?reviewID=<?php echo urlencode($review['reviewID']); ?>" class="edit-icon"
                                title="delete">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align:center;">Няма намерени отзиви.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a class="checkAuto" href="../../dashboard/moderate-reviews-deepseek.php">Check automatically</a>

</body>

</html>