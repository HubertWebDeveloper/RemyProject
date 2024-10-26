<?php
include("includes/function.php");


if(isset($_POST['cardBtn'])){

    $title = $_POST['title'];
    $newPrice = $_POST['newPrice'];
    $oldPrice = $_POST['oldPrice'];
    $desc = $_POST['desc'];
    $location = $_POST['location'];
    $date = date("Y-m-d");
    $status = "Posted";
    //echo $date;


    $insertCard = mysqli_query($con, "INSERT INTO `cards`(`title`, `new_price`, `old_price`, `description`, `location`, `date`, `status`) 
    VALUES ('$title','$newPrice','$oldPrice','$desc','$location','$date','$status')");

    if($insertCard){
        echo "<script>window.open('Card.php','_self')</script>";
        $_SESSION['success'] = "Card Added Successfully.";
    }else{
        echo "<script>window.open('Card.php','_self')</script>";
        $_SESSION['danger'] = "Something Went Wrong!!.";
    }
}
if (isset($_POST['selected']) && !empty($_POST['selected'])) {
    $selected_ids = $_POST['selected'];
    $ids_string = implode(",", $selected_ids);

    //echo "Selected IDs: " . $ids_string . "<br><br>";

        // Display the values for each row
        // echo "ID: " . $id . "<br>";
        // echo "Title: " . $title . "<br>";
        // echo "New Price: " . $new_price . "<br>";
        // echo "Old Price: " . $old_price . "<br>";
        // echo "Description: " . $description . "<br>";
        // echo "Location: " . $location . "<br>";
        // echo "<br>";

    // Handle Edit Selected
    if (isset($_POST['editSelected'])) {
        foreach ($selected_ids as $id) {
            // Get the data for each selected row
            $title = $_POST['title'][$id]; 
            $new_price = $_POST['new_price'][$id];  
            $old_price = $_POST['old_price'][$id];    
            $description = $_POST['description'][$id]; 
            $location = $_POST['location'][$id];

            $query = mysqli_query($con, "UPDATE `cards` SET `title` = '$title', 
            `new_price` = '$new_price', 
            `old_price` = '$old_price', 
            `description` = '$description', 
            `location` = '$location' 
            WHERE `id` = $id");
            if($query){
                echo "<script>window.open('Card.php','_self')</script>";
                $_SESSION['success'] = "Data Updated Successfully.";
            }else{
                echo "<script>window.open('Card.php','_self')</script>";
                $_SESSION['warning'] = "Something Went Wrong!!.";
            }
        }
    }

    // // Handle Post Selected
    if (isset($_POST['postSelected'])) {
        foreach ($selected_ids as $id) {

            $query = mysqli_query($con, "UPDATE `cards` SET `status` = 'Posted' WHERE `id` = $id");
            if($query){
                echo "<script>window.open('Card.php','_self')</script>";
                $_SESSION['success'] = "Data Posted Successfully.";
            }else{
                echo "<script>window.open('Card.php','_self')</script>";
                $_SESSION['warning'] = "Something Went Wrong!!.";
            }
        }
    }

    // // Handle Unpost Selected
    if (isset($_POST['unpostSelected'])) {
        foreach ($selected_ids as $id) {

            $query = mysqli_query($con, "UPDATE `cards` SET `status` = 'Unposted' WHERE `id` = $id");
            if($query){
                echo "<script>window.open('Card.php','_self')</script>";
                $_SESSION['success'] = "Data Unposted Successfully.";
            }else{
                echo "<script>window.open('Card.php','_self')</script>";
                $_SESSION['warning'] = "Something Went Wrong!!.";
            }
        }
    }

    // // Handle Delete Selected
    if (isset($_POST['deleteSelected'])) {
        foreach ($selected_ids as $id) {

            $query = mysqli_query($con, "DELETE FROM `cards` WHERE `id` = $id");
            if($query){
                echo "<script>window.open('Card.php','_self')</script>";
                $_SESSION['success'] = "Data Deleted Successfully.";
            }else{
                echo "<script>window.open('Card.php','_self')</script>";
                $_SESSION['warning'] = "Something Went Wrong!!.";
            }
        }
    }
} 


// images edit code ==================================
if (isset($_POST['cardImgBtn'])) {
    $card_id = $_POST['card_id'];
    
    // Check if card_id exists in the database
    $checkCardId = mysqli_query($con, "SELECT * FROM `card_images` WHERE `card_id` = '$card_id'");
    
    if (mysqli_num_rows($checkCardId) > 0) {
        // Fetch existing images to delete them
        $existingImages = mysqli_fetch_assoc($checkCardId);
        $existingImagesArray = json_decode($existingImages['image'], true);
        
        // Delete images from the folder
        foreach ($existingImagesArray as $image) {
            $filePath = 'cardImages/' . $image;
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
        move_uploaded_file($tmpName, 'cardImages/' . $newImageName);
        $filesArray[] = $newImageName;
    }

    $filesArray = json_encode($filesArray);

    // Insert new images into the database
    $uploadImages = mysqli_query($con, "INSERT INTO `card_images`(`card_id`, `image`) VALUES ('$card_id', '$filesArray')");

    if ($uploadImages) {
        echo "<script>window.open('images.php', '_self')</script>";
        $_SESSION['success'] = "Images Uploaded Successfully.";
    } else {
        echo "<script>window.open('images.php', '_self')</script>";
        $_SESSION['warning'] = "Something Went Wrong!!.";
    }
}
if (isset($_POST['deleteSelectedImage'])) {
    if (isset($_POST['selected']) && !empty($_POST['selected'])) {
        $selected_ids = $_POST['selected'];

        foreach ($selected_ids as $id) {
            // Fetch the image path from the database before deletion
            $imageQuery = mysqli_query($con, "SELECT `image` FROM `card_images` WHERE `id` = $id");
            
            if (mysqli_num_rows($imageQuery) > 0) {
                $imageData = mysqli_fetch_assoc($imageQuery);
                $imagesArray = json_decode($imageData['image'], true); // Decode the JSON array

                // Delete each image from the folder
                foreach ($imagesArray as $image) {
                    $filePath = 'cardImages/' . $image;
                    if (file_exists($filePath)) {
                        unlink($filePath); // Delete the file
                    }
                }

                // Now delete the record from the database
                $deleteQuery = mysqli_query($con, "DELETE FROM `card_images` WHERE `id` = $id");
                if ($deleteQuery) {
                    $_SESSION['success'] = "Images Deleted Successfully.";
                } else {
                    $_SESSION['warning'] = "Error deleting image record.";
                }
            } else {
                $_SESSION['warning'] = "No image found with this ID.";
            }
        }
        echo "<script>window.open('images.php', '_self')</script>";
    } else {
        $_SESSION['warning'] = "No images selected.";
    }
}




// advert edit codes====================================
if(isset($_POST['AdvertBtn'])){
    $compound = $_POST['compound'];
    $publishedDate = date("Y-m-d", strtotime($_POST['publishedDate']));
    $endDate = date("Y-m-d", strtotime($_POST['endDate']));

    $currentDate = date("Y-m-d"); // Get the current date

    $status = "Posted";

    $video = $_FILES['video']['name'];
    $temp_name = $_FILES['video']['tmp_name'];

    // Ensure directory exists before uploading
    if (!is_dir("AdvertVideos")) {
        mkdir("AdvertVideos", 0755, true);
    }

    $Advert = mysqli_query($con, "INSERT INTO `advert`(`compound`, `video`, `published_date`, `end_date`, `status`) 
    VALUES ('$compound','$video','$publishedDate','$endDate','$status')");

    if ($Advert) {
        move_uploaded_file($temp_name, "AdvertVideos/$video");
        echo "<script>window.open('advert.php', '_self')</script>";
        $_SESSION['success'] = "Advert Added Successfully.";
    } else {
        echo "<script>window.open('advert.php', '_self')</script>";
        $_SESSION['warning'] = "Something Went Wrong!!.";
    }
}
if(isset($_POST['postSelectedAdert'])){
    if (isset($_POST['selected']) && !empty($_POST['selected'])) {
        $selected_ids = $_POST['selected'];

        $current = date("Y-m-d", strtotime("+7 days"));

        foreach ($selected_ids as $id) {

            $deleteQuery = mysqli_query($con, "UPDATE `advert` SET `end_date`='$current',`status`='Posted' WHERE `id` = $id");
            if ($deleteQuery) {
                echo "<script>window.open('advert.php','_self')</script>";
                $_SESSION['success'] = "Advert Posted from User.";
            } else {
                echo "<script>window.open('advert.php','_self')</script>";
                $_SESSION['warning'] = "Something Went wrong!";
            }
        }
    } else {
        echo "<script>window.open('advert.php','_self')</script>";
        $_SESSION['warning'] = "No Video selected.";
    }
}
if(isset($_POST['unpostSelectedAdert'])){
    if (isset($_POST['selected']) && !empty($_POST['selected'])) {
        $selected_ids = $_POST['selected'];

        $current = date("Y-m-d", strtotime("-2 days"));

        foreach ($selected_ids as $id) {

            $deleteQuery = mysqli_query($con, "UPDATE `advert` SET `end_date`='$current',`status`='Unposted' WHERE `id` = $id");
            if ($deleteQuery) {
                echo "<script>window.open('advert.php','_self')</script>";
                $_SESSION['success'] = "Advert Unposted from User.";
            } else {
                echo "<script>window.open('advert.php','_self')</script>";
                $_SESSION['warning'] = "Something Went wrong!";
            }
        }
    } else {
        echo "<script>window.open('advert.php','_self')</script>";
        $_SESSION['warning'] = "No Video selected.";
    }
}
if(isset($_POST['deleteSelectedAdert'])){
    if (isset($_POST['selected']) && !empty($_POST['selected'])) {
        $selected_ids = $_POST['selected'];

        foreach ($selected_ids as $id) {
            // Fetch the image path from the database before deletion
            $VideoQuery = mysqli_query($con, "SELECT `video` FROM `advert` WHERE `id` = $id");
            
            if (mysqli_num_rows($VideoQuery) > 0) {

                $row = mysqli_fetch_assoc($VideoQuery);
                $videos = $row['video'];

                $filePath = 'AdvertVideos/' . $videos;
                if (file_exists($filePath)) {
                    unlink($filePath); // Delete the file
                }

                // Now delete the record from the database
                $deleteQuery = mysqli_query($con, "DELETE FROM `advert` WHERE `id` = $id");
                if ($deleteQuery) {
                    echo "<script>window.open('advert.php','_self')</script>";
                    $_SESSION['success'] = "Advert Deleted Successfully.";
                } else {
                    echo "<script>window.open('advert.php','_self')</script>";
                    $_SESSION['warning'] = "Error deleting Video record.";
                }
            } else {
                echo "<script>window.open('advert.php','_self')</script>";
                $_SESSION['warning'] = "No Video found with this ID.";
            }
        }
        echo "<script>window.open('advert.php', '_self')</script>";
    } else {
        echo "<script>window.open('advert.php','_self')</script>";
        $_SESSION['warning'] = "No Video selected.";
    }
}


//compound edit code ===================================
if(isset($_POST['cardCompBtn'])){
    $name = $_POST['name'];
    $lcontact = $_POST['lcontact'];
    $ccontact = $_POST['ccontact'];
    $location = $_POST['location'];

    $compound = mysqli_query($con, "INSERT INTO `compound`(`name`, `l_contact`, `c_contact`, `location`) 
    VALUES ('$name','$lcontact','$ccontact','$location')");

    if ($compound) {
        echo "<script>window.open('Compound.php', '_self')</script>";
        $_SESSION['success'] = "Compound Added Successfully.";
    } else {
        echo "<script>window.open('Compound.php', '_self')</script>";
        $_SESSION['warning'] = "Something Went Wrong!!.";
    }
}
if(isset($_POST['editSelectedComp'])){
    if (isset($_POST['selected']) && !empty($_POST['selected'])) {
        $selected_ids = $_POST['selected'];

        foreach ($selected_ids as $id) {

            $name = $_POST['name'][$id]; 
            $lcontact = $_POST['lcontact'][$id];  
            $ccontact = $_POST['ccontact'][$id];    
            $location = $_POST['location'][$id];

            $Comp = mysqli_query($con, " UPDATE `compound` SET `name`='$name',`l_contact`='$lcontact',
            `c_contact`='$ccontact',`location`='$location' WHERE `id` = $id");
            if($Comp){
                echo "<script>window.open('Compound.php','_self')</script>";
                $_SESSION['success'] = "Data Updated Successfully.";
            }else{
                echo "<script>window.open('Compound.php','_self')</script>";
                $_SESSION['warning'] = "Something Went Wrong!!.";
            }
        }
    }else {
        echo "<script>window.open('Compound.php','_self')</script>";
        $_SESSION['warning'] = "No images selected.";
    }
}
if(isset($_POST['deleteSelectedComp'])){
    if (isset($_POST['selected']) && !empty($_POST['selected'])) {
        $selected_ids = $_POST['selected'];

        foreach ($selected_ids as $id) {

            $query = mysqli_query($con, "DELETE FROM `compound` WHERE `id` = $id");
            if($query){
                echo "<script>window.open('Compound.php','_self')</script>";
                $_SESSION['success'] = "Data Deleted Successfully.";
            }else{
                echo "<script>window.open('Compound.php','_self')</script>";
                $_SESSION['warning'] = "Something Went Wrong!!.";
            }
        }
    }else {
        echo "<script>window.open('Compound.php','_self')</script>";
        $_SESSION['warning'] = "No images selected.";
    }
}


// comment edit code ===================================
if(isset($_POST['postSelectedCmment'])){
    if (isset($_POST['selected']) && !empty($_POST['selected'])) {
        $selected_ids = $_POST['selected'];

        foreach ($selected_ids as $id) {

            $CommentQuery = mysqli_query($con, "UPDATE `comments` SET `status`='Posted' WHERE `id` = $id");
            if ($CommentQuery) {
                echo "<script>window.open('index.php','_self')</script>";
                $_SESSION['success'] = "Comment Posted To Users.";
            } else {
                echo "<script>window.open('index.php','_self')</script>";
                $_SESSION['warning'] = "Something Went wrong!";
            }
        }
    } else {
        echo "<script>window.open('index.php','_self')</script>";
        $_SESSION['warning'] = "No Column selected.";
    }
}
if(isset($_POST['unpostSelectedComment'])){
    if (isset($_POST['selected']) && !empty($_POST['selected'])) {
        $selected_ids = $_POST['selected'];

        foreach ($selected_ids as $id) {

            $CommentQuery = mysqli_query($con, "UPDATE `comments` SET `status`='Unposted' WHERE `id` = $id");
            if ($CommentQuery) {
                echo "<script>window.open('index.php','_self')</script>";
                $_SESSION['success'] = "Comment Posted To Users.";
            } else {
                echo "<script>window.open('index.php','_self')</script>";
                $_SESSION['warning'] = "Something Went wrong!";
            }
        }
    } else {
        echo "<script>window.open('index.php','_self')</script>";
        $_SESSION['warning'] = "No Column selected.";
    }
}


// userRequest code ===================================
if(isset($_POST['SelectedRequestPaid'])){
    if (isset($_POST['selected']) && !empty($_POST['selected'])) {
        $selected_ids = $_POST['selected'];

        foreach ($selected_ids as $id) {

            $CommentQuery = mysqli_query($con, "UPDATE `userrequest` SET `status`='Paid' WHERE `id` = $id");
            if ($CommentQuery) {
                echo "<script>window.open('index.php','_self')</script>";
                $_SESSION['success'] = "User Request Approved.";
            } else {
                echo "<script>window.open('index.php','_self')</script>";
                $_SESSION['warning'] = "Something Went wrong!";
            }
        }
    } else {
        echo "<script>window.open('index.php','_self')</script>";
        $_SESSION['warning'] = "No Column selected.";
    }
}
if(isset($_POST['SelectedRequestUnpiad'])){
    if (isset($_POST['selected']) && !empty($_POST['selected'])) {
        $selected_ids = $_POST['selected'];

        foreach ($selected_ids as $id) {

            $CommentQuery = mysqli_query($con, "UPDATE `userrequest` SET `status`='Unpiad' WHERE `id` = $id");
            if ($CommentQuery) {
                echo "<script>window.open('index.php','_self')</script>";
                $_SESSION['success'] = "User Request Denied.";
            } else {
                echo "<script>window.open('index.php','_self')</script>";
                $_SESSION['warning'] = "Something Went wrong!";
            }
        }
    } else {
        echo "<script>window.open('index.php','_self')</script>";
        $_SESSION['warning'] = "No Column selected.";
    }
}





?>