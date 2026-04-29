<?php

class Section {
    private $id, $course_code, $faculty_id, $semester;
    
    public function __construct($id, $course_code, $faculty_id, $semester){
        $this->set_id($id);
        $this->set_course_code($course_code);
        $this->set_faculty_id($faculty_id);
        $this->set_semester($semester);
    }
    
    public function get_id() {
        return $this->id;
    }
    
    public function get_course_code() {
        return $this->course_code;
    }
    
    public function get_faculty_id() {
        return $this->faculty_id;
    }
    
    public function get_semester() {
        return $this->semester;
    }
    
    public function set_id($id) {
        $this->id = $id;
    }
    
    public function set_course_code($course_code) {
        $this->course_code = $course_code;
    }
    
    public function set_faculty_id($faculty_id) {
        $this->faculty_id = $faculty_id;
    }
    
    public function set_semester($semester) {
        $this->semester = $semester;
    }
}

function list_sections(){
       global $database;
       
       $query = 'SELECT id, course_code, faculty_id, semester FROM section';
       
       $statement = $database->prepare($query);
       
       $statement->execute();
       
       $sections = $statement->fetchAll();
       
       $statement->closeCursor();
       
       $sections_array = array();
       
       foreach ($sections as $section) {
           $sections_array[] = new Section($section['id'], $section['course_code'],
                   $section['faculty_id'], $section['semester']);
       }
       
       return $sections_array;
}

function insert_section($section){
    global $database;
    
    $query = "INSERT INTO section (id, course_code, faculty_id, semester) "
            . " VALUES (:id, :course_code, :faculty_id, :semester)";
    
    $statement = $database->prepare($query);
    $statement->bindValue(":id", $section->get_id());
    $statement->bindValue(":course_code", $section->get_course_code());
    $statement->bindValue(":faculty_id", $section->get_faculty_id());
    $statement->bindValue(":semester", $section->get_semester());
    
    $statement->execute();
    
    $statement->closeCursor();
}

function update_section($section){
    global $database;
    
    $query = "update section set course_code = :course_code, faculty_id = :faculty_id, semester = :semester "
            . " where id = :id";
    
    $statement = $database->prepare($query);
    $statement->bindValue(":id", $section->get_id());
    $statement->bindValue(":course_code", $section->get_course_code());
    $statement->bindValue(":faculty_id", $section->get_faculty_id());
    $statement->bindValue(":semester", $section->get_semester());
    
    $statement->execute();
    
    $statement->closeCursor();
}

function delete_section($section){
    global $database;
    
    $query = "delete from section "
            . " where id = :id";
    
    $statement = $database->prepare($query);
    $statement->bindValue(":id", $section->get_id());
    
    $statement->execute();
    
    $statement->closeCursor();
}