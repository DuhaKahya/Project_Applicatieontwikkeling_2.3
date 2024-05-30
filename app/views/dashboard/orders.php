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

        <!-- Container -->
        <div class="col-lg-6">
            
            <h1 class="my-4">Orders</h1>

            <div class="table-responsive">
                <table id="sortableTable" class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Order ID</th>
                            <th>Payment ID</th>
                            <th>Date</th>
                            <th>Total Price (euro)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order) { 
                            $totalPrice = $totalPrices[$order->getPaymentId()]['totalPrice'];
                            ?>
                            <tr>
                                <td><?php echo $order->getOrderId(); ?></td>
                                <td><?php echo $order->getPaymentId(); ?></td>
                                <td><?php echo $order->getDate(); ?></td>
                                <td><?php echo $totalPrice; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Form to select columns for export -->
            <form method="POST" class="mb-3 mt-5">
                <div class="form-group">
                    <label>Select columns to export:</label><br>
                    <label class="checkbox-inline"><input type="checkbox" name="columns[]" value="orderId">Order ID</label>
                    <label class="checkbox-inline"><input type="checkbox" name="columns[]" value="paymentId">Payment ID</label>
                    <label class="checkbox-inline"><input type="checkbox" name="columns[]" value="date">Date</label>
                    <label class="checkbox-inline"><input type="checkbox" name="columns[]" value="totalPrice">Total Price</label>
                    <!-- Add more checkboxes for additional columns -->
                </div>
                <button type="submit" class="btn btn-success mx-2">Export (.csv)</button>
            </form>


            <a href="/dashboard" class="btn btn-primary" style="margin-top: 20px; margin-left: 10px;">Back to dashboard</a>
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
