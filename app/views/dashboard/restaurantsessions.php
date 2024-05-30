<?php
include __DIR__ . '/../header.php';
include __DIR__ . '/../navigationbar.php';
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3">
            <?php include __DIR__ . '/sidebar.php'; ?>
        </div>
        <!-- End Sidebar -->

        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="container">
                <a href="restaurantsessions_create" class="btn btn-success" style="margin-top: 20px; margin-left: 15px;">Create new session</a>
                <a href="/dashboard" class="btn btn-primary" style="margin-top: 20px; margin-left: 40px;">Back to dashboard</a>

                <h1 class="my-4">Restaurant sessions</h1>
                <div class="table-responsive">
                    <table id="sortableTable" class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Id</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sessions as $session) : ?>
                                <tr>
                                    <td><?php echo $session->getRestaurantSessionId(); ?></td>
                                    <td><?php echo $session->getStartTime(); ?></td>
                                    <td><?php echo $session->getEndTime(); ?></td>
                                    <td>
                                        <a href="restaurantsessions_edit?id=<?= $session->getRestaurantSessionId() ?>" class="btn-primary btn-sm">Edit</a>
                                        <a href="restaurantsessions_delete?id=<?= $session->getRestaurantSessionId() ?>" class="btn-danger btn-sm ml-3">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <a href="restaurantsessions_create" class="btn btn-success" style="margin-top: 20px; margin-left: 15px;">Create new session</a>
                <a href="/dashboard" class="btn btn-primary" style="margin-top: 20px; margin-left: 40px;">Back to dashboard</a>
            </div>
        </div>
        <!-- End Main Content -->
    </div>
    <!-- End Row -->
</div>

<script>
    $(document).ready(function() {
        $('#sortableTable').DataTable();
    });
</script>

<?php
include __DIR__ . '/../footer.php';
?>
