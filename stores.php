<?php

require_once 'models/database.php';
require_once 'models/stores.php';

$action = htmlspecialchars(filter_input(INPUT_POST, "action"));

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$name = filter_input(INPUT_POST, "name", FILTER_VALIDATE_FLOAT);

if ($action == "insert_or_update" && $id != 0 && $name != "") {
    
    $insert_or_update = filter_input(INPUT_POST, 'insert_or_update');
    
    $store = new Store($id, $name, null);
    
    if($insert_or_update == "insert"){
        insert_store($store);
    } else if($insert_or_update == "update"){
        update_store($store);
    }
    
    header("Location: stores.php");
    
} else if ($action == "delete" && $id != "") {
    
    $store = new Store($id, 0, "");
    
    delete_store($store);
    header("Location: stores.php");
    
} else if ($action != "") {
    
    $error_message = "Missing required fields";
    
}

$stores = list_stores();

//include('views/enrollment.php');