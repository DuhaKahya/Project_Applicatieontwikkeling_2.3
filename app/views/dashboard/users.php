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
            <h1>Users</h1>
            <table id="sortableTable" class="display">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Registration Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?php echo $user->getUsername(); ?></td>
                            <td><?php echo $user->getEmail(); ?></td>
                            <td><?php echo $user->getName(); ?></td>
                            <td><?php echo $user->getFirstName(); ?></td>
                            <td><?php echo $user->getLastName(); ?></td>
                            <td><?php echo $user->getRegistrationDate()->format('d-m-Y H:i:s'); ?></td>
                            <td>
                                <a href="users_edit?id=<?php echo $user->getUserId(); ?>" class="btn-primary btn-sm">Edit</a> |
                                <a href="users_delete?id=<?php echo $user->getUserId(); ?>" class="btn-danger btn-sm ml-3">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="users_create" class="btn btn-primary" style="margin-top: 20px; margin-left: 15px;">Create new user</a>
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