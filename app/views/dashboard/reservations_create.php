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
            <h1>Create Reservation</h1>
            <form method="POST" enctype="multipart/form-data">
                <?php if (isset($_SESSION['errorMessage'])): ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <?= htmlspecialchars($_SESSION['errorMessage']); unset($_SESSION['errorMessage']) ?>
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="restaurantId">Restaurant</label>
                    <select class="form-control" id="restaurantId" name="restaurantId" required>
                        <?php foreach ($restaurants as $restaurant): ?>
                            <option value="<?= $restaurant->getRestaurantId() ?>">
                                <?= $restaurant->getName() ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="userName">User Name</label>
                    <select class="form-control" id="userName" name="userName" required>
                        <?php foreach ($users as $user) : ?>
                            <option value="<?= $user->getUserId() ?>" <?php if ($user->getUserName() === $_SESSION['username']) echo 'selected'; ?>>
                                <?= $user->getUserName() ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="sessionId">Session</label>
                    <select class="form-control" id="sessionId" name="sessionId" required>
                        <?php foreach ($sessions as $session): ?>
                            <option value="<?= $session->getRestaurantSessionId() ?>">
                                <?= $session->getStartTime() . ' - ' . $session->getEndTime() ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="reservationDayId">Reservation Day</label>
                    <select class="form-control" id="reservationDayId" name="reservationDayId" required>
                        <?php foreach ($reservationDays as $reservationDay): ?>
                            <option value="<?= $reservationDay->getReservationDayId() ?>">
                                <?= $reservationDay->getDay() ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="specificRequest">Specific Request</label>
                    <input type="text" class="form-control" id="specificRequest" name="specificRequest" required>
                </div>

                <div class="mb-3">
                    <label for="adults">Adults</label>
                    <input type="number" class="form-control" id="adults" name="adults" required>
                </div>

                <div class="mb-3">
                    <label for="children">Children</label>
                    <input type="number" class="form-control" id="children" name="children" required>
                </div>

                <button type="submit" class="btn btn-primary" style="margin-left: 5px;">Save</button>

                <a href="../dashboard/reservations" style="margin-left: 10px;">Back to reservations</a>
            </form>
        </div>
        <!-- Einde container -->
    </div>
    <!-- Einde rij -->
</div>

<?php include __DIR__ . '/../footer.php'; ?>
