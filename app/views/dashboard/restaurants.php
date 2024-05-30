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

        <!-- Container -->
        <div class="col-lg-8">
            <!-- Plaats hier de containerinhoud -->
            <div class="container">
                <a href="restaurants_create" class="btn btn-success" style="margin-top: 20px; margin-left: 15px;">Create new restaurant</a>
                <a href="/dashboard" class="btn btn-primary" style="margin-top: 20px; margin-left: 40px;">Back to dashboard</a>

                <h1 class="my-4">Restaurants</h1>
                <div class="table-responsive">
                    <table id="sortableTable" class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($restaurants as $restaurant) : ?>
                                <tr>
                                    <td><?php echo $restaurant->getName(); ?></td>
                                    <td>
                                        <a href="restaurants_edit?id=<?= $restaurant->getRestaurantId() ?>" class="btn-primary btn-sm">Edit</a>
                                        <a href="restaurants_delete?id=<?= $restaurant->getRestaurantId() ?>" class="btn-danger btn-sm ml-3">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <a href="restaurants_create" class="btn btn-success" style="margin-top: 20px; margin-left: 15px;">Create new restaurant</a>
                <a href="/dashboard" class="btn btn-primary" style="margin-top: 20px; margin-left: 40px;">Back to dashboard</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#sortableTable').DataTable();
    });
</script>

<?php
include __DIR__ . '/../footer.php';
?>
