<?php

include __DIR__ . '/../header.php';
include __DIR__ . '/../navigationbar.php';

?>

<div class="container">
    <h1>Create user</h1>
    <form method="POST">
        <?php if (isset($_SESSION['errorMessage'])): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= htmlspecialchars($_SESSION['errorMessage']); unset($_SESSION['errorMessage']) ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="role">Role</label>
            <select class="form-select" id="role" name="role" required>
                <?php
                foreach ($roles as $role) {
                    echo "<option value={$role['roleId']}>{$role['name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="firstname">Firstname</label>
            <input type="text" class="form-control" id="firstname" name="firstname" required>
        </div>
        <div class="mb-3">
            <label for="lastname">Lastname</label>
            <input type="text" class="form-control" id="lastname" name="lastname" required>
        </div>
        <div class="mb-3">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="phoneNumber">Phone Number</label>
            <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" required>
        </div>
        <div class="mb-3">
            <label for="postalCode">Postal Code</label>
            <input type="text" class="form-control" id="postalCode" name="postalCode" required>
        </div>
        <div class="mb-3">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
        <div class="mb-3">
            <label for="houseNumber">House Number</label>
            <input type="text" class="form-control" id="houseNumber" name="houseNumber" required>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Create</button>
        <a class="btn btn-primary" href="../dashboard/users" style="margin-top: 20px; margin-left: 40px;">Back to users</a>
    </form>
</div>

<?php include __DIR__ . '/../footer.php'; ?>