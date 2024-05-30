<?php

include __DIR__ . '/../header.php';
include __DIR__ . '/../navigationbar.php';
?>

<div class="container">
    <h1>Edit user</h1>
    <form method="post" action="">
        <?php if (isset($_SESSION['errorMessage'])): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= htmlspecialchars($_SESSION['errorMessage']); unset($_SESSION['errorMessage']) ?>
            </div>
        <?php endif; ?>
        <input type="hidden" name="id" value="<?php echo $editedUser->getUserId(); ?>">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required value="<?php echo $editedUser->getUsername(); ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required value="<?php echo $editedUser->getEmail(); ?>">
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role" required name="role">
                <?php
                foreach ($roles as $role) {
                    echo "<option value={$role['roleId']} ". ($editedUser->getName() === $role['name'] ? 'selected="selected"' : '') .">{$role['name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="firstname" class="form-label">Firstname</label>
            <input type="text" class="form-control" id="firstname" name="firstname" required value="<?php echo $editedUser->getFirstName(); ?>">
        </div>
        <div class="mb-3">
            <label for="lastname" class="form-label">Lastname</label>
            <input type="text" class="form-control" id="lastname" name="lastname" required value="<?php echo $editedUser->getLastName(); ?>">
        </div>
        <div class="mb-3">
            <label for="phoneNumber">Phone Number</label>
            <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" required value="<?php $editedUser->getPhoneNumber() ?>">
        </div>
        <div class="mb-3">
            <label for="postalCode">Postal Code</label>
            <input type="text" class="form-control" id="postalCode" name="postalCode" required value="<?php $editedUser->getPostalCode() ?>">
        </div>
        <div class="mb-3">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" required value="<?php $editedUser->getAddress() ?>">
        </div>
        <div class="mb-3">
            <label for="houseNumber">House Number</label>
            <input type="text" class="form-control" id="houseNumber" name="houseNumber" required value="<?php $editedUser->getHouseNumber() ?>">
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Edit</button>
        <a class="btn btn-primary" href="../dashboard/users" style="margin-top: 20px; margin-left: 40px;">Back to users</a>
    </form>
</div>

<?php include __DIR__ . '/../footer.php'; ?>