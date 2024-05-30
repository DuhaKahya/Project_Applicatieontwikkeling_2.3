<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../navigationbar.php';
?>

<div class="container mt-5">
    <h1 class="text-center fw-bold">Account Details</h1>
    <?php
    $flashHelper->displayFlashMessages();
    ?>
    <div class="card">
        <div class="card-header">
            <form method="POST" action="/profile/updateProfile">

                <div class="mb-3">
                    <label class="small mb-1" for="inputUsername">Username (how your name will appear to other
                        users on the site)</label>
                    <input class="form-control" id="inputUsername" type="text" placeholder="Enter your username"
                           value="<?= htmlspecialchars($user->username) ?>" name="username">
                </div>


                <div class="row gx-3 mb-3">
                    <div class="col-md-6">
                        <label class="small mb-1" for="inputFirstName">First name</label>
                        <input class="form-control" id="inputFirstName" type="text"
                               placeholder="Enter your first name"
                               value="<?= htmlspecialchars($user->firstName) ?>" name="firstName">
                    </div>

                    <div class="col-md-6">
                        <label class="small mb-1" for="inputLastName">Last name</label>
                        <input class="form-control" id="inputLastName" type="text"
                               placeholder="Enter your last name" value="<?= htmlspecialchars($user->lastName) ?>"
                               name="lastName">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="small mb-1" for="inputEmailAddress">Email address</label>
                    <input class="form-control" id="inputEmailAddress" type="email"
                           placeholder="Enter your email address" value="<?= htmlspecialchars($user->email) ?>"
                           name="email">
                </div>

                <div class="form-group">
                    <label for="phoneNumber">Phone number</label>
                    <input class="form-control" id="phoneNumber" type="text"
                           placeholder="Enter your phone number" value="<?= htmlspecialchars($user->phoneNumber) ?>"
                           name="phoneNumber">
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="postalCode">Postal code</label>
                        <input class="form-control" id="postalCode" type="text"
                               value="<?= htmlspecialchars($user->postalCode) ?>" name="postalCode">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="address">Address</label>
                        <input class="form-control" id="address" type="text"
                               value="<?= htmlspecialchars($user->address) ?>" name="address">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="houseNumber">House number</label>
                        <input class="form-control" id="houseNumber" type="number"
                               value="<?= htmlspecialchars($user->houseNumber) ?>" name="houseNumber">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="small mb-1" for="currentPassword">Current Password</label>
                    <input class="form-control" id="currentPassword" type="password" name="currentPassword"
                           placeholder="Enter your current password" value="">
                </div>

                <button class="ms-3 mb-3 mt-3 btn btn-primary" type="submit">Save changes</button>
            </form>
        </div>
    </div>
</div>

<div class="container mt-5">
    <h1 class="text-center fw-bold">Change password</h1>
    <div class="card">
        <div class="card-header">
            <form method="POST" action="/profile/changePassword">

                <div class="mb-3">
                    <input class="form-control" id="inputEmailAddress" type="hidden"
                           value="<?= htmlspecialchars($user->email) ?>" name="email" tabindex="-1">
                </div>


                <div class="mb-3">
                    <label class="small mb-1" for="currentPassword">Current Password</label>
                    <input class="form-control" id="currentPassword" type="password" name="currentPassword"
                           placeholder="Enter your current password" value="">
                </div>

                <div class="row gx-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small mb-1" for="newPassword">New Password</label>
                            <input class="form-control" id="newPassword" type="password" name="newPassword"
                                   placeholder="Enter your new password" value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small mb-1" for="newPasswordReenter">Re-enter New Password</label>
                            <input class="form-control" id="newPasswordReenter" type="password"
                                   name="newPasswordReenter"
                                   placeholder="Re-enter your new password" value="">
                        </div>
                    </div>
                </div>
                <button class="ms-3 mb-3 mt-3 btn btn-primary" type="submit">Save changes</button>
                <div>
                    <a href="/passwordforgot">password forgotten</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include_once __DIR__ . '/../footer.php';
?>
