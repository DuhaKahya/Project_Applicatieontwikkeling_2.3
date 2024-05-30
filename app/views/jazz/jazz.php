<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../navigationbar.php';
?>

<div class="container">
    <?php if ($flashHelper->hasFlashMessages()): ?>
        <div class="row mt-3">
            <?php $flashHelper->displayFlashMessages(); ?>
        </div>
    <?php endif; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col">

                <div class="text-white position-absolute">
                    <h1 class="display-3 bg-dark px-3">Haarlem Jazz</h1>
                    <button class="btn btn-primary">28, 29, 30 & 31 July</button>
                </div>
                <img src="images/HaarlemJazzBanner.png" alt="Haarlem Jazz Festival" class="img-fluid w-100"
                     style="height: auto;">
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row">
            <h2>Welcome to Haarlem Jazz!</h2>
            <p>
                Step into the world of jazz in Haarlem – where the music comes alive! Get ready for the soulful
                tunes, cool beats, and amazing performances that make Haarlem a jazz lover's dream. Join us as
                we explore the local jazz scene, events, and talented musicians that make Haarlem swing. Let's
                dive into the music together and enjoy the rhythm of Haarlem Jazz!
            </p>
        </div>
    </div>

    <!-- artists -->
    <div class="row">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center my-3">This years Haarlem Jazz Amazing artists:</h2>
                </div>
            </div>

            <?php
            $artistsByCategory = [];
            foreach ($artists as $artist) {
                foreach ($artist->musicStyleNames as $styleName) {
                    $artistsByCategory[$styleName][$artist->artistId] = $artist;
                }
            }

            foreach ($artistsByCategory as $categoryName => $artistsInCategory) {
                echo '<div class="row mt-5">';
                echo '<div class="col">';
                echo '<h3 class="text-center">' . htmlspecialchars($categoryName) . ':</h3>';
                echo '</div>';

                foreach ($artistsInCategory as $artistId => $artist) {
                    echo '<div class="col text-center">';
                    echo '<img src="' . htmlspecialchars($artist->imageIcon) . '" alt="' . htmlspecialchars_decode(htmlspecialchars($artist->name)) . '" class="rounded-circle">';
                    echo '<p>' . htmlspecialchars_decode(htmlspecialchars($artist->name)) . '</p>';
                    echo '<form action="/artist" method="get">';
                    echo '<input type="hidden" name="artist" value="' . htmlspecialchars($artist->slug) . '" tabindex="-1">';
                    echo '<button type="submit" class="btn btn-primary">View Artist</button>';
                    echo '</form>';
                    echo '</div>';
                }
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <div class="row mt-5">
        <h2 class="text-center my-3">Event Schedule:</h2>
        <div class="row">
            <div class="col">
                <p>Regulair prices can be found in the table below. <br>
                    All-access pass (one day) €35,00 <br>
                    All-access pass (three days) €80,00.
                </p>
            </div>

            <div class="col">
                <div class="row">
                    <div class="col"></div>
                    <div class="col">
                        <?php
                        $buttonLink = "/reservation?type=artistEvent";
                        if (!isset($_SESSION['user_id'])) {
                            $buttonLink = "/login";
                        }
                        ?>

                        <a href="<?= $buttonLink ?>" class="btn btn-primary btn-block">
                            Buy tickets
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <?php
            $currentDate = null;
            foreach ($events as $event):
                $eventDate = (new DateTime($event['concertStartTime']))->format('d M');
                if ($eventDate !== $currentDate):
                    if ($currentDate !== null) {
                        echo '</div>';
                    }
                    echo '<div class="col text-center">';
                    echo '<h3>' . $eventDate . '</h3>';
                    $currentDate = $eventDate;
                endif;
                ?>
                <div class="event-container">
                    <p><?= (new DateTime($event['concertStartTime']))->format('H:i') ?>
                        - <?= $event['artistName'] ?><br><?= $event['name'] ?></p>
                </div>
            <?php endforeach; ?>
            <?php if ($currentDate !== null): ?>
        </div>
        <?php endif; ?>
    </div>
</div>


<!-- map -->
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-md-6">
            <h4>Patronaat:</h4>
            <iframe src="https://www.google.com/maps/d/embed?mid=1K98xpChg7jIRM3WhKBYvTTjxRnd5SZk&ehbc=2E312F&noprof=1"
                    title="Patronaat map"
                    width="100%" height="480" style="border:0;"></iframe>
        </div>
        <div class="col-md-6">
            <h4>Grote Markt:</h4>
            <iframe src="https://www.google.com/maps/d/embed?mid=1OXquBrBL1grn1Sc5Qfw4jAjjzXZ-8j4&ehbc=2E312F&noprof=1"
                    title="Grote Markt map"
                    width="100%" height="480" style="border:0;"></iframe>
        </div>
    </div>
</div>
</div>
</div>

<?php
include_once __DIR__ . '/../footer.php';
?>
