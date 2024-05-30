<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../navigationbar.php';

?>

<div class="container">

    <h2><strong>Confirm Reservation</strong></h2>

    <div class="row">
        <div class="col-sm-8">
            <p class="mb-0">A reservation fee of €10,- per person will be charged when a reservation is made on the
                Haarlem Festival site. This fee will be deducted from the final check on visiting the restaurant.</p>
        </div>
    </div>

    <!-- Display the reservation details -->

    <div class="row mt-4">
        <div class="col-sm-8">
            <h4>Reservation details:</h4>
            <p><strong>Restaurant:</strong> <?php echo $restaurantName; ?></p>
            <p><strong>Day:</strong> <?php echo $day; ?></p>
            <p><strong>Time:</strong> <?php echo $time; ?></p>
            <p><strong>Adults:</strong> <?php echo $adults; ?></p>
            <p><strong>Children:</strong> <?php echo $children; ?></p>
            <p><strong>Specific requests:</strong> <?php echo $requests; ?></p>
        </div>
    </div>

    <a href="/yummy" class="btn btn-primary mt-4">Back to Yummy</a>


</div>


<?php
include_once __DIR__ . '/../footer.php';
?>


