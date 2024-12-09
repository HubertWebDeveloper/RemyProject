<?php
include("includes/header.php");

if(isset($_GET['categ'])){
    $categ = $_GET['categ'];
    $cards = mysqli_query($con, "SELECT * FROM cards WHERE category='$categ' AND status='Posted'");
}
if(isset($_POST['filterall']) && isset($_GET['categ'])){
    $categ = $_GET['categ'];

    $location = $_POST['location'];
    $size = $_POST['size'];
    $price = $_POST['price'];

    $loca = "";
    $pri = "";
    $siz = "";
    if (!empty($location) && !empty($price) && !empty($size)) {
        // All three filters are set
        $cards = mysqli_query($con, "SELECT * FROM cards WHERE category='$categ' AND location LIKE '%$location%' AND new_price <= '$price' AND description LIKE '%$size%' AND status='Posted'");
        $loca = $location;
        $pri = $price;
        $siz = $size;
    } elseif (!empty($location) && !empty($price)) {
        // Location and price are set
        $cards = mysqli_query($con, "SELECT * FROM cards WHERE category='$categ' AND location LIKE '%$location%' AND new_price <= '$price' AND status='Posted'");
        $loca = $location;
        $pri = $price;
    } elseif (!empty($location) && !empty($size)) {
        // Location and size are set
        $cards = mysqli_query($con, "SELECT * FROM cards WHERE category='$categ' AND location LIKE '%$location%' AND description LIKE '%$size%' AND status='Posted'");
        $loca = $location;
        $siz = $size;
    } elseif (!empty($price) && !empty($size)) {
        // Price and size are set
        $cards = mysqli_query($con, "SELECT * FROM cards WHERE category='$categ' AND new_price <= '$price' AND description LIKE '%$size%' AND status='Posted'");
        $pri = $price;
        $siz = $size;
    } elseif (!empty($location)) {
        // Only location is set
        $cards = mysqli_query($con, "SELECT * FROM cards WHERE category='$categ' AND location LIKE '%$location%' AND status='Posted'");
        $loca = $location;
    } elseif (!empty($price)) {
        // Only price is set
        $cards = mysqli_query($con, "SELECT * FROM cards WHERE category='$categ' AND new_price <= '$price' AND status='Posted'");
        $pri = $price;
    } elseif (!empty($size)) {
        // Only size is set
        $cards = mysqli_query($con, "SELECT * FROM cards WHERE category='$categ' AND description LIKE '%$size%' AND status='Posted'");
        $siz = $size;
    } else {
        // No fields set
        echo "<script>window.open('index.php','_self')</script>";
        $_SESSION['warning'] = "All fields are empty <b style='font-size:34px'>#&9785</b>";
        exit();
    }
}

   
?>

<section class="featured">
    <div class="container">
        <div class="container filtering">
            <form action="allViews.php?categ=<?= $categ ?>" class="row mx-auto" method="POST">
                <div class="col-md-3 mb-3">
                    <div class="col-auto">
                        <label for="inputPassword2" class="visually-hidden">BY Location</label>
                        <input type="text" name="location" class="form-control" id="inputPassword2" placeholder="Search By Location...">
                    </div>
                </div>
                <?php
                if($categ == "Car"){
                    ?>
                        <div class="col-md-3 mb-3">
                            <div class="col-auto">
                                <label for="inputGroupSelect02" class="visually-hidden">Select Car Company</label>
                                <select class="form-select" name="carCompany" id="inputGroupSelect02">
                                    <option value="">Select Car Company...</option>
                                    <option value="toyota">Toyota</option>
                                    <option value="honda">Honda</option>
                                    <option value="ford">Ford</option>
                                    <option value="bmw">BMW</option>
                                    <option value="mercedes">Mercedes</option>
                                </select>
                            </div>
                        </div>
                    <?php
                }else{
                    ?>
                        <div class="col-md-3 mb-3">
                            <div class="col-auto">
                                <label for="inputPassword2" class="visually-hidden">BY Size</label>
                                <select class="form-select" name="size" class="form-control" id="inputGroupSelect02">
                                    <option value="">Search By Size...</option>
                                    <option value="bedsitter">Bed Sitter</option>
                                    <option value="1 bedroom">1 Bedroom</option>
                                    <option value="2 bedrooms">2 Bedroom</option>
                                    <option value="3 bedrooms">3 Bedroom</option>
                                </select>
                            </div>
                        </div>
                    <?php
                }
                ?>
                <div class="col-md-3 mb-3">
                    <div class="col-auto">
                        <label for="inputPassword2" class="visually-hidden">BY Price</label>
                        <input type="number" name="price" class="form-control" id="inputPassword2" placeholder="Search By Price...">
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="col-auto">
                        <button type="submit" name="filterall" class="btn mb-3 w-100" style="background:#3b5d50;color:white">Filter Out</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="events-header text-center">
            <?php
            if(isset($_POST['filterall'])){
                ?><h2>Results From Search:  <?php echo $loca ?> | <?php echo $pri ?> | <?php echo $siz ?>.</h2><?php
            }else{
                ?><h2>All Vacant On <?= $categ ?>.</h2><?php
            }
            ?>
            <p class="sub-text text-center">Don't miss, Get it Before someone else.</p>
        </div>
        <div class="row">
            <?php
               foreach($cards as $card) : $id = $card['id'];
               $date = $card['date'];
               $newDate = date("M d, Y",strtotime($date));
               $getImage = mysqli_query($con, "SELECT * FROM `card_images` WHERE card_id='$id'");
               $row = mysqli_fetch_assoc($getImage);
            ?>
            <div class="col-md-6 shadow mb-3 card-item">
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
                        <i class="fas fa-calendar" style="margin-right:10px;color:#3b5d50"></i> <?= $newDate ?> | 12:00 am - 1:00 am
                    </p>
                    <div class="rating text-center" style="font-size:24px;margin-bottom:15px;">
                        <span class="fw-bold" style="color:#3b5d50;">Compound Security:</span> 
                        <span class="text-danger">&#9733;&#9733;&#9733;&#9733;&#9734;</span> <!-- 4 out of 5 stars -->
                        <span>(4.0/5.0)</span>
                    </div>
                    <a href="view.php" class="btn text-white" style="background:#3b5d50">Book House</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php
        if(!mysqli_num_rows($cards) > 0){
            ?>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="fw-bold text-center text-danger">No Data Found &#9785 <a href="index.php" class="btn text-white" style="background:#3b5d50">Go Back</a></h4>
                    </div>
                </div>
            <?php
        }
        
        ?>
    </div>
    <div class="pagination-controls text-center mb-4">
        <button id="prev-page" class="btn btn-secondary"><i class="fas fa-backward"></i></button>
        <span id="page-info"></span>
        <button id="next-page" class="btn btn-secondary"><i class="fas fa-forward"></i></button>
    </div>
</section>
<script>
    const cardsPerPage = 10; // Number of cards to display per page
    let currentPage = 1; // Current page number

    const cards = document.querySelectorAll('.card-item'); // Select all card items
    const totalCards = cards.length;
    const totalPages = Math.ceil(totalCards / cardsPerPage);

    // Function to display cards based on the current page
    function displayCards() {
        const start = (currentPage - 1) * cardsPerPage;
        const end = start + cardsPerPage;

        cards.forEach((card, index) => {
            if (index >= start && index < end) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });

        document.getElementById('page-info').textContent = `Page ${currentPage} of ${totalPages}`;

        // Disable buttons based on the current page
        document.getElementById('prev-page').disabled = currentPage === 1;
        document.getElementById('next-page').disabled = currentPage === totalPages;
    }

    // Event listeners for pagination buttons
    document.getElementById('prev-page').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            displayCards();
        }
    });

    document.getElementById('next-page').addEventListener('click', () => {
        if (currentPage < totalPages) {
            currentPage++;
            displayCards();
        }
    });

    // Initial display of cards
    displayCards();

    // const carCompanies = [
    //     "Toyota", "Honda", "Ford", "BMW", "Mercedes", "Volkswagen", "Hyundai",
    //     "Nissan", "Chevrolet", "Kia", "Renault", "Peugeot", "Fiat", "Mazda",
    //     "Subaru", "Tesla", "Suzuki", "Mitsubishi", "Jaguar", "Land Rover", 
    //     "Porsche", "Volvo", "Ferrari", "Lamborghini", "Aston Martin", "Bugatti"
    // ];

    // const carCompanySelect = document.getElementById('carCompanySelect');

    // // Populate the dropdown
    // carCompanies.forEach(company => {
    //     const option = document.createElement('option');
    //     option.value = company.toLowerCase().replace(/\s+/g, '-'); // Value attribute (slugified)
    //     option.textContent = company; // Displayed text
    //     carCompanySelect.appendChild(option);
    // });
</script>







    
<?php 
include("includes/footer.php")
?>