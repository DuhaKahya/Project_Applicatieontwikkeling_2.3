<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../navigationbar.php';
?>

<div class="container mt-5">
    <?php
    $flashHelper->displayFlashMessages();
    ?>
    <h1 class="mb-5">Reservation Confirmation</h1>
    <form method="POST" action="/reservationconfirm/confirm">
        <div class="grid-container"
             style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
            <?php foreach ($selectedEntities as $entity): ?>
                <input type="hidden" name="entityIds[]" value="<?= htmlspecialchars($entity['artistEventId']) ?>"
                       tabindex="-1"/>
                <input type="hidden" name="entities[<?= htmlspecialchars($entity['artistEventId']) ?>]"
                       value="<?= htmlspecialchars($entity['quantity']) ?>" tabindex="-1"/>

                <div class="grid-item" style="border: 1px solid #ccc; padding: 20px; border-radius: 5px;">
                    <h2><?= htmlspecialchars($entity['artistName']) ?></h2>
                    <p>Price:
                        $<?= isset($entity['price']) && $entity['price'] > 0 ? htmlspecialchars($entity['price']) : 'Free' ?></p>
                    <p>Start Time: <?= htmlspecialchars($entity['startTime']) ?></p>
                    <p>End Time: <?= htmlspecialchars($entity['endTime']) ?></p>
                    <p>Location: <?= htmlspecialchars($entity['locationName']) ?></p>
                    <p>Quantity: <?= htmlspecialchars($entity['quantity']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Button Section -->
        <div class="button-section mt-5" style=" display: flex; justify-content: space-around;">
            <button type="button" class="btn btn-secondary" onclick="history.back();">Go Back</button>

            <button type="submit" class="btn btn-primary">Confirm</button>
        </div>
    </form>
</div>

<?php
include_once __DIR__ . '/../footer.php';
?>
