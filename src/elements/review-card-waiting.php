<div class="card review-card-waiting">
    <div class="card-header info">
        <p><strong class="rev-card-data">Потребителско име: </strong> <?= $rev["username"] ?> </p>
        <p><strong class="rev-card-data">Дата: </strong>
            <?php
            $dateAddedDB = $rev["dateAdded"];
            $dateAdded = date('d-m-Y', strtotime($dateAddedDB));
            echo $dateAdded;
            ?>
        </p>
    </div>

    <div class="card-body">
        <h5 class="card-title book-title"> <?= $rev["title"] ?></h5>

        <p class="card-text"> <?= $rev["review"] ?> </p>

        <a href="book-details.php" class="btn open-review-btn">Отвори</a>


        <p class="rating-p ">
        <div class="rating rating-div rating-rev-div">
            <div class="stars-landing" id="stars-box" style="--rating: 0;">⭐⭐⭐⭐⭐</div>
        </div>
        </p>

    </div>

    <div class="menu">
        <div class="dots-menu">
            <button class="dots-button">&#x22EE;</button>
            <div class="dropdown-options">
                <a href="#" class="dropdown-option">Редактирай</a>
                <a href="#" class="dropdown-option">Изтрий</a>
            </div>
        </div>
    </div>
</div>