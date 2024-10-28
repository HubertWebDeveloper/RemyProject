<?php include("Admin/includes/function.php"); ?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Vacant Houses</title>
  <link rel="shortcut icon" href="images/logo.png" />
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <!-- End plugin css for this page -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
  <!-- inject:css -->
  <link rel="stylesheet" href="style.css">
  <!-- endinject -->
  <!-- <link rel="shortcut icon" href="logo.png" /> -->
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- -------- slick slide --------- -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
  <!-- using alertify js message -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />
  <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
</head>
<style>
  .accordion-button {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .strong-text {
    display: -webkit-box;
    -webkit-line-clamp: 7;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
</style>
<body>
<?php
if (isset($_SESSION["success"])) {
    ?>
    <script type="text/javascript">
        alertify.set('notifier', 'position', 'top-right');
        alertify.success('<?= $_SESSION["success"] ?>');
    </script>
    <?php
    // Clear the session message after displaying it
    unset($_SESSION["success"]);
}
// Danger message
if (isset($_SESSION["danger"])) {
    ?>
    <script type="text/javascript">
        alertify.set('notifier', 'position', 'top-right');
        alertify.error('<?= $_SESSION["danger"] ?>');
    </script>
    <?php
    unset($_SESSION["danger"]);
}
// Warning message
if (isset($_SESSION["warning"])) {
    ?>
    <script type="text/javascript">
        alertify.set('notifier', 'position', 'top-right');
        alertify.warning('<?= $_SESSION["warning"] ?>');
    </script>
    <?php
    unset($_SESSION["warning"]);
}
// ===================================================================================
$cards = mysqli_query($con, "SELECT * FROM `cards` WHERE `category`='rent' AND `status`='Posted'");
$cards_count = mysqli_num_rows($cards);
$bbs = mysqli_query($con, "SELECT * FROM `cards` WHERE `category`='B&B' AND `status`='Posted'");
$bbs_count = mysqli_num_rows($bbs);
$aderts = mysqli_query($con, "SELECT * FROM `advert` WHERE `status`='Posted'");
$comments = mysqli_query($con, "SELECT * FROM `comments` WHERE `status`='Posted'");
$comps = mysqli_query($con, "SELECT * FROM `compound`");
$comps_count = mysqli_num_rows($comps);

?>
<nav class="navbar navbar-expand-lg shadow" data-bs-theme="dark" style="background:#3b5d50">
    <div class="container">
        <a class="navbar-brand" href="#"><img src="images/logo.png" style="width:110px;height:70px;mix-blend-mode:multiply"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                   <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                   <a class="nav-link" href="s.php">All Vancant</a>
                </li>
                <li class="nav-item">
                   <a class="nav-link" href="Myhistory.php">My Booking</a>
                </li>
                <li class="nav-item">
                   <a class="nav-link" href="ContactUs.php">Contact Us</a>
                </li>
                <?php
                 if(isset($_SESSION['LoggedIn'])){
                    ?>
                        <li class="nav-item">
                            <a class="btn text-white" style="background:red;margin-right:5px" href="logout.php">Log Out</a>
                        </li>
                    <?php
                 }else{
                    ?>
                        <li class="nav-item">
                            <button class="btn text-white" style="background:#2d7a6a;margin-right:5px" data-bs-toggle="modal" data-bs-target="#signIn">Login</button>
                        </li>
                    <?php
                 }
                ?>
                <li class="nav-item">
                   <button class="btn text-white" style="background:#13372f" data-bs-toggle="modal" data-bs-target="#vacant">Add Your Vacant</button>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="modal fade" id="signIn" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background:#3b5d50">
        <div class="w-100 text-center mt-2">
            <img src="images/logo.png" style="width:110px;height:70px;mix-blend-mode:multiply">
        </div>
        <div class="modal-body">
            <form action="EditCode.php" method="POST" enctype="multipart/form-data">
                <div class="row text-center">
                    <div class="col-md-12 mb-3">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02">Username</label>
                            <input type="text" name="usernameL" placeholder="Username Or Email" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02">Password</label>
                            <input type="password" name="passwordL" placeholder="Password" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <p>You don't have an account! 
                            <button class="btn" style="border:2px solid #13372f;color:white" data-bs-target="#Registration" data-bs-toggle="modal">Sign In</button>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="login" class="btn" style="background:#13372f;color:white">Login</button>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>
<!-- ================================ registration =========================== -->
<div class="modal fade" id="Registration" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background:#3b5d50">
        <div class="w-100 text-center mt-2">
            <img src="images/logo.png" style="width:110px;height:70px;mix-blend-mode:multiply">
        </div>
        <div class="modal-body">
            <form action="EditCode.php" method="POST" enctype="multipart/form-data">
                <div class="row text-center">
                    <div class="col-md-12 mb-3">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02">Email</label>
                            <input type="email" name="email" placeholder="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02">Phone</label>
                            <input type="phone" name="phone" placeholder="Phone" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02">Username</label>
                            <input type="text" name="username" placeholder="Username" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02">Password</label>
                            <input type="password" name="password" placeholder="Password" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <p>You already have an account! 
                            <button class="btn" style="border:2px solid #13372f;color:white" data-bs-target="#signIn" data-bs-toggle="modal">Login</button>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="userRegistration" class="btn" style="background:#13372f;color:white">Sign In</button>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>
<!-- ==================================== userRequest =========================== -->
<div class="modal fade" id="vacant" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
        <div class="w-100 text-center mt-2">
            <img src="images/logo.png" style="width:110px;height:70px;mix-blend-mode:multiply">
        </div>
        <div class="modal-body">
            <form action="EditCode.php" method="POST" enctype="multipart/form-data">
                <div class="row text-center">
                    <div class="card-header" style="border:none;background:none">
                        <p>User Detailes</p>
                        <hr>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02">Email</label>
                            <input type="email" name="emailReq" placeholder="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02">Phone</label>
                            <input type="phone" name="phoneReq" placeholder="Phone" class="form-control" required>
                        </div>
                    </div>
                    <div class="card-header" style="border:none;background:none">
                        <p>Card Detailes</p>
                        <hr>
                    </div>
                    <!-- =========================================== user details ======================= -->
                    <div class="col-md-6 mb-3">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02">Title</label>
                            <input type="text" name="title" placeholder="Card Title" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02">Location</label>
                            <input type="text" name="location" placeholder="Location..." class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02">Offer Price</label>
                            <input type="number" name="newPrice" placeholder="Offer Price" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02">Current Price</label>
                            <input type="number" name="oldPrice" placeholder="Current Price" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <span class="input-group-text">Description</span>
                            <textarea class="form-control" name="desc" placeholder="1 bedroom, kitchen, worshroom" aria-label="With textarea" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <span class="input-group-text">Category</span>
                            <select name="category" class="form-select" id="inputGroupSelect01" required>
                                <option value="rent">Vacant House</option>
                                <option value="B&B">Vacant B&Bs</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <span class="input-group-text">Compound</span>
                            <select name="comp" class="form-select" id="inputGroupSelect01" required>
                                <?php foreach($comps as $comp) : $id = $comp['id']; ?>
                                <option value="<?php $id ?>"><?= $comp['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <!-- ============================= images =================================== -->
                    <div class="card-header" style="border:none;background:none">
                        <p>Card Images | Multiple selection</p>
                        <hr>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01">Card ID</label>
                            <input type="number" name="card_id" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group mb-3">
                            <input type="file" name="fileImg[]" class="form-control" accept=".jpg, .jpeg, .png" required multiple>
                            <label class="input-group-text" for="inputGroupSelect02">Upload Images</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="userCardRequest" class="btn" style="background:#13372f;color:white">Send Request</button>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>