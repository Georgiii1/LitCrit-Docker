<?php
if (!function_exists('deleteReview')) {
    function deleteReview($reviewId)
    {
        global $connection;
        $stmt = $connection->prepare("DELETE FROM Reviews WHERE reviewID = ?");
        $stmt->execute([$reviewId]);
    }
}


if (isset($_POST['delete'])) {
    deleteReview(intval($_POST['review_id']));
    echo "<script>alert('Отзивът беше изтрит успешно!'); window.location.reload();</script>";
}

if (isset($_POST['edit'])) {
    $reviewId = intval($_POST['review_id']);
    $reviewText = $_POST['edit_review_text'];
    $stmt = $connection->prepare("UPDATE Reviews SET review = ? WHERE reviewID = ?");
    $stmt->execute([$reviewText, $reviewId]);
    echo "<script>alert('Отзивът беше редактиран успешно!'); window.location.reload();</script>";
}
?>


<form method="post" action="">
    <input type="hidden" name="review_id" value="<?= $rev["reviewID"]; ?>">
    <div class="dots-menu">
        <button type="button" class="dots-button">&#x22EE;</button>
        <div class="dropdown-options">
            <button type="submit" name="edit" value="edit" class="dropdown-option"
                onclick="togglePopupEdit(); return false;">Редактирай</button>
            <button type="submit" name="delete" value="delete" class="dropdown-option"
                onclick="return confirmDelete(event);">Изтрий</button>
        </div>
    </div>
</form>

<script>
    function confirmDelete(event) {
        if (!confirm('Сигурни ли сте, че искате да изтриете този отзив?')) {
            event.preventDefault();
            return false;
        }
        return true;
    }

    function togglePopupEdit() {
        const popup = document.getElementById('popup');
        popup.style.display = popup.style.display === 'flex' ? 'none' : 'flex';
    }
</script>