<?php
include_once __DIR__ . '/../header.php';

include_once __DIR__ . '/../navigationbar.php';
?>

    <div class="container mt-5">
        <?php
            $flashHelper->displayFlashMessages();
        ?>
        <h1 class="text-center fw-bold">Forgot Password</h1>
        <div class="card">
            <div class="card-header">
                <form method="POST" action="/passwordforgot/forgotPassword">

                    <div class="mb-3">
                        <label class="small mb-1" for="inputEmailAddress">Email address</label>
                        <input class="form-control" id="inputEmailAddress" type="email"
                               placeholder="Enter your email address"
                               name="email">
                    </div>
                    <button class="ms-3 mb-3 mt-3 btn btn-primary" type="submit">Send email</button>
                </form>
            </div>
        </div>
    </div>

<?php
include_once __DIR__ . '/../footer.php';
?>
