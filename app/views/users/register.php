<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../navigationbar.php';
?>

    <div class="container">
        <button type="button" class="btn btn-secondary" onclick="history.back();">Go Back</button>

        <?php if ($flashHelper->hasFlashMessages()): ?>
            <div class="row mt-3">
                <?php $flashHelper->displayFlashMessages(); ?>
            </div>
        <?php endif; ?>

        <h1 class="text-center fw-bold">Register</h1>
        <div class="card">
            <div class="card-header">
                <form method="POST" action="/register/registerUser">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Firstname</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" required>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Lastname</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" required>
                    </div>

                    <div class="form-group">
                        <label for="phoneNumber">Phone number</label>
                        <input type="number" class="form-control" id="phoneNumber" name="phoneNumber" required>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="postalCode">Postal code</label>
                            <input type="text" class="form-control" id="postalCode" name="postalCode" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="houseNumber">House number</label>
                            <input type="number" class="form-control" id="houseNumber" name="houseNumber" required>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="password-reenter">Re-enter password</label>
                            <input type="password" class="form-control" id="password-reenter" name="password-reenter"
                                   required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LdtP20pAAAAAGfgB70Qh7h4WMTYk8eVy7sD4K5g"></div>
                    </div>

                    <button type="submit" class="ms-3 mb-3 btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>


<?php
include_once __DIR__ . '/../footer.php';
?>
