<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../navigationbar.php';
?>


<div class="container mt-5">
    <?php
    $flashHelper->displayFlashMessages();
    ?>
    <!-- Day Selector -->
    <div class="mb-4 row">
        <label for="daySelector" class="form-label">Select a Day:</label>
        <select id="daySelector" class="form-select">
            <option value="">All Days</option>
            <?php
            $uniqueDays = [];
            foreach ($entities as $entity) {
                $day = explode(' ', $entity['concertStartTime'])[0];
                if (!in_array($day, $uniqueDays)) {
                    echo "<option value=\"" . htmlspecialchars($day) . "\">" . htmlspecialchars($day) . "</option>";
                    $uniqueDays[] = $day;
                }
            }
            ?>
        </select>
    </div>

    <!-- Location Selector -->
    <div class="mb-4 row">
        <label for="locationSelector" class="form-label">Select a Location:</label>
        <select id="locationSelector" class="form-select">
            <option value="">All Locations</option>
            <?php
            $uniqueLocations = [];
            foreach ($entities as $entity) {
                if (!in_array($entity['locationName'], $uniqueLocations)) {
                    echo "<option value=\"" . htmlspecialchars($entity['locationName']) . "\">" . htmlspecialchars($entity['locationName']) . "</option>";
                    $uniqueLocations[] = $entity['locationName'];
                }
            }
            ?>
        </select>
    </div>

    <div class="row">
        <form method="POST" action="/reservation/redirect">
            <div class="mb-4 ms-3">
                <button type="submit" class="btn btn-primary" id="confirmButton" disabled>Confirm Reservation</button>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4" id="eventCards">
                <?php foreach ($entities as $entity): ?>
                    <div class="col" data-event-day="<?= htmlspecialchars_decode($entity['concertStartTime']) ?>"
                         data-event-time="<?= htmlspecialchars_decode($entity['concertStartTime']) ?>">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Artist: <?= htmlspecialchars_decode($entity['artistName']) ?></h3>
                                <p class="card-text">Price:
                                    €<?= isset($entity['price']) ? htmlspecialchars_decode($entity['price']) : 'Free' ?></p>
                                <p class="card-text">Start
                                    Time: <?= htmlspecialchars_decode($entity['concertStartTime']) ?></p>
                                <p class="card-text">End Time: <?= htmlspecialchars_decode($entity['concertEndTime']) ?></p>
                                <p class="card-text location">
                                    Location: <?= htmlspecialchars_decode($entity['locationName']) ?></p>
                                <div class="mb-5">
                                    Quantity:
                                    <button type="button" class="btn btn-primary btn-sm quantity-btn decrement"
                                            data-id="<?= htmlspecialchars_decode($entity['id']) ?>">-
                                    </button>
                                    <span id="quantity_<?= htmlspecialchars_decode($entity['id']) ?>" class="mx-2">0</span>
                                    <button type="button" class="btn btn-primary btn-sm quantity-btn increment"
                                            data-id="<?= htmlspecialchars_decode($entity['id']) ?>">+
                                    </button>
                                    <input type="hidden" name="entities[<?= htmlspecialchars_decode($entity['id']) ?>]"
                                           value="0" tabindex="-1"/>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </form>
    </div>

    <div id="noEventsNotification" class="alert alert-warning mt-5 row" role="alert" style="display: none;">
        No events match your criteria.
    </div>
</div>

<?php
include_once __DIR__ . '/../footer.php';
?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var daySelector = document.getElementById('daySelector');
        var locationSelector = document.getElementById('locationSelector');
        var cards = document.querySelectorAll('#eventCards .col');
        var noEventsNotification = document.getElementById('noEventsNotification');
        var confirmButton = document.getElementById('confirmButton');

        daySelector.addEventListener('change', filterEvents);
        locationSelector.addEventListener('change', filterEvents);

        // Filter events based on day and location
        function filterEvents() {
            var selectedDay = daySelector.value;
            var selectedLocation = locationSelector.value;
            var anyCardVisible = false;

            cards.forEach(function (card) {
                var cardDay = card.getAttribute('data-event-day').split(' ')[0];
                var cardLocationText = card.querySelector('.card-text.location').textContent;
                var cardLocation = cardLocationText.replace('Location: ', '').trim();

                var dayCondition = selectedDay === '' || cardDay === selectedDay;
                var locationCondition = selectedLocation === '' || cardLocation === selectedLocation;

                if (dayCondition && locationCondition) {
                    card.style.display = '';
                    anyCardVisible = true;
                } else {
                    card.style.display = 'none';
                }
            });

            noEventsNotification.style.display = anyCardVisible ? 'none' : 'block';
        }

        // Handle quantity increment and decrement
        document.querySelectorAll('.quantity-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                var id = this.getAttribute('data-id');
                var quantitySpan = document.getElementById('quantity_' + id);
                var quantityInput = document.querySelector('input[name="entities[' + id + ']"]');
                var currentQuantity = parseInt(quantitySpan.textContent, 10);

                if (this.classList.contains('increment')) {
                    currentQuantity++;
                } else if (this.classList.contains('decrement') && currentQuantity > 0) {
                    currentQuantity--;
                }

                quantitySpan.textContent = currentQuantity;
                quantityInput.value = currentQuantity;

                updateConfirmButtonState();
            });
        });

        // Update confirm button state based on quantities
        function updateConfirmButtonState() {
            var isAnyQuantitySelected = Array.from(document.querySelectorAll('input[name^="entities"]')).some(function (input) {
                return parseInt(input.value, 10) > 0;
            });

            confirmButton.disabled = !isAnyQuantitySelected;
        }

        updateConfirmButtonState();
    });
</script>
