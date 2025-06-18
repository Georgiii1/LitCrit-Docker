<a href="book-details.php?id=<?php echo $el["bookID"]; ?>">
    <div class="book-card">
        <img class="img-fluid book-cover" src="images/covers/<?php echo $el["bookCover"]; ?>" alt="корица">

        <div class="book-card-body">
            <h5 class="title"><?php echo $el["bookTitle"] ?></h5>
            <h4 class="author"><?php echo $el["bookAuthor"] ?></h4>
            <h4 class="genre"><?php echo $el["bookGenre"] ?></h4>

            <div class="rating rating-div">
                <?php
                $average = $el['rating_count'] > 0 ? round($el['rating_sum'] / $el['rating_count'], 2) : 0;
                ?>
            </div>
            <div>
                <div class="stars-landing" style="--rating: <?= $average ?>;">
                    ⭐⭐⭐⭐⭐
                </div>
                <span style="margin-left:8px; color:#333; font-size:16px;">
                    <?= ($average > 0) ? "{$average}/5" : "Няма оценка" ?>
                </span>
            </div>
        </div>
    </div>
</a>