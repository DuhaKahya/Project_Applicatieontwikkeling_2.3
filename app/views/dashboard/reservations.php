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

        <!-- Container -->
        <div class="col-lg-8">
            <!-- Plaats hier de containerinhoud -->
            <a href="reservations_create" class="btn btn-success" style="margin-top: 20px; margin-left: 15px;">Create new reservation</a>
            <a href="/dashboard" class="btn btn-primary" style="margin-top: 20px; margin-left: 40px;">Back to dashboard</a>

            <h1 class="my-4">Reservations</h1>
            <div class="table-responsive">
                <table id="sortableTable" class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Reservation ID</th>
                            <th>Restaurant</th> <!-- Get name of restaurant -->
                            <th>User Name</th>
                            <th>Session</th> <!-- Get start time and end time -->
                            <th>Day</th> <!-- Get day -->
                            <th>Specific Request</th>
                            <th>Adults</th>
                            <th>Children</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservations as $reservation) : ?>
                            <?php foreach($restaurants as $restaurant) : ?>
                                <?php foreach($sessions as $session) : ?>
                                    <?php foreach ($reservationDays as $reservationDay) : ?>
                                        <?php foreach ($users as $user) : ?>
                                            <?php if($reservation->getUserId() == $user->getUserId()) : ?>
                                                <?php if($restaurant->getRestaurantId() == $reservation->getRestaurantId()) : ?>
                                                    <?php if($reservation->getRestaurantSessionId() == $session->getRestaurantSessionId() && $reservation->getReservationDayId() == $reservationDay->getReservationDayId()) : ?>

                                                        <tr>
                                                            <td><?php echo $reservation->getRestaurantEventId(); ?></td>
                                                            <td><?php echo $restaurant->getName(); ?></td>
                                                            <td><?php echo $user->getUserName(); ?></td>
                                                            <td><?php echo $session->getStartTime() . ' - ' . $session->getEndTime(); ?></td>
                                                            <td><?php echo $reservationDay->getDay(); ?></td>
                                                            <td><?php echo $reservation->getSpecificRequest(); ?></td>
                                                            <td><?php echo $reservation->getAdults(); ?></td>
                                                            <td><?php echo $reservation->getChildren(); ?></td>
                                                            <td><?php echo $reservation->getStatus(); ?></td>
                                                            <td>
                                                                <a href="reservations_edit?id=<?= $reservation->getRestaurantEventId() ?>" class="btn-primary btn-sm">Edit</a>
                                                                
                                                                <!-- Delete button mag niet, je kan alleen op non-actief zetten, het werkt wel maar mag niet.-->
                                                                <!-- <a href="reservations_delete?id=<?= $reservation->getRestaurantEventId() ?>" class="btn-danger btn-sm ml-3">Delete</a> -->
                                                            </td>
                                                        </tr>

                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <a href="reservations_create" class="btn btn-success" style="margin-top: 20px; margin-left: 15px;">Create new reservation</a>
            <a href="/dashboard" class="btn btn-primary" style="margin-top: 20px; margin-left: 40px;">Back to dashboard</a>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#sortableTable').DataTable();
    });
</script>

<?php
include __DIR__ . '/../footer.php';
?>
