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

    <div class="position-relative text-center">
        <img src="images/HomePageBanner.png" alt="Festival" class="img-fluid">
        <div class="position-absolute top-50 start-50 translate-middle" style="z-index: 2;">
            <div>
                <h1 class="display-1 fw-bold text-uppercase text-white">Haarlem Festival</h1>
            </div>
            <p class="lead fw-normal text-white">28, 29, 30 & 31 July</p>
        </div>
    </div>


    <div class="row mt-3">
        <div class="col-md-12 text-center my-5">
            <h1>Welcome to The Haarlem Festival</h1>
            <p class="lead">Discover what the city of Haarlem has to offer at the Haarlem Festival. From jazz to
                dance, there is something for everyone.</p>

            <p class="display-6 my-3">⬇️</p>
        </div>
    </div>

    <div class="row align-items-center mt-3">
        <div class="col-lg-6">
            <img src="images/HaarlemJazzOverview.png" alt="Haarlem Jazz Festival" class="img-fluid ha-jazz-image">
        </div>
        <div class="col-lg-6 ha-jazz-content">
            <h2>Haarlem Jazz</h2>
            <p>Welcome to Haarlem Jazz – where the city resonates with the soulful notes of jazz. Explore the
                artists, events, and the dynamic vibe of this enchanting Dutch festival right here on our Haarlem
                Jazz page. Get ready for a musical journey that defines the spirit of jazz in the heart of
                Haarlem!</p>
            <a href="/jazz" class="btn btn-primary">View Details...</a>
        </div>
    </div>


    <div class="row align-items-center mt-5">
        <div class="col-md-6">
            <h2>Haarlem Dance</h2>
            <p>Immerse yourself in the pulsating heart of the festival with our electrifying addition: Haarlem
                Dance! From July 29 to July 31, the Dance segment takes center stage, showcasing the latest in
                dance, house, techno, and trance genres.</p>
            <p>This dynamic experience features six of the world's top DJs in Back2Back sessions on a
                larger-than-life stage, promising longer sessions and multiple acts that will keep you dancing until
                the early hours. Dive into smaller experimental (club) sessions for an intimate connection with the
                beats.</p>

            <!-- not active since we dont have a 4 member -->
            <a href="#details" class="btn btn-primary disabled">View Details...</a>
        </div>
        <div class="col-md-6">
            <img src="images/HaarlemDanceOverview.png" alt="Haarlem Dance" class="img-fluid">
        </div>
    </div>

    <div class="row align-items-center mt-5">
        <div class="col-lg-8">
            <img src="images/HaarlemYummyOverview.png" alt="Tasty Food" class="img-fluid rounded">
        </div>
        <div class="col-lg-4">
            <h2>Yummy!</h2>
            <p>Get excited for the festival! Check out all the tasty restaurants and stay tuned for a closer look at
                two of them, including pics, chef info, and a sneak peek at their delicious dishes. It's foodie
                heaven coming your way!</p>
            <a href="/yummy" class="btn btn-primary">View Details...</a>
        </div>
    </div>

    <div class="row align-items-center mt-5">
        <div class="col-lg-6">
            <h2>A Stroll Through History</h2>
            <p>Participate in an amazing historical tour through the beautiful city of Haarlem. From July 28th to
                July 31st you can participate in such a tour. In a duration of 2.5 hours you will be able to visit 9
                venues which will surely impress you!</p>
            <a href="history" class="btn btn-primary">View Details...</a>
        </div>
        <div class="col-lg-6">
            <img src="images/HaarlemHistoryOverview.png" alt="Historical Haarlem" class="img-fluid rounded">
        </div>
    </div>

    <div class="row justify-content-center mb-3 mt-5">
        <div class="col-lg-12 text-center">
            <h2 class="mb-4">Map of activities</h2>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-12 text-center">
            <iframe src="https://www.google.com/maps/d/embed?mid=1LKiYRDjEZYOcCcN1R94Eoununc8_IKI&ehbc=2E312F&noprof=1"
                    width="640" height="480" style="border:0;" allowfullscreen="" loading="lazy"
                    title="Google Maps"></iframe>
        </div>
    </div>

</div>

<?php
include_once __DIR__ . '/../footer.php';
?>

