<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../navigationbar.php';
?>

<section class="w-100 p-4 d-flex justify-content-center pb-4">
    <form method="POST" action="/login/login" class="auth-form">
        <div class="form-outline mb-4">
            <?php
                $flashHelper->displayFlashMessages();
            ?>
            <h1 class="text-center fw-bold">Login</h1>
            <input type="text" id="form2Example1" name="username" class="form-control">
            <label class="form-label" for="form2Example1">Username</label>
        </div>

        <div class="form-outline mb-4">
            <input type="password" id="form2Example2" name="password" class="form-control">
            <label class="form-label" for="form2Example2">Password</label>
        </div>

        <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>

        <div class="text-center">
            <p>Password forgotten? <a href="/passwordforgot">password forgotten</a></p>
            <p>Not a member? <a href="/register">Register</a></p>
        </div>
    </form>

</section>

<?php
include_once __DIR__ . '/../footer.php';
?>
