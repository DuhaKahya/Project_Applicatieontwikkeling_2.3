<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../navigationbar.php';
?>

<script>
    var tours = JSON.parse('<?php echo $encodedHistoryTours ?>');

    function getTourData(id) {
        let tour = tours.find(tour => tour['historyTourId'] === id);
        let tourId = tour['historyTourId'];
        let language = tour['name'];
        let dateTime = tour['tourStartTime'].split(' ');
        let date = dateTime[0].split('-');
        date = date[1] + '-' + date[2] + '-' + date[0];
        let time = dateTime[1].split(':').slice(0, 2).join(':');
        let tourGuide = tour['tourGuide'];
        let maxParticipants = tour['maxParticipants'] - tour['totalParticipants'];
        let price = tour['price'];
        document.getElementById('tourForm').innerHTML = `
            <input type="hidden" name="tourId" value="${tourId}">
            <p><b>Language: </b>${language}</p>
            <p><b>Date: </b>${date}</p>
            <p><b>Time: </b>${time}</p>
            <p><b>Tour Guide: </b>${tourGuide}</p>
            <h4>Amount of people (<b>${maxParticipants}</b> spots left)</h4>
            <input type="number" class="form-control" id="amountOfPeople" name="amountOfPeople" oninput="calculatePrice(${price})" value="1" min="1" max="${maxParticipants}" required>
            <div>Note: For every fourth person you get a family discount of €10</div>
            <br><p id="totalPrice"><b>Price total: €</b>${price.toFixed(2)}</p>
            <button type="submit" class="btn btn-primary mx-4 mt-2">Add to personal program</button>
        `;
    }

    function calculatePrice(price) {
        let amountOfPeople = document.getElementById('amountOfPeople').value;
        let discount = Math.floor(amountOfPeople / 4) * 10;
        let total = amountOfPeople * price - discount;
        document.getElementById('totalPrice').innerHTML = `<b>Price total: €</b>${total.toFixed(2)}`;
    }
</script>

<div class="container" style="width: auto">
    <h1>Get your history tour tickets</h1>
    <div class="row">
        <div class="container-fluid col-3">
            <form method="post">
                <h4>Selected tour</h4>
                <div id="tourForm">
                    <p>No tour selected</p>
                </div>
            </form>
        </div>
        <div class="col-9">
            <div class="row">
                <?php foreach ($displayableHistoryTours as $language) : ?>
                    <div class="col text-center p-4 mx-4 rounded" style="border: solid 2px">
                        <img src="<?='/images/historyLocations/Flag'. reset($language)[0]->getLanguage() . '.png'?>" alt="<?= reset($language)[0]->getLanguage() ?> flag" style="height: 50px">
                        <h4><?= reset($language)[0]->getLanguage() ?></h4>
                        <div class="row">
                            <?php foreach ($language as $Date) : ?>
                                <div class="col-4 text-center">
                                    <p><b><?= $Date[0]->getStartDate() ?></b></p>
                                    <?php foreach ($Date as $tour) : ?>
                                        <p><button onclick="getTourData(<?= $tour->getId() ?>)" class="btn btn-xs btn-primary"><?= $tour->getStartDateTime()->format('H:i') ?></button></p>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>


<?php
include_once __DIR__ . '/../footer.php';
?>