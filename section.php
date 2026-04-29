<?php

require_once 'models/database.php';
require_once 'models/section.php';
require_once 'models/course.php';
require_once 'models/faculty.php';

$action = htmlspecialchars(filter_input(INPUT_POST, "action"));

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_FLOAT);
$course_code = htmlspecialchars(filter_input(INPUT_POST, "course_code"));
$faculty_id = filter_input(INPUT_POST, "faculty_id", FILTER_VALIDATE_FLOAT);
$semester = htmlspecialchars(filter_input(INPUT_POST, "semester"));

if ($action == "insert_or_update" && $id != ""  && $course_code != ""  && $faculty_id != ""  && $semester != 0) {
    $insert_or_update = filter_input(INPUT_POST, 'insert_or_update');
    
    $section = new Section($id, $course_code, $faculty_id, $semester);
    
    if($insert_or_update == "insert"){
        insert_section($section);
    } else if($insert_or_update == "update"){
        update_section($section);
    }
    
    header("Location: section.php");
} else if ($action == "delete" && $id != "") {
    $section = new Section($id, "", "", 0);
    delete_section($section);
    header("Location: section.php");
} else if ($action != "") {
    $error_message = "Missing id, course_code, or faculty_id";
}

$faculties = list_faculties();
$courses = list_courses();
$sections = list_sections();

include('views/section.php');