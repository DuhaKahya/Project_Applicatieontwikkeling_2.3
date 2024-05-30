<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../navigationbar.php';
?>

<div class="container">
    <h1>Dashboard</h1>
    <div class="row">
        <div class="col-3">
            <h4>Users</h4>
            <a href="dashboard/users">Manage Users</a>
        </div>
        <div class="col-3">
            <h4>Jazz</h4>
            <a href="/manage?type=artist">Manage Artists</a><br>
            <a href="/manage?type=song">Manage Songs</a><br>
            <a href="/manage?type=artistEvent">Manage Events</a><br>
            <a href="/manage?type=artistEventLocation">Manage Locations</a><br>
            <a href="/manage?type=artistMusicStyle">Manage Artist Music Style</a>
        </div>
        <div class="col-3">
            <h4>Yummy</h4>
            <a href="dashboard/restaurants">Manage Restaurants</a>
            <br>
            <a href="dashboard/restaurantsessions">Manage Restaurant Sessions</a>
            <br>
            <a href="dashboard/reservations">Manage Reservations</a>
        </div>
        <div class="col-3">
            <h4>History</h4>
            <a href="dashboard/historyLocations">Manage Locations</a><br>
            <a href="dashboard/historyTours">Manage Tours</a>
        </div>
        <div class="col-3">
            <h4>Orders</h4>
            <a href="dashboard/orders">Manage Orders</a><br>
        </div>
    </div>
</div>

<?php
include_once __DIR__ . '/../footer.php';
?>
