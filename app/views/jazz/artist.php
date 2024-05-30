<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../navigationbar.php';
?>

<div class="container mt-5">

    <div class="row">
        <div class="col-12">
            <img src="<?php echo $artist->getImageProfile(); ?>"
                 alt="Artist's profile, full-width"
                 class="img-fluid w-100">
        </div>
    </div>

    <button type="button" class="btn btn-primary mt-5" onclick="history.back();">Go Back</button>

    <div class="row">
        <div class="col-12">
            <h1 class="display-1">Who is <?php echo htmlspecialchars_decode($artist->getName()); ?>?</h1>
            <p class="lead"><?php echo htmlspecialchars_decode($artist->getWhoIs()); ?></p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-7">
            <h1 class="display-1">Career Highlights</h1>
            <p class="lead"><?php echo htmlspecialchars_decode($artist->getCareerSummary()); ?></p>
        </div>

        <div class="col-lg-4 col-md-5 d-flex justify-content-center align-items-center">
            <img src="<?php echo htmlspecialchars($artist->getImageCareerHighlights()); ?>"
                 alt="Artist's career highlights portrait"
                 class="img-fluid rounded">
        </div>
    </div>

    <div class="row">
        <!-- Image on the left -->
        <div class="col">
            <div class="mt-5">
                <img src="<?php echo htmlspecialchars($artist->getImageImportantTracks()); ?>"
                     alt="Artist's notable tracks portrait"
                     class="img-fluid rounded">
            </div>
        </div>


        <div class="col">
            <h1 class="display-1">Important Tracks</h1>
            <p class="lead"><?php echo htmlspecialchars_decode($artist->getImportantTracks()); ?></p>
        </div>
    </div>

    <div class="container mt-5">
        <h1 class="mb-5">Songs:</h1>
        <?php if (empty($songs)): ?>
            <p class="text-center">No tracks available for this artist.</p>
        <?php else: ?>
            <div class="row justify-content-center">
                <?php foreach ($songs as $song): ?>
                    <div class="col-md-4 mb-3 d-flex flex-column align-items-center">
                        <h5 class="text-center mb-3"><?php echo htmlspecialchars_decode($song->getName()); ?></h5>
                        <img class="img-fluid mb-3" src="<?php echo htmlspecialchars($song->getImageCover()); ?>"
                             alt="Musical vibes, album cover aesthetic" style="object-fit: cover; border-radius: 8px;">
                        <audio controls class="w-100">
                            <source src="<?php echo htmlspecialchars($song->getMusicPath()); ?>" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>


    <div class="row">
        <div class="container mt-5">
            <h1 class="display-4">Schedule for <?php echo htmlspecialchars_decode($artist->getName()); ?>:</h1>
            <?php if (!empty($schedule)): ?>
                <div class="row">
                    <?php foreach ($schedule as $event): ?>
                        <div class="col-md-6 mb-3">
                            <div class="card text-center">
                                <div class="card-header">
                                    <?php echo date('l', strtotime($event['concertStartTime'])); ?>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $event['name']; ?></h5>
                                    <p class="card-text"><?php echo date('H:i', strtotime($event['concertStartTime'])) . ' - ' . date('H:i', strtotime($event['concertEndTime'])); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No events are currently scheduled for this artist.</p>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php
include_once __DIR__ . '/../footer.php';
?>
