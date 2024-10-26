<?php include("includes/header.php") ?>
<?php
    if(!isset($_SESSION['LoggedIn'])){
    echo "<script>window.open('index.php','_self')</script>";
    $_SESSION['warning'] = "Please Log In To Continue.";
    }
?>
<section class="featured">
    <div class="container">
        <ol class="list-group list-group-numbered">
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <i class="fas fa-house"></i>
                <div class="fw-bold"><b>House | B&Bs: </b> House Title</div>
                    <p style="margin-bottom:-5px"><b>Description: </b> Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                    <p style="margin-bottom:-5px"><b>Location: </b> House Location.</p>
                </div>
                <span class="badge text-bg-primary rounded-pill" style="margin-right:10px">Ksh14,000</span>
                <span class="badge text-bg-danger rounded-pill">UnPaid</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <i class="fas fa-house"></i>
                <div class="fw-bold"><b>House | B&Bs: </b> House Title</div>
                    <p style="margin-bottom:-5px"><b>Description: </b> Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                    <p style="margin-bottom:-5px"><b>Location: </b> House Location.</p>
                </div>
                <span class="badge text-bg-primary rounded-pill" style="margin-right:10px">Ksh14,000</span>
                <span class="badge text-bg-success rounded-pill">Paid</span>
            </li>
        </ol>
    </div>
</section>

<?php include("includes/footer.php") ?>