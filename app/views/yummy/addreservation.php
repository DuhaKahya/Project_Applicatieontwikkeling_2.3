<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../navigationbar.php';

// Controleer of de queryparameter 'restaurant' is ingesteld in de URL
if (isset($_GET['restaurant'])) {
    $restaurantName = htmlspecialchars($_GET['restaurant']);
}
?>


<div class="container">
    
    <!-- maak een back button aan naar detailpagina niet naar yummy -->
    <a href="yummy" class="btn btn-primary" style="margin-left: 15px; margin-top: 10px">Back to yummy!</a>

    <h2><strong>Add Reservation for <?php echo $restaurantName; ?></strong></h2>

    <div class="row">
        <div class="col-sm-8">
            <p class="mb-0">A reservation fee of €10,- per person will be charged when a reservation is made on the Haarlem Festival site. This fee will be deducted from the final check on visiting the restaurant.</p>
        </div>
    </div>

    <form method="POST">
        
        <div class="form-group">
            <label>Select day:</label><br>
            <?php foreach ($reservationDays as $day): ?>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="day" id="day<?php echo $day->reservationDayId; ?>" value="<?php echo $day->day; ?>">
                    <label class="form-check-label" for="day<?php echo $day->reservationDayId; ?>"><?php echo $day->day; ?></label>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="form-group">
            <label>Select time:</label><br>
            <?php foreach ($restaurantSessions as $session): ?>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="time" id="time<?php echo $session->reservationTimeStampId; ?>" value="<?php echo $session->startTime . ' - ' . $session->endTime; ?>">
                    <label class="form-check-label" for="time<?php echo $session->restaurantSessionId; ?>"><?php echo $session->startTime . ' - ' . $session->endTime; ?></label>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="form-group" style="width: 25rem;">
            <label for="adults">Adults:</label>
            <input type="number" name="adults" class="form-control" min="1" placeholder="Number of adults" required>
        </div>

        <div class="form-group" style="width: 25rem;">
            <label for="children">Children (0-12 years):</label>
            <input type="number" name="children" class="form-control" min="0" placeholder="Number of children">
        </div>

        <div class="form-group">
            <label for="requests">Any specific requests:</label>
            <textarea name="requests" class="form-control" rows="4" placeholder="Enter any specific requests"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary" style="margin-left: 8px;" onclick="return validateForm();">Reserve</button>
       
    </form>
</div>

<?php
include_once __DIR__ . '/../footer.php';
?>


<script>
    function validateForm() {
        // Controleer of een dag is geselecteerd
        var daySelected = document.querySelector('input[name="day"]:checked');
        if (!daySelected) {
            alert("Select a day");
            return false;
        }

        // Controleer of een tijd is geselecteerd
        var timeSelected = document.querySelector('input[name="time"]:checked');
        if (!timeSelected) {
            alert("Select a time");
            return false;
        }

        // Controleer of het aantal volwassenen is ingevuld
        var adults = document.getElementsByName('adults')[0].value;
        if (adults === '' || adults < 1) {
            alert("Fill in the number of adults");
            return false;
        }

        // Controleer of het aantal kinderen is ingevuld, zo niet, stel het dan in op 0
        var children = document.getElementsByName('children')[0].value;
        if (children === '') {
            document.getElementsByName('children')[0].value = 0;
        }

        // Als alles in orde is, return true
        return true;
    }
</script>
