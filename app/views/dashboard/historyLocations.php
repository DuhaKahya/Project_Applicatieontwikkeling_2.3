<?php

include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../navigationbar.php';

?>

<div style="display: flex;">

    <!-- Sidebar -->
    <div class="flex-shrink-0 p-3" style="width: 280px;">
        <?php include __DIR__ . '/sidebar.php'; ?>
    </div>

    <!-- Main content -->
    <div style="flex-grow: 1; display: flex; justify-content: center;">
        <div class="container">
            <h1>History Locations</h1>
            <table id="sortableTable" class="display">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($historyLocations as $historyLocation) : ?>
                        <tr>
                            <td><?php echo $historyLocation->getName(); ?></td>
                            <td>
                                <a href="historyLocations_edit?id=<?php echo $historyLocation->getId(); ?>" class="btn-primary btn-sm">Edit</a> |
                                <a href="historyLocations_delete?id=<?php echo $historyLocation->getId(); ?>" class="btn-danger btn-sm ml-3">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="historyLocations_create" class="btn btn-primary" style="margin-top: 20px; margin-left: 15px;">Create new location</a>
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