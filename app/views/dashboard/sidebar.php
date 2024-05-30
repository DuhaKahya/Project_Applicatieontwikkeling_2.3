<div class="flex-shrink-0 p-3" style="width: 280px;">
    <div class="flex-shrink-0 p-3 mb-3 text-decoration-none border-bottom">
        <h4 class="fw-bold">Manage</h4>
    </div>
    <ul class="list-unstyled ps-0">
        <li class="mb-1 mt-3">
            <button class="btn btn-toggle d-inline-flex align-items-center justify-content-center rounded border-0 collapsed"
                    data-bs-toggle="collapse" data-bs-target="#jazz-collapse" aria-expanded="false">
                Jazz
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-caret-down ms-2" viewBox="0 0 16 16">
                    <path d="M3.204 5h9.592L8 10.481zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659"/>
                </svg>
            </button>

            <div class="collapse mt-2" id="jazz-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="/manage?type=artist"
                           class="link-body-emphasis d-inline-flex text-decoration-none rounded"
                           style="visibility: visible">Artists</a></li>
                    <li><a href="/manage?type=song"
                           class="link-body-emphasis d-inline-flex text-decoration-none rounded"
                           style="visibility: visible">Songs</a></li>
                    <li><a href="/manage?type=artistEvent"
                           class="link-body-emphasis d-inline-flex text-decoration-none rounded"
                           style="visibility: visible">Events</a></li>
                    <li><a href="/manage?type=artistEventLocation"
                           class="link-body-emphasis d-inline-flex text-decoration-none rounded"
                           style="visibility: visible">Locations</a></li>
                    <li><a href="/manage?type=artistMusicStyle"
                           class="link-body-emphasis d-inline-flex text-decoration-none rounded"
                           style="visibility: visible">Artist Music Style</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="mb-1 mt-3">
            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                    data-bs-toggle="collapse" data-bs-target="#users-collapse" aria-expanded="false">
                Users
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-caret-down ms-2" viewBox="0 0 16 16">
                    <path d="M3.204 5h9.592L8 10.481zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659"/>
                </svg>
            </button>
            <div class="collapse mt-2" id="users-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="http://localhost/dashboard/users"
                           class="link-body-emphasis d-inline-flex text-decoration-none rounded"
                           style="visibility: visible">Users</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="mb-1 mt-3">
            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                    data-bs-toggle="collapse" data-bs-target="#yummy-collapse" aria-expanded="false">
                Yummy
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-caret-down ms-2" viewBox="0 0 16 16">
                    <path d="M3.204 5h9.592L8 10.481zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659"/>
                </svg>
            </button>
            <div class="collapse mt-2" id="yummy-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="http://localhost/dashboard/restaurants"
                           class="link-body-emphasis d-inline-flex text-decoration-none rounded"
                           style="visibility: visible">Restaurants</a></li>
                    <li><a href="http://localhost/dashboard/restaurantsessions"
                           class="link-body-emphasis d-inline-flex text-decoration-none rounded"
                           style="visibility: visible">Restaurant Sessions</a>
                    </li>
                    <li><a href="http://localhost/dashboard/reservations"
                           class="link-body-emphasis d-inline-flex text-decoration-none rounded"
                           style="visibility: visible">Reservations</a></li>
                </ul>
            </div>
        </li>
        <li class="mb-1 mt-3">
            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                    data-bs-toggle="collapse" data-bs-target="#history-collapse" aria-expanded="false">
                History
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-caret-down ms-2" viewBox="0 0 16 16">
                    <path d="M3.204 5h9.592L8 10.481zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659"/>
                </svg>
            </button>
            <div class="collapse mt-2" id="history-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="http://localhost/dashboard/historyLocations"
                           class="link-body-emphasis d-inline-flex text-decoration-none rounded"
                           style="visibility: visible">Locations</a></li>
                    <li><a href="http://localhost/dashboard/historyTours"
                           class="link-body-emphasis d-inline-flex text-decoration-none rounded"
                           style="visibility: visible">Tours</a></li>
                </ul>
            </div>
        </li>
        <li class="mb-1 mt-3">
            <a href="http://localhost/dashboard/orders" class="btn d-inline-flex align-items-center rounded border-0">
                Orders
            </a>
        </li>

    </ul>
</div>
