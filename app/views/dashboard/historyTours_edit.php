<?php

include __DIR__ . '/../header.php';
include __DIR__ . '/../navigationbar.php';

?>

<div class="container">
    <h1>Edit Tour</h1>
    <form method="POST" enctype="multipart/form-data">
        <?php if (isset($_SESSION['errorMessage'])): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= htmlspecialchars($_SESSION['errorMessage']); unset($_SESSION['errorMessage']) ?>
            </div>
        <?php endif; ?>
        <input type="hidden" name="id" value="<?= $editedHistoryTour->getId() ?>">
        <div class="mb-3">
            <label for="language">Language</label>
            <select class="form-select" id="language" name="language" required>
                <?php
                foreach ($languages as $language) {
                    echo "<option value={$language['languageId']} ". ($editedHistoryTour->getLanguage() === $language['name'] ? 'selected="selected"' : '') .">{$language['name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="startDateTime">Start Date/Time</label>
            <input type="datetime-local" class="form-control" id="startDateTime" name="startDateTime" value="<?= $editedHistoryTour->getStartDateTime()->format('Y-m-d H:i') ?>" required>
        </div>
        <div class="mb-3">
            <label for="maxParticipants">Maximum participants</label>
            <input type="text" class="form-control" id="maxParticipants" name="maxParticipants" value="<?= $editedHistoryTour->getMaxParticipants() ?>" required>
        </div>
        <div class="mb-3">
            <label for="price">Price</label>
            <input type="text" class="form-control" id="price" name="price" value="<?= number_format($editedHistoryTour->getPrice(),'2') ?>" required>
        </div>
        <div class="mb-3">
            <label for="tourGuide">Tour Guide</label>
            <input type="text" class="form-control" id="tourGuide" name="tourGuide" value="<?= $editedHistoryTour->getTourGuide() ?>" required>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Edit</button>
        <a class="btn btn-primary" href="../dashboard/historyTours" style="margin-top: 20px; margin-left: 40px;">Back to tours</a>
    </form>
</div>

<?php include __DIR__ . '/../footer.php'; ?>