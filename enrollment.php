<?php

require_once 'models/database.php';
require_once 'models/enrollment.php';
require_once 'models/students.php';
require_once 'models/section.php';

$action = htmlspecialchars(filter_input(INPUT_POST, "action"));

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_FLOAT);
$student_id = filter_input(INPUT_POST, "student_id", FILTER_VALIDATE_FLOAT);
$section_id = filter_input(INPUT_POST, "section_id", FILTER_VALIDATE_FLOAT);
$grade = htmlspecialchars(filter_input(INPUT_POST, "grade"));

if ($action == "insert_or_update" && $id != 0  && $student_id != 0  && $section_id != 0  && $grade != "") {
    $insert_or_update = filter_input(INPUT_POST, 'insert_or_update');
    
    $enrollment = new Enrollment($id, $student_id, $section_id, $grade);
    
    if($insert_or_update == "insert"){
        insert_enrollment($enrollment);
    } else if($insert_or_update == "update"){
        update_enrollment($enrollment);
    }
    
    header("Location: enrollment.php");
} else if ($action == "delete" && $id != "") {
    $enrollment = new Enrollment($id, 0, 0, "");
    delete_enrollment($enrollment);
    header("Location: enrollment.php");
} else if ($action != "") {
    $error_message = "Missing id, student_id, or section_id";
}

$students = list_students();
$sections = list_sections();
$enrollments = list_enrollments();

include('views/enrollment.php');