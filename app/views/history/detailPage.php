<?php
include __DIR__ . '/../header.php';
include __DIR__ . '/../navigationbar.php';
?>

<div class="container bg-light p-2 mb-4">
    <div class="row container-fluid">
        <div class="col">
            <h2 class="mt-0"><?= $historyLocation->getName() ?></h2>
            <h4 class="m-0">About</h4>
            <p>
                <?= $historyLocation->getAbout() ?>
            </p>
        </div>
        <div class="col-auto">
            <img src="<?= $historyLocation->getAboutImage() ?>" style="max-height: 250px">
        </div>
    </div>
</div>

<?php
if ($historyLocation->getHistory() != null) {
    echo '
    <div class="container bg-light p-2 px-4">
        <div class="row">
            <div class="col-auto">
                <img src="'. $historyLocation->getHistoryImage() .'" style="max-height: 250px">
            </div>
            <div class="col">
                <h4 class="m-0">History</h4>
                <p>
                    '. $historyLocation->getHistory() .'
                </p>
            </div>
        </div>
    </div>
    ';
}
?>

<?php
include __DIR__ . '/../footer.php';
?>
