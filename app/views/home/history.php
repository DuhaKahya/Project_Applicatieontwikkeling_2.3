<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../navigationbar.php';
?>

<div class="container bg-light pb-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto mx-0 px-0">
                <img src="images/historyLocations/HistoryChurchOfSintBavo.png" alt="Church Of Sint Bavo" class="img-responsive" style="max-height: 200px">
            </div>
            <div class="col-auto mx-0 px-0">
                <img src="images/historyLocations/HistoryAmsterdamsePoort.png" alt="Amsterdamse Poort" class="img-responsive" style="max-height: 200px">
            </div>
            <div class="col-auto mx-0 px-0">
                <img src="images/historyLocations/HistoryMolenDeAdriaan.png" alt="Molen De Adriaan" class="img-responsive" style="max-height: 200px">
            </div>
            <div class="col-auto mx-0 px-0">
                <img src="images/historyLocations/HistoryProveniershof.png" alt="Proveniershof" class="img-responsive" style="max-height: 200px">
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <h2>Welcome to Haarlem!</h2>
            <h4>A Stroll Through History</h4>
            <p>
                Step into the city of Haarlem, with it’s amazing art, great architecture and beautiful sights!<br>
                We welcome all visitors eager to explore the history and culture of Haarlem.<br>
                Have a look below at some of our locations you can visit.
            </p>
            <p>
                You can also participate in an amazing historical tour.<br>
                These tours are held from <b>July 28th</b> to <b>July 31st</b>.<br>
                More info about tours you can find here:
            </p>
        </div>
    </div>
</div>

<div class="container bg-light mt-4 pb-4">
    <h4>Locations to visit</h4>
    <div class="row">
        <?php foreach ($historyLocations as $historyLocation) : ?>
            <div class="col-auto mb-4">
                <a href="/history/detailPage?id=<?= $historyLocation->getId() ?>">
                    <img src="<?= $historyLocation->getImage() ?>" alt="<?= $historyLocation->getName() ?>" style="max-height: 150px">
                    <div class="bg-dark" style="height: 40px; border-radius: 0 0 20px 20px">
                        <p class="text-white" style="text-align: center; vertical-align: middle; line-height: 40px"><?= $historyLocation->getName() ?></p>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="container bg-light mt-4 pb-4">
    <h4>Tour Information</h4>
    <div class="container">
        <div class="row">
            <div class="col">
                <p>
                    The tour starts near the ‘Church of St. Bavo’, ‘Grote Markt’ in the centre of Haarlem.
                    A giant flag will mark the exact starting location.
                </p>
                <p>
                    Tour duration of the guided tour is approximately 2.5 hours including a 15-minute break with refreshments.
                    Every tour has a group size of 12 participants + 1 guide.
                </p>
                <p>
                    The tours will be held from July 28th to July 31st.
                    More information about the time schedule you will find below.
                </p>
                <p>
                    The prices of the tour (including one drink p.p.):<br>
                    - Regular ticket: € 17,50<br>
                    - Family ticket (max. 4 participants): € 60,-
                </p>
                <p>
                    <b>NOTE:<br>
                    - Strollers are NOT allowed<br>
                    - Participants must be a minimum of 12 years old</b>
                </p>
            </div>
            <div class="col">
                <img src="images/historyLocations/MapRoute.png" alt="Map with tour route" style="height: 325px">
            </div>
        </div>
    </div>
</div>

<div class="container bg-light mt-4 pb-4">
    <h4>Tour Start Schedule</h4>
    <div class="container mb-4">
        <a class="btn btn-primary" href="/history/addtour">Buy tickets</a>
    </div>
    <div class="row">
        <?php foreach ($displayableHistoryTours as $language) : ?>
            <div class="col text-center p-4 mx-4 rounded" style="border: solid 2px">
                <img src="<?='images/historyLocations/Flag'. reset($language)[0]->getLanguage() . '.png'?>" alt="<?= reset($language)[0]->getLanguage() ?> flag" style="height: 50px">
                <h4><?= reset($language)[0]->getLanguage() ?></h4>
                <div class="row">
                    <?php foreach ($language as $Date) : ?>
                        <div class="col-4 text-center">
                            <p><b><?= $Date[0]->getStartDate() ?></b></p>
                            <?php foreach ($Date as $tour) : ?>
                                <p><?= $tour->getStartDateTime()->format('H:i') ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
include_once __DIR__ . '/../footer.php';
?>
