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
            <form method="POST" action="/passwordreset/resetPassword">
                <div class="row">
                    <?php if (isset($_GET['token'])): ?>
                        <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token']) ?>" tabindex="-1">
                    <?php endif; ?>

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
                <button class="ms-3 mb-3 mt-3 btn btn-primary" type="submit">Save changes</button>
            </form>
        </div>
    </div>
</div>

<?php
include_once __DIR__ . '/../footer.php';
?>
