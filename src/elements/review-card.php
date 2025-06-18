<div class="card review-card">
    <div class="card-header info">
        <p><strong class="rev-card-data">Потребителско име:</strong> <?= $rev["username"] ?> </p>
        <p><strong class="rev-card-data">Дата: </strong><?php
        $dateAddedDB = $rev["dateAdded"];
        $dateAdded = date('d-m-Y', strtotime($dateAddedDB));
        echo $dateAdded;
        ?></p>
    </div>

    <div class="card-body">
        <h5 class="card-title book-title"> <?= $rev["title"] ?></h5>
        <p class="card-text"> <?= $rev["review"] ?> </p>

        <p class="rating-p ">
        <div class="rating rating-div rating-rev-div">
            <div>
                <?php $ratingVal = $rev['rating'] ?? 0; ?>
                <div class="stars-landing" style="--rating: <?= $ratingVal ?>;">
                    ⭐⭐⭐⭐⭐
                </div>
                <span style="margin-left:8px; color:#333; font-size:14px;">
                    <?= ($ratingVal > 0) ? "{$ratingVal}/5" : "Няма оценка" ?>
                </span>
            </div>
        </div>
        </p>

        <!-- LOAD ONLY ON "MY REVIEWS" -->
        <?php
        $UIRL_REV = strpos($_SERVER['REQUEST_URI'], "/LitCrit/my-reviews.php");
        $UIRL_ACC = strpos($_SERVER['REQUEST_URI'], "/LitCrit/account.php");
        if ($UIRL_REV !== false || $UIRL_ACC !== false) {
            $id = (int) $rev["reviewID"];
            echo "<a href='book-details.php?id=" . htmlspecialchars($id, ENT_QUOTES, 'UTF-8') . "' class='btn open-review-btn'>Отвори</a>";
        }
        ?>

    </div>


    <!-- LOAD THE MENU ONLY FOR THE USER'S REVIEWS -->
    <div class="menu">
        <?php
        $uID = $_SESSION['user']['userID'] ?? null;
        if ($rev['userID'] == $uID) {
            include("review-actions.php");
        } ?>
    </div>
</div>