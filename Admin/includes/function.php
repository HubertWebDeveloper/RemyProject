<?php

$con = mysqli_connect("localhost","root","","remydatabase");

session_start(); 


// for input field validation
function validate($inputData){

    global $con;
    $validateData = mysqli_real_escape_string($con, $inputData);
    return trim($validateData);
}

// redirect from 1 page to another page
function redirect($url, $status){
    $_SESSION['status'] = $status;
    header('Location: '.$url);
    exit(0);
}

// Display message after process
function alertMessage(){
    if(isset($_SESSION['success'])){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
              '.$_SESSION['success'].'
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            unset($_SESSION['success']);
    }else if(isset($_SESSION['warning'])){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            '.$_SESSION['warning'].'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        unset($_SESSION['warning']);
    }else if(isset($_SESSION['danger'])){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            '.$_SESSION['danger'].'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        unset($_SESSION['danger']);
    }
    
}

//Insert new Data into Database
function insert($tableName, $data){
    global $con;

    $table = validate($tableName);

    $columns = array_keys($data);
    $values = array_values($data);

    $finalColumns = implode(',', $columns);
    $finalValues = "'".implode("', '", $values)."'";

    $query = mysqli_query($con, "INSERT INTO $table ($finalColumns) VALUES ($finalValues)");
    return $query;
}

// Updating Data
function update($tableName, $id, $data){
    global $con;

    $table = validate($tableName);
    $id = validate($id);

    $updateDataString = "";

    foreach($data as $column => $value){
        $updateDataString .= $column.'='."'$value',";
    }
    $finalUpdateData = substr(trim($updateDataString),0,-1);

    $query = mysqli_query($con, "UPDATE $table SET $finalUpdateData WHERE id='$id'");
    return $query;
}

// Get All Data from Database
function getAll($tableName, $status = NULL){
    global $con;

    $table = validate($tableName);
    $status = validate($status);

    if($status == 'status'){
        $query = mysqli_query($con, "SELECT * FROM $table WHERE status='0'");
    }else{
        $query = mysqli_query($con, "SELECT * FROM $table");
    }
    return $query;
}

// Getting data by id
function getById($tableName, $id){
    global $con;

    $table = validate($tableName);
    $id = validate($id);

    $query = mysqli_query($con, "SELECT * FROM $table WHERE id='$id' LIMIT 1");
    if($query){
       if(mysqli_num_rows($query) == 1){
           $row = mysqli_fetch_assoc($query);

           $response = [
            'status' => 200,
            'data' => $row,
            'message' => 'Data Found'
            ];
            return $response;
       }else{
           $response = [
               'status' => 404,
               'message' => 'Data Not Found'
           ];
           return $response;
       }
    }else{
        $response = [
            'status' => 500,
            'message' => 'Something Went Wrong!'
        ];
        return $response;
    }
}

//Delete Data from database
function delete($tableName, $id){
    global $con;

    $table = validate($tableName);
    $id = validate($id);

    $query = mysqli_query($con, "DELETE FROM $table WHERE id='$id' LIMIT 1");
    return $query;
}

// check paraments by id
function checkParamId($type){
   if(isset($_GET[$type])){
      if($_GET[$type] != ''){
         return $_GET[$type];
      }else{
        return 'No ID Found';
      }
   }else{
    return 'No ID Given';
   }
}

// log out function
function logoutSession(){
    unset($_SESSION['LoggedIn']);
    unset($_SESSION['LoggedInUser']);
}

//json response
function jsonResponse($status, $status_type, $message){

    $response = [
        'status' => $status,
        'status_type' => $status_type,
        'message' => $message
    ];
    echo json_encode($response);
    return;
}

?>