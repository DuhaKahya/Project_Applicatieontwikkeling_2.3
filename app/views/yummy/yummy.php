<?php
include __DIR__ . '/../header.php';
include __DIR__ . '/../navigationbar.php';


$maxRestaurantId = 0;
foreach ($restaurants as $restaurant) {
    if ($restaurant->restaurantId > $maxRestaurantId) {
        $maxRestaurantId = $restaurant->restaurantId;
    }
}

?>

<div class="container">

    <div class="container-fluid">
        <div class="row">
            <div class="col position-relative">
                <!-- Overlay met tekst -->
                <div class="text-white position-absolute">
                    <h1 class="display-3 bg-dark px-3">Yummy!</h1>
                    <button class="btn btn-primary btn-block mt-2">27, 28, 29, 30 & 31 July</button>
                </div>
                <img src="images/yummy/header.png" alt="Yummy" class="img-fluid w-100" style="height: auto;">
            </div>
        </div>
    </div>

    <div class="container-fluid text-center">
        <div class="row mt-5">
            <h3>Yummy! - Dining in Haarlem (27 July - 31 July)</h3>

            <p>Yummy! Experience the delicious side of Haarlem at our 'Yummy!' event. Dive into a world of flavors, where local restaurants showcase their best dishes and festival menus. Meet the chefs, discover unique cuisines, and indulge in the culinary delights that make Haarlem a paradise for food lovers. Check out the tasty details of 'Yummy!' at the festival below.</p>        
        </div>

        <a class="btn btn-primary mx-auto disabled">Food Events</a>

        <p class="display-6 my-3">⬇️</p>
    </div>

    <?php for($j = 1; $j <= $maxRestaurantId; $j++): ?>
        <?php foreach ($restaurants as $restaurant): ?>
            <?php if ($restaurant->restaurantId == $j): ?>
                <div class="row align-items-center mt-3">
                    
                        <div class="col-lg-6">
                            <img src="images/yummy/<?php echo $restaurant->image; ?>" style="height: 290px; width: 100%" alt="<?php echo $restaurant->name; ?>" class="img-fluid">
                        </div>
                             
                    <div class="col-lg-6">
                        <div class="card" style="width: 100%;">
                            <div class="card-body">
                                <h3><?php echo $restaurant->name; ?></h3>

                                <div class="d-flex align-items-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-geo-alt-fill me-2" viewBox="0 0 16 16">
                                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                                    </svg>
                                    <p class="mb-0"><?php echo $restaurant->location; ?></p>
                                </div>

                                <div class="d-flex align-items-center mb-3">
                                    <?php
                                    // Haal de vlag op basis van de specialityId
                                    $specialityId = $restaurant->specialityId;
                                    $speciality = $this->yummyService->getSpecialityById($specialityId);
                                    $flag = $speciality->flag;
                                    ?>
                                    <img src="<?php echo $flag; ?>" alt="<?php echo $flag; ?> Vlag" style="height: 20px;" class="me-2">
                                    <p class="mb-0"><?php echo $restaurant->description; ?></p>
                                </div>


                                <div class="d-flex align-items-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="25" height="25">
                                        <path d="M248 48V256h48V58.7c23.9 13.8 40 39.7 40 69.3V256h48V128C384 57.3 326.7 0 256 0H192C121.3 0 64 57.3 64 128V256h48V128c0-29.6 16.1-55.5 40-69.3V256h48V48h48zM48 288c-12.1 0-23.2 6.8-28.6 17.7l-16 32c-5 9.9-4.4 21.7 1.4 31.1S20.9 384 32 384l0 96c0 17.7 14.3 32 32 32s32-14.3 32-32V384H352v96c0 17.7 14.3 32 32 32s32-14.3 32-32V384c11.1 0 21.4-5.7 27.2-15.2s6.4-21.2 1.4-31.1l-16-32C423.2 294.8 412.1 288 400 288H48z"/>
                                    </svg>
                                    <p class="mb-0" style="margin-left: 5px;"><?php echo $restaurant->places; ?></p>
                                </div>

                                <div class="d-flex align-items-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-currency-euro me-2" viewBox="0 0 16 16">
                                        <path d="M4 9.42h1.063C5.4 12.323 7.317 14 10.34 14c.622 0 1.167-.068 1.659-.185v-1.3c-.484.119-1.045.17-1.659.17-2.1 0-3.455-1.198-3.775-3.264h4.017v-.928H6.497v-.936q-.002-.165.008-.329h4.078v-.927H6.618c.388-1.898 1.719-2.985 3.723-2.985.614 0 1.175.05 1.659.177V2.194A6.6 6.6 0 0 0 10.341 2c-2.928 0-4.82 1.569-5.244 4.3H4v.928h1.01v1.265H4v.928z"/>
                                    </svg>
                                    <p class="mb-0"><?php echo $restaurant->price; ?></p>
                                </div>

                                <div class="d-flex align-items-center mb-3">
                                    <?php
                                    for ($i = 0; $i < $restaurant->rating; $i++) {
                                        echo '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill me-1" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                        </svg>';
                                    }
                                    ?>
                                    <?php
                                    for ($i = $restaurant->rating; $i < 5; $i++) {
                                        echo '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star me-1" viewBox="0 0 16 16">
                                            <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                                        </svg>';
                                    }
                                    ?>
                                </div>

                            </div>

                        </div>

                        <div class="d-flex mt-3">

                         
                        <?php if (!isset($_SESSION['user_id'])): ?>
                            <a href="/login" class="btn btn-primary" style="margin-left: 15px;">Add reservation</a>
                        <?php else: ?>
                            <a href="addreservation?restaurant=<?= urlencode($restaurant->name) ?>" class="btn btn-primary" style="margin-left: 15px;">Add reservation</a>
                        <?php endif; ?>


                            <!-- Link for more information -->
                            <a href="restaurantdetailpage?restaurant=<?php echo urlencode($restaurant->name); ?>" type="link" style="margin-left: 20px;">Click here for more information</a>  
                        </div>

                      
               

                    </div>

                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endfor; ?>
   

</div>


<?php
include __DIR__ . '/../footer.php';
?>
