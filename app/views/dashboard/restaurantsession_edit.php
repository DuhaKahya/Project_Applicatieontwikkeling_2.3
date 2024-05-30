<?php

include __DIR__ . '/../header.php';
include __DIR__ . '/../navigationbar.php';

?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3">
            <?php include __DIR__ . '/sidebar.php'; ?>
        </div>
        <!-- End Sidebar -->

        <!-- Container -->
        <div class="col-lg-8">
            <!-- Main content here -->
            <div class="container">
                <h1>Edit Restaurant Sessions</h1>
                <form method="POST" enctype="multipart/form-data">
                    <?php if (isset($_SESSION['errorMessage'])): ?>
                        <div class="alert alert-danger text-center" role="alert">
                            <?= htmlspecialchars($_SESSION['errorMessage']); unset($_SESSION['errorMessage']) ?>
                        </div>
                    <?php endif; ?>

                    <input type="hidden" name="id" value="<?= $editedSession->getRestaurantSessionId() ?>">

                    <div class="mb-3">
                        <label for="starttime">Start Time</label>
                        <input type="text" class="form-control" id="starttime" name="starttime" value="<?= $editedSession->getStartTime() ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="endtime">End Time</label>
                        <input type="text" class="form-control" id="endtime" name="endtime" value="<?= $editedSession->getEndTime() ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary" style="margin-left: 5px;">Save</button>

                    <a href="../dashboard/restaurantsessions" style="margin-left: 10px;">Back to sessions</a>
                </form>
            </div>
        </div>
        <!-- End Container -->
    </div>
    <!-- End Row -->
</div>

<?php include __DIR__ . '/../footer.php'; ?>
