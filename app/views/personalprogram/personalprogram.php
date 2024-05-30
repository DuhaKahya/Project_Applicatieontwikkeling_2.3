<?php
include __DIR__ . '/../header.php';
include __DIR__ . '/../navigationbar.php';
?>

<script>
    function update() {
        let checkboxes = document.getElementsByName('ticketCheckbox');
        let selected = 0;
        let totalPrice = 0;
        let eventIds = [];
        for (let i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                totalPrice += parseFloat(checkboxes[i].value);
                selected++;
                eventIds.push(checkboxes[i].id);
            }
        }
        document.querySelector('.totalPrice').innerText = totalPrice.toFixed(2);
        document.querySelector('.selected').innerText = selected;
        document.querySelector('input[name="eventIds"]').value = eventIds;

        let payButton = document.querySelector('.btn-pay');
        payButton.disabled = selected === 0;
    }

    function updatePrice(inputEventId, price) {
        let input = document.getElementsByClassName(inputEventId + 'QuantityInput');
        let priceElement = document.getElementById(inputEventId + 'Price');
        let totalQuantity = 0;
        for (let i = 0; i < input.length; i++) {
            totalQuantity += parseFloat(input[i].value);
        }
        let calculatedPrice = totalQuantity * price;

        if (priceElement.className === 'historyPrice') {
            calculatedPrice -= Math.floor(totalQuantity / 4) * 10;
        }

        priceElement.innerText = '€' + calculatedPrice.toFixed(2);
        document.getElementById(inputEventId).value = calculatedPrice;
        update();
    }
</script>

<div class="container">
    <h1>Personal Program</h1>
    <form method="POST">
        <input type="hidden" name="eventIds" value="">
        <div class="row">
            <div class="col-9">
                <h4>Your reservations/tickets</h4>
                <p style="font-style: italic;"> Select the reservations/tickets you want to pay for.</p>
                <?php
                if ($artistEvents == null && $historyEvents == null && $restaurantEvents == null) {
                    echo "<p>No reservations or tickets available</p>";
                }
                else {
                    foreach ($artistEvents as $artistEvent) : ?>
                        <div class="bg-light p-2 mb-2 row">
                            <div class="col-1">
                                <?php if ($artistEvent['paymentId'] == null) { ?>
                                    <a href="/personalProgram/removeEventId?removeEventId=<?= $artistEvent['eventId'] ?>&eventType=jazz&subEventId=<?= $artistEvent['artistEventId'] ?>" class="btn btn-xs btn-danger personalProgramRemoveButton"><b>X</b></a>
                                <?php } ?>
                            </div>
                            <div class="col">
                                <div><b>Jazz Festival with: <?= $artistEvent['name'] ?></b></div>
                                <div><?= $artistEvent['concertStartTime'] ?> - <?= $artistEvent['concertEndTime'] ?></div>
                                <div>Location: <?= $artistEvent['location'] ?></div>
                            </div>
                            <div class="col-2">
                                <label>Tickets</label>
                                <?php if ($artistEvent['paymentId'] == null) { ?>
                                    <input name="<?= $artistEvent['eventId'] . 'QuantityInput' ?>" class="form-control ticketsInput <?= $artistEvent['eventId'] . 'QuantityInput' ?>" type="number" value="<?= $artistEvent['ticketsPurchased'] ?>" oninput="updatePrice(<?= $artistEvent['eventId'] ?>, <?= $artistEvent['price'] ?>)" min="1" max="<?= $artistEvent['amount'] - $artistEvent['amountOfPeople'] + $artistEvent['ticketsPurchased'] ?>">
                                <?php } ?>
                            </div>
                            <div class="col-auto">
                                <label>Price</label>
                                <?php if ($artistEvent['paymentId'] == null) { ?><?php } ?>
                                <div id="<?= $artistEvent['eventId'] . 'Price' ?>" class="artistPrice">€<?= number_format($artistEvent['price'] * $artistEvent['ticketsPurchased'] ,2) ?></div>
                            </div>
                            <div class="col-1">
                                <?php if ($artistEvent['paymentId'] == null) { ?>
                                    <input id="<?= $artistEvent['eventId'] ?>" class="personalProgramCheckboxes" type="checkbox" name="ticketCheckbox" oninput="updatePrice(<?= $artistEvent['eventId'] ?>, <?= $artistEvent['price'] ?>)" value="">
                                <?php } ?>
                            </div>
                        </div>
                    <?php endforeach;
                    foreach ($historyEvents as $historyEvent) : ?>
                        <div class="bg-light p-2 mb-2 row">
                            <div class="col-1">
                                <?php if ($historyEvent['paymentId'] == null) { ?>
                                    <a href="/personalProgram/removeEventId?removeEventId=<?= $historyEvent['eventId'] ?>&eventType=history&subEventId=<?= $historyEvent['historyEventId'] ?>" class="btn btn-xs btn-danger personalProgramRemoveButton"><b>X</b></a>
                                <?php } ?>
                            </div>
                            <div class="col">
                                <div><b>Tour Haarlem</b></div>
                                <div><?= $historyEvent['tourStartTime'] ?></div>
                                <div>Language: <?= $historyEvent['name'] ?></div>
                                <div>Tour Guide: <?= $historyEvent['tourGuide'] ?></div>
                            </div>
                            <div class="col-2">
                                <label>Participants</label>
                                <?php if ($historyEvent['paymentId'] == null) { ?>
                                    <input name="<?= $historyEvent['eventId'] . 'QuantityInput' ?>" class="form-control participantsInput <?= $historyEvent['eventId'] . 'QuantityInput' ?>" type="number" value="<?= $historyEvent['participants'] ?>" oninput="updatePrice(<?= $historyEvent['eventId'] ?>, <?= $historyEvent['price'] ?>)" min="1" max="<?= $historyEvent['maxParticipants'] - $historyEvent['maxQuantity'] + $historyEvent['participants']?>">
                                <?php } else {?>
                                    <div><?= $historyEvent['participants'] ?></div>
                                <?php } ?>
                            </div>
                            <div class="col-auto">
                                <label>Price</label>
                                <div id="<?= $historyEvent['eventId'] . 'Price' ?>" class="historyPrice">€<?= number_format($historyEvent['price'] * $historyEvent['participants'] - floor($historyEvent['participants'] / 4) * 10,2)?></div>
                            </div>
                            <div class="col-1">
                                <?php if ($historyEvent['paymentId'] == null) { ?>
                                    <input id="<?= $historyEvent['eventId'] ?>" class="personalProgramCheckboxes" type="checkbox" name="ticketCheckbox" oninput="updatePrice(<?= $historyEvent['eventId'] ?>, <?= $historyEvent['price'] ?>)" value="">
                                <?php } ?>
                            </div>
                        </div>
                    <?php endforeach;
                    foreach ($restaurantEvents as $restaurantEvent) : ?>
                        <div class="bg-light p-2 row">
                            <div class="col-1">
                                <?php if ($restaurantEvent['paymentId'] == null) { ?>
                                    <a href="/personalProgram/removeEventId?removeEventId=<?= $restaurantEvent['eventId'] ?>&eventType=yummy&subEventId=<?= $restaurantEvent['restaurantEventId'] ?>" class="btn btn-xs btn-danger personalProgramRemoveButton"><b>X</b></a>
                                <?php } ?>
                            </div>
                            <div class="col">
                                <div><b>Restaurant: <?= $restaurantEvent['name'] ?></b></div>
                                <div><?= $restaurantEvent['day'] ?> / <?= $restaurantEvent['startTime'] ?> - <?= $restaurantEvent['endTime'] ?></div>

                                <!-- Aan de hand van hoeveel children en adults er zijn moet je per persoon 10 euro rekenen, niet 'price' -->
                                <?php
                                $pricePerPerson = 10;
                                $totalPrice = $restaurantEvent['adults'] * $pricePerPerson + $restaurantEvent['children'] * $pricePerPerson;
                                ?>
                                <div class="ticketPrice">Price p.p: €<?= number_format($pricePerPerson,2) ?></div>
                            </div>
                            <div class="col-2">
                                <label>Adults</label>
                                <?php if ($restaurantEvent['paymentId'] == null) { ?>
                                    <input name="<?= $restaurantEvent['eventId'] . 'AdultsInput' ?>" class="form-control adultsInput <?= $restaurantEvent['eventId'] . 'QuantityInput' ?>" type="number" value="<?= $restaurantEvent['adults'] ?>" oninput="updatePrice(<?= $restaurantEvent['eventId'] ?>, <?= $pricePerPerson ?>)" min="1" max="<?= $restaurantEvent['maxQuantity'] + $restaurantEvent['adults'] + $restaurantEvent['children'] ?>">
                                <?php } else {?>
                                    <div><?= $restaurantEvent['adults'] ?></div>
                                <?php } ?>
                            </div>
                            <div class="col-2">
                                <label>Children</label>
                                <?php if ($restaurantEvent['paymentId'] == null) { ?>
                                    <input name="<?= $restaurantEvent['eventId'] . 'ChildrenInput' ?>" class="form-control childrenInput <?= $restaurantEvent['eventId'] . 'QuantityInput' ?>" type="number" value="<?= $restaurantEvent['children'] ?>" oninput="updatePrice(<?= $restaurantEvent['eventId'] ?>, <?= $pricePerPerson ?>)" min="0" max="<?= $restaurantEvent['maxQuantity'] + $restaurantEvent['adults'] + $restaurantEvent['children']?>">
                                <?php } else { ?>
                                    <div><?= $restaurantEvent['children'] ?></div>
                                <?php } ?>
                            </div>
                            <div class="col-auto">
                                <label>Price</label>
                                <div id="<?= $restaurantEvent['eventId'] . 'Price' ?>" class="restaurantPrice">€<?= number_format($totalPrice,2)?></div>
                            </div>
                            <div class="col-1">
                                <?php if ($restaurantEvent['paymentId'] == null) { ?>
                                    <input id="<?= $restaurantEvent['eventId'] ?>" class="personalProgramCheckboxes" type="checkbox" name="ticketCheckbox" oninput="updatePrice(<?= $restaurantEvent['eventId'] ?>, <?= $pricePerPerson ?>)" value="">
                                <?php } ?>
                            </div>
                        </div>
                    <?php endforeach; } ?>
            </div>
            <div class="col-auto"></div>
            <div class="col-auto" style="border-left: lightgrey 2px solid"></div>
            <div class="col">
                <h4>Payment information</h4>
                <p><b>Selected:</b> <span class="selected">0</span></p>
                <p><b>Total:</b> €<span class="totalPrice">0.00</span></p>
                <hr style="border: 1px solid">
                <button type="submit" class="btn btn-primary btn-pay" disabled>Pay</button>
            </div>
        </div>
    </form>
</div>

<?php
include __DIR__ . '/../footer.php';
?>