<?php

include __DIR__ . '/../header.php';
include __DIR__ . '/../navigationbar.php';

?>

    <script type="text/javascript">
        tinymce.init({
            selector: "#aboutTextarea",
            plugins: "image",
            toolbar: "undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | image",
            height: 300
        });
        tinymce.init({
            selector: "#historyTextarea",
            plugins: "image",
            toolbar: "undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | image",
            height: 300
        });
    </script>

    <div class="container">
        <h1>Create history location</h1>
        <form method="POST" enctype="multipart/form-data">
            <?php if (isset($_SESSION['errorMessage'])): ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?= htmlspecialchars($_SESSION['errorMessage']); unset($_SESSION['errorMessage']) ?>
                </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="name">Location Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="file">Location Image</label>
                <input type="file" class="form-control" id="file" name="file" required>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="mb-3">
                        <label for="aboutTextarea">About</label>
                        <textarea class="form-control" id="aboutTextarea" name="aboutTextarea" rows="3"></textarea>
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label for="aboutImage">About Image</label>
                        <input type="file" class="form-control" id="aboutImage" name="aboutImage" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="mb-3">
                        <label for="historyTextarea">History</label>
                        <textarea class="form-control" id="historyTextarea" name="historyTextarea" rows="3"></textarea>
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label for="historyImage">History Image</label>
                        <input type="file" class="form-control" id="historyImage" name="historyImage" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Create</button>
            <a class="btn btn-primary" href="../dashboard/historyLocations" style="margin-top: 20px; margin-left: 40px;">Back to history locations</a>
        </form>
    </div>

<?php include __DIR__ . '/../footer.php'; ?>