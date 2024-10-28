<?php
include("Admin/includes/function.php");

if(isset($_POST['comment'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $status = "Unposted";

    $query = mysqli_query($con, "INSERT INTO `comments`(`name`, `email`, `comment`, `status`) 
    VALUES ('$name','$email','$message','$status')");
    if ($query) {
        echo "<script>window.open('index.php', '_self')</script>";
        $_SESSION['success'] = "Thank you for Your Comment.";
    } else {
        echo "<script>window.open('index.php', '_self')</script>";
        $_SESSION['warning'] = "Something Went Wrong!!.";
    }
}
if(isset($_POST['userCardRequest'])){

    $title = $_POST['title'];
    $newPrice = $_POST['newPrice'];
    $oldPrice = $_POST['oldPrice'];
    $desc = $_POST['desc'];
    $location = $_POST['location'];
    $date = date("Y-m-d");
    $category = $_POST['category'];
    $comp = $_POST['comp'];
    $status = "Unposted";

    $emailReq = $_POST['emailReq'];
    $phoneReq = $_POST['phoneReq'];

    $insertRequest = mysqli_query($con, "INSERT INTO `userrequest`(`email`, `phone`, `status`) 
    VALUES ('$emailReq','$phoneReq','Unpaid')");

    $insertCard = mysqli_query($con, "INSERT INTO `cards`(`title`, `new_price`, `old_price`, `description`, `location`, `category`, `compound`, `date`, `status`) 
    VALUES ('$title','$newPrice','$oldPrice','$desc','$location','$category','$comp','$date','$status')");

    if($insertCard){
        // ============ now inserting images =============

        $card_id = mysqli_insert_id($con);
    
        // Check if card_id exists in the database
        $checkCardId = mysqli_query($con, "SELECT * FROM `card_images` WHERE `card_id` = '$card_id'");
        
        if (mysqli_num_rows($checkCardId) > 0) {
            // Fetch existing images to delete them
            $existingImages = mysqli_fetch_assoc($checkCardId);
            $existingImagesArray = json_decode($existingImages['image'], true);
            
            // Delete images from the folder
            foreach ($existingImagesArray as $image) {
                $filePath = 'Admin/cardImages/' . $image;
                if (file_exists($filePath)) {
                    unlink($filePath); // Delete the file
                }
            }

            // Delete the record from the database
            mysqli_query($con, "DELETE FROM `card_images` WHERE `card_id` = '$card_id'");
        }
        
        // Upload new images
        $totalFiles = count($_FILES['fileImg']['name']);
        $filesArray = array();

        for ($i = 0; $i < $totalFiles; $i++) {
            $imageName = $_FILES['fileImg']['name'][$i];
            $tmpName = $_FILES['fileImg']['tmp_name'][$i];

            $imageExtension = explode('.', $imageName);
            $imageExtension = strtolower(end($imageExtension));

            $newImageName = uniqid() . '.' . $imageExtension;
            move_uploaded_file($tmpName, 'Admin/cardImages/' . $newImageName);
            $filesArray[] = $newImageName;
        }

        $filesArray = json_encode($filesArray);

        // Insert new images into the database
        $uploadImages = mysqli_query($con, "INSERT INTO `card_images`(`card_id`, `image`) VALUES ('$card_id', '$filesArray')");

        if ($uploadImages) {
            echo "<script>window.open('index.php','_self')</script>";
            $_SESSION['success'] = "Your Request has been sent Successfully. You will receive call for more details";
        }else{
            echo "<script>window.open('index.php','_self')</script>";
            $_SESSION['danger'] = "Failed to insert Images!!.";
        }

    }else{
        echo "<script>window.open('index.php','_self')</script>";
        $_SESSION['danger'] = "Failed to insert Card Data try again!!.";
    }
}
if(isset($_POST['login'])){

    $usernameL = $_POST['usernameL'];
    $passwordL = $_POST['passwordL'];

    $checkUser = mysqli_query($con, "SELECT * FROM `user` WHERE (`email` = '$usernameL' OR `username` = '$usernameL') AND `password`='$passwordL' ");
    if(mysqli_num_rows($checkUser) == 1){

        $_SESSION['LoggedIn'] = true;

        $_SESSION['success'] = "You have Logged In Successfully";
        echo "<script>window.open('index.php','_self')</script>";
    } else {
        $_SESSION['warning'] = "Username or Email And Password does not match!";
        echo "<script>window.open('index.php','_self')</script>";
    }

}
if(isset($_POST['userRegistration'])){
    $email = $_POST['email'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $checkUser = mysqli_query($con, "SELECT * FROM `user` WHERE `email` = '$email' OR `username` = '$username'");

    if (mysqli_num_rows($checkUser) > 0) {
        // If the email or username already exists, show an error message
        $_SESSION['danger'] = "Email or Username already exists!";
        echo "<script>window.open('index.php','_self')</script>";
    } else {
        // If unique, insert the new user
        $insertUser = mysqli_query($con, "INSERT INTO `user`(`email`, `username`, `phone`, `password`, `userType`) 
        VALUES ('$email','$username','$phone','$password','user')");

        if ($insertUser) {
            $_SESSION['LoggedIn'] = true;

            $_SESSION['success'] = "Your Account Registered Successfully";
            echo "<script>window.open('index.php','_self')</script>";
        } else {
            $_SESSION['danger'] = "Something Went Wrong!";
            echo "<script>window.open('index.php','_self')</script>";
        }
    }
}






?>