<a href="book-details.php?id=<?php echo $el["bookID"]; ?>">

<div class="book-card-waiting">

    <img class="img-fluid book-cover" src="<?php echo $el["bookCover"]; ?>" alt="корица">

    <div class="book-card-body">
    <h5 class="title"><?php echo $el["bookTitle"]?></h5>
        <h4 class="author"><?php echo $el["bookAuthor"]?></h4>
        <h4 class="genre"><?php echo $el["bookGenre"]?></h4>
    </div>

</div>

<p class="rating-p book-rating-p">
    <div class="rating rating-div">  
        <div class="stars-landing" id="stars-box" style="--rating: 0;">⭐⭐⭐⭐⭐</div>
    </div>
</p>

</a>