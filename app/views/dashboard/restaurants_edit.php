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

            <h1>Edit Restaurant</h1>
            <form method="POST" enctype="multipart/form-data">
                <?php if (isset($_SESSION['errorMessage'])): ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <?= htmlspecialchars($_SESSION['errorMessage']); unset($_SESSION['errorMessage']) ?>
                    </div>
                <?php endif; ?>
                <input type="hidden" name="id" value="<?= $editedRestaurant->getRestaurantId() ?>">

                <div class="mb-3">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $editedRestaurant->getName() ?>" required>
                </div>

                <div class="mb-3">
                    <label for="speciality" class="form-label">Speciality</label>
                    <select class="form-select" id="speciality" name="speciality" style="height: 30px; font-size: 15px;" required>
                        <?php foreach ($specialities as $speciality) { 
                            if ($speciality->getSpecialityId() == $editedRestaurant->getSpecialityId()) {
                                echo "<option value={$speciality->getSpecialityId()} selected>{$speciality->getName()}</option>";
                            } else {
                                echo "<option value={$speciality->getSpecialityId()}>{$speciality->getName()}</option>";
                            }
                        } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="description">Speciality Description</label>
                    <input type="text" class="form-control" id="description" name="description" value="<?= $editedRestaurant->getDescription() ?>" required>
                </div>

                <div class="mb-3">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" id="location" name="location" value="<?= $editedRestaurant->getLocation() ?>" required>
                </div>

                <div class="mb-3">
                    <label for="image" >Overview Image</label>
                    <br>
                    <span style="font-style: italic;">Current Image:</span>
                    <br>
                    <img src="/images/yummy/<?= $editedRestaurant->getImage() ?>" alt="Image" style="width: 300px; height: 150px;">
                    <br>
                    <input type="file" class="form-control mt-3" id="image" name="image" value="<?= $editedRestaurant->getImage() ?>">
                </div>

                <?php foreach ($restaurantDetailPages as $restaurantDetailPage) {
                    if ($restaurantDetailPage->getRestaurantId() == $editedRestaurant->getRestaurantId()) {
                        ?>

                        <div class="mb-3">
                            <label for="image1">Image 1</label>
                            <br>
                            <span style="font-style: italic;">Current Image:</span>
                            <br>
                            <img src="/images/yummy/<?= $restaurantDetailPage->getImageDetail1() ?? 'No image' ?>" alt="Image" style="width: 300px; height: 150px;">
                            <br>
                            <input type="file" class="form-control mt-3" id="image1" name="image1" value="<?= $restaurantDetailPage->getImageDetail1() ?>">
                        </div>

                        <div class="mb-3">
                            <label for="image2">Image 2</label>
                            <br>
                            <span style="font-style: italic;">Current Image:</span>
                            <br>
                            <img src="/images/yummy/<?= $restaurantDetailPage->getImageDetail2()  ?? 'No image'  ?>" alt="Image" style="width: 300px; height: 150px;">
                            <br>
                            <input type="file" class="form-control mt-3" id="image2" name="image2" value="<?= $restaurantDetailPage->getImageDetail2() ?>">
                        </div>

                        <div class="mb-3">
                            <label for="image3">Image 3</label>
                            <br>
                            <span style="font-style: italic;">Current Image:</span>
                            <br>
                            <img src="/images/yummy/<?= $restaurantDetailPage->getImageDetail3()  ?? 'No image'  ?>" alt="Image" style="width: 300px; height: 150px;">
                            <br>
                            <input type="file" class="form-control mt-3" id="image3" name="image3" value="<?= $restaurantDetailPage->getImageDetail3() ?>">
                        </div>

                        <div class="mb-3">
                            <label for="image4">Image 4</label>
                            <br>
                            <span style="font-style: italic;">Current Image:</span>
                            <br>
                            <img src="/images/yummy/<?= $restaurantDetailPage->getImageDetail4()  ?? 'No image'  ?>" alt="Image" style="width: 300px; height: 150px;">
                            <br>
                            <input type="file" class="form-control mt-3" id="image4" name="image4" value="<?= $restaurantDetailPage->getImageDetail4() ?>">
                        </div>

                    <?php
                    }
                } ?>

                <div class="mb-3">
                    <label for="price">Price</label>
                    <input type="number" class="form-control" id="price" name="price" value="<?= $editedRestaurant->getPrice() ?>" required>
                </div>

                <div class="mb-3">
                    <label for="places">Places</label>
                    <input type="number" class="form-control" id="places" name="places" value="<?= $editedRestaurant->getPlaces() ?>" required>
                </div>

                <div class="mb-3">
                    <label for="rating">Rating</label>
                    <input type="number" class="form-control" id="rating" name="rating" value="<?= $editedRestaurant->getRating() ?>" required min="1" max="5" pattern="[1-5]">
                </div>

                <div class="mb-3">
                    <label for="number">Phone number</label>
                    <input type="text" class="form-control" id="number" name="number" value="<?= $editedRestaurant->getNumber() ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" value="<?= $editedRestaurant->getEmail() ?>" required>
                </div>

                <div class="mb-3">
                    <label for="titleDescription" class="form-label">Title Description</label>
                    <textarea class="form-control" id="titleDescription" name="titleDescription" rows="6" required><?= $restaurantDetailPage->getTitleDescription() ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="pageDescription" class="form-label">Page Description</label>
                    <textarea class="form-control" id="pageDescription" name="pageDescription" rows="6" required><?= $restaurantDetailPage->getDescription() ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="reservationText" class="form-label">Reservation Text</label>
                    <textarea class="form-control" id="reservationText" name="reservationText" rows="6" required><?= $restaurantDetailPage->getReservationText() ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="margin-left: 5px;">Save</button>

                <a href="../dashboard/restaurants" style="margin-left: 10px;">Back to restaurants</a>
            </form>
        </div>
        <!-- Einde container -->
    </div>
    <!-- Einde rij -->
</div>

<?php include __DIR__ . '/../footer.php'; ?>
