<?php

require_once 'models/database.php';
require_once 'models/faculty.php';

$action = htmlspecialchars(filter_input(INPUT_POST, "action"));

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_FLOAT);
$name = htmlspecialchars(filter_input(INPUT_POST, "name"));
$email = htmlspecialchars(filter_input(INPUT_POST, "email"));

if ($action == "insert_or_update" && $id != 0  && $name != ""  && $email != "") {
    $insert_or_update = filter_input(INPUT_POST, 'insert_or_update');
    
    $faculty = new Faculty($id, $name, $email);
    
    if($insert_or_update == "insert"){
        insert_faculty($faculty);
    } else if($insert_or_update == "update"){
        update_faculty($faculty);
    }
    
    header("Location: faculty.php");
} else if ($action == "delete" && $id != "") {
    $faculty = new Faculty($id, "", "");
    delete_faculty($faculty);
    header("Location: faculty.php");
} else if ($action != "") {
    $error_message = "Missing id, name, or email";
}

$faculties = list_faculties();

include('views/faculty.php');