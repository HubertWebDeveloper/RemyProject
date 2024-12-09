<?php include("includes/header.php") ?>

<section class="home">
    <div class="content">
    <h3>This House is Waiting for You</h3>
    <p>Discover your new home, a place full of potential and possibilities.</p>
        <!-- <a href="#" class="btn btn-warning">discover more</a> -->
    </div>
    <div class="controls">
        <span class="vid-btn active" data-src="videos/1.mp4"></span>
        <?php 
            foreach($aderts as $adert) : $id = $adert['id']; $status=$adert['status']; 
            $publishedDate = new DateTime($adert['published_date']);
            $endDate = new DateTime($adert['end_date']);
            $currentDate = new DateTime();
            if ($currentDate >= $publishedDate && $currentDate <= $endDate) {
                ?><span class="vid-btn" data-src="Admin/AdvertVideos/<?=$adert['video'] ?>"></span><?php
            }

        ?>
        <?php endforeach; ?>
    </div>
    <div class="video-container">
        <video src="videos/1.mp4" id="video-slider" loop autoplay muted></video>
    </div>
</section>
<?php
// Initialize categories array
$categories = [];

// Fetch distinct categories from the database
$categoryQuery = mysqli_query($con, "SELECT DISTINCT category FROM cards WHERE `category` != 'B&B'");
while ($categoryRow = mysqli_fetch_assoc($categoryQuery)) {
    $categories[] = $categoryRow['category'];
}
?>

<section class="featured">
    <div class="container">
        <div class="events-header text-center">
            <h2>Vacant House.</h2>
            <p class="sub-text text-center">Don't miss, Get it Before someone else.</p>
        </div>

        <div class="container filtering">
            <form action="s.php" class="row mx-auto" method="POST">
                <div class="col-md-3 mb-3">
                    <input type="text" name="location" class="form-control" placeholder="Search By Location...">
                </div>
                <div class="col-md-3 mb-3">
                    <select class="form-select" name="size">
                        <option value="">Search By Size...</option>
                        <option value="bedsitter">Bed Sitter</option>
                        <option value="1 bedroom">1 Bedroom</option>
                        <option value="2 bedrooms">2 Bedrooms</option>
                        <option value="3 bedrooms">3 Bedrooms</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <input type="number" name="price" class="form-control" placeholder="Search By Price...">
                </div>
                <div class="col-md-3 mb-3">
                    <button type="submit" name="filter" class="btn w-100" style="background:#3b5d50;color:white;">Filter Out</button>
                </div>
            </form>
        </div>

        <?php foreach ($categories as $category): ?>
        <div class="category-section">
            <div class="row">
                <div class="col-md-9">
                    <h3 class="text-secondary"><?= ucfirst($category) ?> Collections</h3>
                    <p class="sub-text">Don't miss, Get it Before someone else.</p>
                </div>
                <div class="col-md-3 float-end my-auto">
                    <a href="allViews.php?categ=<?= $category ?>" class="float-end btn btn-primary text-white">View all</a>
                </div>
            </div>
            <hr>
            
            <div class="row">
                <?php
                // Fetch cards for the current category
                $cardsQuery = mysqli_query($con, "SELECT * FROM cards WHERE category = '$category'");
                while ($card = mysqli_fetch_assoc($cardsQuery)):
                    $id = $card['id'];
                    $date = $card['date'];
                    $newDate = date("M d, Y", strtotime($date));

                    // Fetch card images
                    $imageQuery = mysqli_query($con, "SELECT * FROM `card_images` WHERE card_id='$id'");
                    $imageRow = mysqli_fetch_assoc($imageQuery);
                ?>
                <div class="col-md-6 shadow mb-3 bg-white">
                    <div id="<?= $id ?>" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                        <div class="carousel-inner" style="height:370px;">
                            <a href="view.php?id=<?= $id ?>" class="carousel-item active">
                                <img src="images/img1.jpg" class="d-block w-100" alt="Image 1" style="height: 100%; object-fit: cover;">
                            </a>
                            <?php foreach (json_decode($imageRow['image']) as $image): ?>
                            <a href="view.php?id=<?= $id ?>" class="carousel-item">
                                <img src="Admin/cardImages/<?= $image ?>" class="d-block w-100" alt="Image" style="height: 100%; object-fit: cover;">
                            </a>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#<?= $id ?>" data-bs-slide="prev" style="background:black">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#<?= $id ?>" data-bs-slide="next" style="background:black">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <div class="card-body text-center mb-3">
                        <div class="head text-start mt-2">
                            <h5 class="fw-bold" style="font-size:16px;margin-left:13px"><?= $card['title'] ?></h5>
                            <h6 class="fw-bold text-danger" style="margin-left:13px">Price Starts from: <i class="fas fa-check text-success"></i> Ksh<?= $card['new_price'] ?> / <span class="btn btn-danger text-white" style="text-decoration:line-through;padding:2px">Ksh <?= $card['old_price'] ?></span></h6>
                        </div>
                        <p class="card-text" style="font-size:15px">
                            <i class="fas fa-house" style="margin-right:10px;color:#3b5d50"></i> House Desc: <b><?= $card['description'] ?></b> 
                        </p>
                        <p class="card-text" style="font-size:15px">
                            <i class="fas fa-map-marker" style="margin-right:10px;color:#3b5d50"></i> Location: <?= $card['location'] ?>
                        </p>
                        <p class="card-text" style="font-size:15px">
                            <i class="fas fa-calendar" style="margin-right:10px;color:#3b5d50"></i> <?= $newDate ?>
                        </p>
                        <div class="rating text-center" style="font-size:24px;margin-bottom:15px;">
                            <span class="fw-bold" style="color:#3b5d50;">Compound Security:</span> 
                            <span class="text-danger">&#9733;&#9733;&#9733;&#9733;&#9734;</span> 
                            <span>(4.0/5.0)</span>
                        </div>
                        <a href="view.php?id=<?= $id ?>" class="btn text-white" style="background:#3b5d50">Book House</a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- <div id="services" class="container row mx-auto mt-3 mb-3">
    <div class="slick-slider">
        <div class="col-md-2">
            <img src="images/chine.png" width="45%" height="90" style="border-radius:50%;opacity:0.3">
        </div>
        <div class="col-md-2">
            <img src="images/ashley.png" width="45%" height="90" style="border-radius:50%;opacity:0.3">
        </div>
        <div class="col-md-2">
            <img src="images/amazon.png" width="45%" height="90" style="border-radius:50%;opacity:0.3">
        </div>
        <div class="col-md-2">
            <img src="images/amaz.png" width="45%" height="90" style="border-radius:50%;opacity:0.3">
        </div>
        <div class="col-md-2">
            <img src="images/google.png" width="45%" height="90" style="border-radius:50%;opacity:0.3">
        </div>
        <div class="col-md-2">
            <img src="images/logo.png" width="45%" height="90" style="border-radius:50%;opacity:0.3">
        </div>
        <div class="col-md-2">
            <img src="images/chine.png" width="45%" height="90" style="border-radius:50%;opacity:0.3">
        </div>
        <div class="col-md-2">
            <img src="images/ashley.png" width="45%" height="90" style="border-radius:50%;opacity:0.3">
        </div>
        <div class="col-md-2">
            <img src="images/amazon.png" width="45%" height="90" style="border-radius:50%;opacity:0.3">
        </div>
        <div class="col-md-2">
            <img src="images/amaz.png" width="45%" height="90" style="border-radius:50%;opacity:0.3">
        </div>
        <div class="col-md-2">
            <img src="images/google.png" width="45%" height="90" style="border-radius:50%;opacity:0.3">
        </div>
        <div class="col-md-2">
            <img src="images/logo.png" width="45%" height="90" style="border-radius:50%;opacity:0.3">
        </div>
    </div>
</div> -->
<!-- --------------- rating status ------------ -->
<div class="rating" style="background-image:url('images/img8.jpg'); background-size: cover;">
    <div class="container row mx-auto mb-4" style="padding:20px">
        <div class="col-md-4 text-center text-light">
            <i style="font-size:23px" class="fas fa-house"></i>
            <h4 style="font-size:33px" class="mt-2 mb-2">
                <?php
                    if ($cards_count < 1000) {
                        // Display with two leading zeros
                        echo str_pad($cards_count, 3, '0', STR_PAD_LEFT);
                    } elseif ($cards_count < 1000000) {
                        // Display with 'K' for thousands
                        echo round($cards_count / 1000, ($cards_count >= 10000 ? 0 : 1)) . 'K';
                    } else {
                        // Display with 'M' for millions
                        echo round($cards_count / 1000000, ($cards_count >= 10000000 ? 0 : 1)) . 'M';
                    }
                ?>
            </h4>
            <p>All Rents Houses</p>
        </div>
        <div class="col-md-4 text-center text-light">
            <i style="font-size:23px" class="fas fa-building"></i>
            <h4 style="font-size:33px" class="mt-2 mb-2">
                <?php
                    if ($bbs_count < 1000) {
                        // Display with two leading zeros
                        echo str_pad($bbs_count, 3, '0', STR_PAD_LEFT);
                    } elseif ($bbs_count < 1000000) {
                        // Display with 'K' for thousands
                        echo round($bbs_count / 1000, ($bbs_count >= 10000 ? 0 : 1)) . 'K';
                    } else {
                        // Display with 'M' for millions
                        echo round($bbs_count / 1000000, ($bbs_count >= 10000000 ? 0 : 1)) . 'M';
                    }
                ?>
            </h4>
            <p>All B&BS</p>
        </div>
        <div class="col-md-4 text-center text-light">
            <i style="font-size:23px" class="fas fa-users"></i>
            <h4 style="font-size:33px" class="mt-2 mb-2">
                <?php
                    if ($comps_count < 1000) {
                        // Display with two leading zeros
                        echo str_pad($comps_count, 3, '0', STR_PAD_LEFT);
                    } elseif ($comps_count < 1000000) {
                        // Display with 'K' for thousands
                        echo round($comps_count / 1000, ($comps_count >= 10000 ? 0 : 1)) . 'K';
                    } else {
                        // Display with 'M' for millions
                        echo round($comps_count / 1000000, ($comps_count >= 10000000 ? 0 : 1)) . 'M';
                    }
                ?>
            </h4>
            <p>Compound Partnered</p>
        </div>
    </div>
</div>
<!-- ---------------------- B&Bs ----------------- -->
<section class="featured">
    <div class="container">
        <div class="events-header text-center">
            <h2>B&Bs Vacant House.</h2>
            <p class="sub-text text-center">Don't miss, Get it Before someone else.</p>
        </div>
        <div class="row">
            <?php
               foreach($bbs as $bb) : $id = $bb['id'];
               $date = $bb['date'];
               $newDate = date("M d, Y",strtotime($date));
               $getImage = mysqli_query($con, "SELECT * FROM `card_images` WHERE card_id='$id'");
               $row = mysqli_fetch_assoc($getImage);
            ?>
            <div class="col-md-6 shadow mb-3">
                <div id="<?php $id ?>" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                    <div class="carousel-inner" style="height:370px;">
                        <div class="carousel-item active">
                            <img src="images/img1.jpg" class="d-block w-100" alt="Image 1" style="height: 100%; object-fit: cover;">
                        </div>
                        <?php foreach(json_decode($row['image']) as $image) : ?>
                        <div class="carousel-item">
                            <img src="Admin/cardImages/<?= $image ?>" class="d-block w-100" alt="Image 2" style="height: 100%; object-fit: cover;">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#<?php $id ?>" data-bs-slide="prev" style="background:black">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#<?php $id ?>" data-bs-slide="next" style="background:black">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <div class="card-body text-center mb-3">
                    <div class="head text-start mt-2">
                        <h5 class="fw-bold" style="font-size:16px;margin-left:13px"><?= $bb['title'] ?> | <b class="btn btn-sm btn-info" style="color:white">B&Bs</b></h5>
                        <h6 class="fw-bold text-warning" style="margin-left:13px">Price Starts from: <i class="fas fa-check text-success"></i> Ksh<?= $bb['new_price'] ?> / <span class="btn btn-warning text-white" style="text-decoration:line-through;padding:2px">Ksh <?= $bb['old_price'] ?></span></h6>
                    </div>
                    <p class="card-text" style="font-size:15px">
                        <i class="fas fa-house" style="margin-right:10px;color:#3b5d50"></i> House Desc: <b><?= $bb['description'] ?></b> 
                    </p>
                    <p class="card-text" style="font-size:15px">
                        <i class="fas fa-map-marker" style="margin-right:10px;color:#3b5d50"></i> Location: <?= $bb['location'] ?>
                    </p>
                    <p class="card-text" style="font-size:15px">
                        <i class="fas fa-calendar" style="margin-right:10px;color:#3b5d50"></i> <?= $newDate ?> | 12:00 am - 1:00 am
                    </p>
                    <div class="rating text-center" style="font-size:24px;margin-bottom:15px;">
                        <span class="fw-bold" style="color:#3b5d50;">Compound Security:</span> 
                        <span class="text-warning">&#9733;&#9733;&#9733;&#9733;&#9734;</span> <!-- 4 out of 5 stars -->
                        <span>(4.0/5.0)</span>
                    </div>
                    <a href="view.php?id=<?= $id ?>" class="btn text-white" style="background:#3b5d50">Get B&B</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>



<script>
    const videoSlider = document.getElementById('video-slider');
    const videoButtons = document.querySelectorAll('.vid-btn');
    let currentVideoIndex = 0;

    function changeVideo() {
        // Update the currentVideoIndex and get the new video source
        currentVideoIndex = (currentVideoIndex + 1) % videoButtons.length;
        const newSrc = videoButtons[currentVideoIndex].getAttribute('data-src');
        
        // Change the video source and play the new video
        videoSlider.src = newSrc;
        videoSlider.play();

        // Update the active button class
        document.querySelector('.controls .active').classList.remove('active');
        videoButtons[currentVideoIndex].classList.add('active');
    }
    setInterval(changeVideo, 5000); // Change video every 5 seconds
</script>
<?php include("includes/footer.php") ?>