<?php

include __DIR__ . '/../header.php';
include __DIR__ . '/../navigationbar.php';

?>

    <script type="text/javascript">
        tinymce.init({
            selector: "#aboutTextarea",
            height: 400
        });
        tinymce.init({
            selector: "#historyTextarea",
            height: 400
        });
    </script>

    <div class="container">
        <h1>Edit location</h1>
        <form method="POST" enctype="multipart/form-data">
            <?php if (isset($_SESSION['errorMessage'])): ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?= htmlspecialchars($_SESSION['errorMessage']); unset($_SESSION['errorMessage']) ?>
                </div>
            <?php endif; ?>
            <input type="hidden" name="id" value="<?= $editedHistoryLocation->getId() ?>">
            <div class="mb-3">
                <label for="name">Location Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $editedHistoryLocation->getName() ?>" required>
            </div>
            <div class="mb-3">
                <label for="file">Location image</label><br>
                <img src="<?php $array = explode('/', $editedHistoryLocation->getImagePath());
                echo '/images/historyLocations/' . end($array) ?>" alt="<?= $editedHistoryLocation->getName() ?>" class="img-thumbnail">
            </div>
            <div class="mb-3">
                <input type="file" class="form-control" id="file" name="file">
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="mb-3">
                        <label for="aboutTextarea">About</label>
                        <textarea class="form-control" id="aboutTextarea" name="aboutTextarea" rows="3"><?= $editedHistoryLocation->getAbout() ?></textarea>
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label for="aboutImage">About Image</label>
                        <img src="<?= $editedHistoryLocation->getAboutImage() ?>" class="img-thumbnail">
                        <input type="file" class="form-control" id="aboutImage" name="aboutImage" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="mb-3">
                        <label for="historyTextarea">History</label>
                        <textarea class="form-control" id="historyTextarea" name="historyTextarea" rows="3"><?= $editedHistoryLocation->getHistory() ?></textarea>
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label for="historyImage">History Image</label>
                        <img src="<?= $editedHistoryLocation->getHistoryImage() ?>" class="img-thumbnail">
                        <input type="file" class="form-control" id="historyImage" name="historyImage" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Edit</button>
            <a class="btn btn-primary" href="../dashboard/historyLocations" style="margin-top: 20px; margin-left: 40px;">Back to locations</a>
        </form>
    </div>

<?php include __DIR__ . '/../footer.php'; ?>