<?php
include __DIR__ . '/../header.php';
include __DIR__ . '/../navigationbar.php';

// Controleer of de queryparameter 'restaurant' is ingesteld in de URL
if (isset($_GET['restaurant'])) {
    $restaurantName = htmlspecialchars($_GET['restaurant']);
} 
?>

<div class="container">

    <div class="row mt-5">

        <div class="col-md-6">

            <!-- maak een back button aan -->
            <a href="yummy" class="btn btn-primary mb-3">Back to yummy!</a>

            <!--Restaurant Title from Yummy -->
            <h2><strong><?php echo $yummyDetails->name; ?> </strong></h2>

            <p style="font-size: 18px;"> 
                <!-- TitleDescription from DetailPage --> 
                <? echo $restaurantDetails->titleDescription; ?>
            </p>

            <div class="d-flex align-items-center mt-5">
                <!-- Location Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-geo-alt-fill me-2" viewBox="0 0 16 16">
                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                </svg>
                <p class="mb-0" style="font-size: 20px;"><strong><? echo $yummyDetails->location ?></strong></p>
            </div>
        </div>
        <div class="col-md-6">
            <img src="images/yummy/<? echo $restaurantDetails->imageDetail1?>" class="img-fluid h-100" alt="<? echo $yummyDetails->name ?>">
        </div>
    </div>
    

    <div class="row mt-5">
        
        <div class="col-md-6">
            <img src="images/yummy/<? echo $restaurantDetails->imageDetail2?>" class="img-fluid h-100" alt="<? echo $yummyDetails->name ?>">
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h3 class="card-title">Festival Information</h3>
                    <div class="row mt-5">
                        <div class="col-sm-6 border-end">
                            <div class="col-sm-8">
                                <ul class="list-unstyled">
                                    <li style="margin-bottom: 10px;">Sessions:</li>
                                    <li style="margin-bottom: 10px;">Duration/h:</li>
                                    <li style="margin-bottom: 10px;">First session:</li>
                                    <li style="margin-bottom: 10px;">Seats:</li>
                                    <li style="margin-bottom: 10px;">Price:</li>
                                </ul>
                            </div>
                            <div class="col-sm-4">
                                <ul class="list-unstyled">
                                    <li style="margin-bottom: 10px;">3</li>
                                    <li style="margin-bottom: 10px;">1.5</li>
                                    <li style="margin-bottom: 10px;">18:00</li>
                                    <li style="margin-bottom: 10px;"><? echo $yummyDetails->places ?></li>
                                    <li style="margin-bottom: 10px;">€<? echo $yummyDetails->price ?></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <ul class="list-unstyled">
                                <li>* Reservation is mandatory. A reservation fee of €10,- per person wil be charged when a reservation is made on the Haarlem Festival site. This fee will be deducted from the final check on visiting the restaurant.</li>
                                <br>
                                <li>* Please provide an option to inform the restaurant that guests have special requests regarding the food or service (allergies, wheelchair etc.)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       
    </div>

    <div class="row mt-5">
        
       

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <p><? echo $restaurantDetails->description ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <img src="images/yummy/<? echo $restaurantDetails->imageDetail3?>" class="img-fluid" style="height: 250px; width: 100%;" alt="<? echo $yummyDetails->name ?>">
        </div>

    </div>

    <div class="row mt-5">

        <!-- Picture -->
        <div class="col-md-6">
            <img src="images/yummy/<? echo $restaurantDetails->imageDetail4?>" class="img-fluid w-100" alt="<? echo $yummyDetails->name ?>">
        </div>

        <!-- Reservation Section -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h3 class="card-title"><strong>Reservation</strong></h3>
                    <p class="card-text"><?php echo $restaurantDetails->reservationText ?></p>
                    <a href="addreservation?restaurant=<?php echo urlencode($yummyDetails->name); ?>" class="btn btn-primary mt-2" style="margin-left: 20px;">Reserveren bij <?php echo $yummyDetails->name ?></a>
                </div>
            </div>
        </div>

    </div>

        
    <div class="row mt-5">

        <!-- Reviews  -->
        <div class="col-md-6">
            <div class="card" style="height: 160px;">
                <div class="card-body">
                    <h3 class="card-title">Reviews</h3>
                    <div class="review">
                        <p><strong>Over <?php echo $yummyDetails->name ?>:</strong></p>
                        <div class="d-flex align-items-center mb-3">
                            <?php
                            $rating = $yummyDetails->rating;
                            for ($i = 0; $i < $rating; $i++) {
                                echo '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill me-1" viewBox="0 0 16 16">
                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                </svg>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact -->
        <div class="col-md-6">
            <div class="card" style="height: 160px;">
                <div class="card-body">
                    <h3 class="card-title">Contact</h3>
                    <p><strong>Telefoonnummer:</strong> <?php echo $yummyDetails->number ?></p>
                    <p><strong>Email:</strong> <?php echo $yummyDetails->email ?></p>
                </div>
            </div>
        </div>

    </div>
                    






</div>

<?php
include __DIR__ . '/../footer.php';
?>
