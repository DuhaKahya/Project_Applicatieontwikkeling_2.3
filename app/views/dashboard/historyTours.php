<?php

include __DIR__ . '/../header.php';
include __DIR__ . '/../navigationbar.php';

?>

<div style="display: flex;">

    <!-- Sidebar -->
    <div class="flex-shrink-0 p-3" style="width: 280px;">
        <?php include __DIR__ . '/sidebar.php'; ?>
    </div>

    <!-- Main content -->
    <div style="flex-grow: 1; display: flex; justify-content: center;">
        <div class="container">
            <h1>History Tours</h1>
            <table id="sortableTable" class="display">
                <thead>
                <tr>
                    <th>Language</th>
                    <th>Start Date/Time</th>
                    <th>Max participants</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($historyTours as $historyTour) : ?>
                    <tr>
                        <td><?php echo $historyTour->getLanguage(); ?></td>
                        <td><?php echo $historyTour->getStartDateTime()->format('d-m-Y H:i:s'); ?></td>
                        <td><?php echo $historyTour->getMaxParticipants(); ?></td>
                        <td><?php echo "€".number_format($historyTour->getPrice(),'2'); ?></td>
                        <td>
                            <a href="historyTours_edit?id=<?php echo $historyTour->getId(); ?>" class="btn-primary btn-sm">Edit</a> |
                            <a href="historyTours_delete?id=<?php echo $historyTour->getId(); ?>" class="btn-danger btn-sm ml-3">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <a href="historyTours_create" class="btn btn-primary" style="margin-top: 20px; margin-left: 15px;">Create new tour</a>
            <a href="/dashboard" class="btn btn-primary" style="margin-top: 20px; margin-left: 40px;">Back to dashboard</a>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#sortableTable').DataTable();
    });
</script>

<?php include __DIR__ . '/../footer.php'; ?>