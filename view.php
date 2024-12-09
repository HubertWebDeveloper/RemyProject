<?php include("includes/header.php") ?>
<?php
if(isset($_GET['id'])){
    $idView = $_GET['id'];
    $cardViews = mysqli_query($con, "SELECT * FROM `cards` WHERE id='$idView' AND `status`='Posted'");
    $rows = mysqli_fetch_assoc($cardViews);
    $categ = $rows['category'];
    $com = $rows['compound'];

    $compd = mysqli_query($con, "SELECT * FROM `compound` WHERE id='$com'");
    $compd_row = mysqli_fetch_assoc($compd);

    $getImageView = mysqli_query($con, "SELECT * FROM `card_images` WHERE card_id='$idView'");
    $row = mysqli_fetch_assoc($getImageView);
}else{
    $_SESSION['warning'] = "No Card Selected!";
    echo "<script>window.open('index.php','_self')</script>";
}
?>
<section class="featured">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-9 shadow">
                <div id="<?= $idView ?>" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                    <div class="carousel-inner" style="width:100%;height:450px;border-radius:10px;object-fit:fill">
                        <div class="carousel-item active">
                            <img src="images/img1.jpg" class="d-block w-100" alt="Image 1" style="height: 100%; object-fit: cover;">
                        </div>
                        <?php foreach(json_decode($row['image']) as $image) : ?>
                        <div class="carousel-item">
                            <img src="Admin/cardImages/<?= $image ?>" class="d-block w-100" alt="Image 2" style="height: 100%; object-fit: cover;">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#<?= $idView ?>" data-bs-slide="prev" style="background:black">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#<?= $idView ?>" data-bs-slide="next" style="background:black">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                <div class="row mx-auto mt-2 mb-3">
                    <div class="col-md-6">
                        <b><?= $rows['title'] ?></b>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold float-end" style="color:#3b5d50;margin-left:13px">
                                <i class="fas fa-check text-success"></i> 
                                Ksh<?= $rows['new_price'] ?> / 
                                <span class="btn text-white" style="background:#3b5d50;text-decoration:line-through;padding:2px">Ksh<?= $rows['old_price'] ?>
                            </span>
                        </h6>
                    </div>
                </div>
                <div class="event-description">
                <p><?= $rows['description'] ?></p>
            </div>
            </div>
            

            <div class="col-md-3 shadow">
                <p>House Location: </p>
                <img src="images/map.png" style="width:100%;height:200px">
                <div class="company-details mt-2">
                    <p class="fw-bold" style="color:#3b5d50"><i class="fas fa-building"style="margin-right:10px"></i> Compound Detailes:</p>
                    <div class="company-location">
                        <p><i class="fas fa-map-marker"style="margin-right:10px"></i> <?= $rows['location'] ?></p>
                    </div>
                </div>
                <div class="company-details mt-2">
                    <p class="fw-bold" style="color:#3b5d50"><i class="fas fa-building"style="margin-right:10px"></i> Reach Out | More Info</p>
                    <div class="company-location">
                        <p><i class="fas fa-phone"style="margin-right:10px"></i> CareTaker: <b><?= $compd_row['c_contact'] ?></b></p>
                        <p><i class="fas fa-phone"style="margin-right:10px"></i> LandLord: <b><?= $compd_row['l_contact'] ?></b></p>
                    </div>
                </div>
                <?php
                if($categ == "B&B"){
                    ?><p class="w-100 text-center"><b class="btn btn-sm bg-warning text-white">B&Bs</b></p><?php
                }else{
                    ?><p class="w-100 text-center"><b class="btn btn-sm bg-info text-white">Rents</b></p><?php
                }
                ?>
                
            </div>
        </div>
    </div>
</section>

<?php include("includes/footer.php") ?>