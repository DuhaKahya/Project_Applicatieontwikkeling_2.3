<?php
include __DIR__ . '/../header.php';
include __DIR__ . '/../navigationbar.php';
?>

<!-- Include your sidebar here -->

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3">
            <?php include __DIR__ . '/sidebar.php'; ?>
        </div>
        <!-- Einde sidebar -->

        <!-- Container -->
        <div class="col-lg-8">

            <div class="container">
                <h1>Create Restaurant Sessions</h1>
                <form method="POST" enctype="multipart/form-data">
                    <?php if (isset($_SESSION['errorMessage'])): ?>
                        <div class="alert alert-danger text-center" role="alert">
                            <?= htmlspecialchars($_SESSION['errorMessage']); unset($_SESSION['errorMessage']) ?>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="starttime">Start Time</label>
                        <input type="text" class="form-control" id="starttime" name="starttime" required>
                    </div>

                    <div class="mb-3">
                        <label for="endtime">End Time</label>
                        <input type="text" class="form-control" id="endtime" name="endtime" required>
                    </div>

                    <button type="submit" class="btn btn-primary" style="margin-left: 5px;">Save</button>

                    <a href="../dashboard/restaurantsessions" style="margin-left: 10px;">Back to sessions</a>
                </form>
            </div>
        </div>
        <!-- Einde container -->
    </div>
    <!-- Einde rij -->
</div>

<?php include __DIR__ . '/../footer.php'; ?>
