<nav id="navigation" class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
    <div class="container-fluid">
        <div class="logo">
            <img src="/images/haarlem-logo.png" alt="" width="150" height="120">
        </div>
        <a id="title" class="navbar-brand" href="/">THE FESTIVAL</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link" href="/">HOME</a>
                <a class="nav-link" href="/yummy">YUMMY!</a>
                <a class="nav-link" href="/history">HISTORY</a>
                <a class="nav-link" href="/jazz">JAZZ</a>
                <a class="nav-link" href="<?php echo isset($_SESSION['username']) ? '/personalprogram' : '/login'; ?>">PERSONAL
                    PROGRAM</a>
                <?php if (isset($_SESSION['role_name']) && $_SESSION['role_name'] === "Admin") {
                    echo '<a class="nav-link" href="/dashboard">DASHBOARD</a>';
                } ?>
                <?php if (isset($_SESSION['username'])) {
                    echo '<a class="nav-link" href="/profile">PROFILE</a>';
                } ?>

                <?php
                if (isset($_SESSION['username'])) {
                    echo '<a id="loginbutton" class="nav-link" href="/login/logout">' . htmlspecialchars($_SESSION['username']) . '</a>';
                } else
                    echo '<a id="loginbutton" class="nav-link" href="/login">Login</a>';
                ?>
            </div>
        </div>
    </div>
</nav>
