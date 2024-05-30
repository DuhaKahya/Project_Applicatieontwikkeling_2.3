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
        <!-- Einde sidebar -->

        <!-- Container -->
        <div class="col-lg-8">
            <h1>Create restaurant</h1>
            <form method="POST" enctype="multipart/form-data">
                <?php if (isset($_SESSION['errorMessage'])): ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <?= htmlspecialchars($_SESSION['errorMessage']); unset($_SESSION['errorMessage']) ?>
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="mb-3">
                    <label for="speciality" class="form-label">Speciality</label>
                    <select class="form-select" id="speciality" name="speciality" style="height: 30px; font-size: 15px;" required>
                        <?php foreach ($specialities as $speciality) { ?>
                            <option value="<?= $speciality->getSpecialityId() ?>"><?= $speciality->getName() ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="description">Speciality Description</label>
                    <input type="text" class="form-control" id="description" name="description" required>
                </div>

                <div class="mb-3">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" id="location" name="location" required>
                </div>

                <div class="mb-3">
                    <label for="image">Overview Image</label>
                    <input type="file" class="form-control" id="image" name="image" required>
                </div>

                <div class="mb-3">
                    <label for="image1">Image 1</label>
                    <input type="file" class="form-control" id="image1" name="image1">
                </div>

                <div class="mb-3">
                    <label for="image2">Image 2</label>
                    <input type="file" class="form-control" id="image2" name="image2">
                </div>

                <div class="mb-3">
                    <label for="image3">Image 3</label>
                    <input type="file" class="form-control" id="image3" name="image3">
                </div>

                <div class="mb-3">
                    <label for="image4">Image 4</label>
                    <input type="file" class="form-control" id="image4" name="image4" >
                </div>

                <div class="mb-3">
                    <label for="price">Price</label>
                    <input type="number" class="form-control" id="price" name="price" required>
                </div>

                <div class="mb-3">
                    <label for="places">Places</label>
                    <input type="number" class="form-control" id="places" name="places" required>
                </div>

                <div class="mb-3">
                    <label for="rating">Rating</label>
                    <input type="number" class="form-control" id="rating" name="rating" required min="1" max="5" pattern="[1-5]">
                </div>

                <div class="mb-3">
                    <label for="text">Phone number</label>
                    <input type="text" class="form-control" id="number" name="number" required>
                </div>

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="titleDescription" class="form-label">Title Description</label>
                    <textarea class="form-control" id="titleDescription" name="titleDescription" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="pageDescription" class="form-label">Page Description</label>
                    <textarea class="form-control" id="pageDescription" name="pageDescription" rows="6" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="reservationText" class="form-label">Reservation Text</label>
                    <textarea class="form-control" id="reservationText" name="reservationText" rows="4" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="margin-left: 5px;">Save</button>

                <a href="../dashboard/restaurants" style="margin-left: 10px;">Back to restaurants</a>

            </form>
        </div>
        <!-- Einde container -->
    </div>
    <!-- Einde rij -->
</div>

<?php
include __DIR__ . '/../footer.php';
?>
