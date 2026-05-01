<?php

require_once 'models/database.php';
require_once 'models/items.php';

$action = htmlspecialchars(filter_input(INPUT_POST, "action"));

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$store_id = filter_input(INPUT_POST, "store_id", FILTER_VALIDATE_INT);
$name = htmlspecialchars(filter_input(INPUT_POST, "name"));
$quantity = filter_input(INPUT_POST, "quantity", FILTER_VALIDATE_INT);
$checked = filter_input(INPUT_POST, "checked", FILTER_VALIDATE_INT);

if ($action == "insert_or_update" && $id != 0  && $store_id != 0 && $name != "" && $quantity != 0 && $checked != 0) {
    $insert_or_update = filter_input(INPUT_POST, 'insert_or_update');
    
    $item = new Item($id, $store_id, $name, $quantity, $checked, null);
    
    if($insert_or_update == "insert"){
        insert_item($item);
    } else if($insert_or_update == "update"){
        update_item($item);
    }
    
    header("Location: items.php");
    
} else if ($action == "delete" && $id != 0) {
    
    $item = new Item($id, 0, "", 0, 0, "");
    
    delete_item($item);
    header("Location: items.php");
    
} else if ($action != "") {
    
    $error_message = "Missing required fields";
    
}

$items = list_items();

//include('views/course.php');