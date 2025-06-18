<div id="popup" class="popup" style="display:none;">
    <div class="popup-content">
        <span class="close-btn" onclick="togglePopupEdit()">&times;</span>
        <h2>Редактирай отзив</h2>
        <form method="post" action="">
            <input type="hidden" name="review_id" value="<?= $rev["reviewID"]; ?>">
            <label for="edit_review_text">Текст на отзива:</label>
            <textarea id="edit_review_text" name="edit_review_text" rows="4"
                required><?= htmlspecialchars($rev["reviewText"]); ?></textarea>
            <br>
            <button type="submit" name="edit" value="save_edit">Запази</button>
        </form>
    </div>
</div>