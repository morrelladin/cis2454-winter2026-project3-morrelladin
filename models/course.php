<?php

class Course {
    private $code, $name, $description, $credits;
    
    public function __construct($code, $name, $description, $credits){
        $this->set_code($code);
        $this->set_name($name);
        $this->set_description($description);
        $this->set_credits($credits);
    }
    
    public function get_code() {
        return $this->code;
    }
    
    public function get_name() {
        return $this->name;
    }
    
    public function get_description() {
        return $this->description;
    }
    
    public function get_credits() {
        return $this->credits;
    }
    
    public function set_code($code) {
        $this->code = $code;
    }
    
    public function set_name($name) {
        $this->name = $name;
    }
    
    public function set_description($description) {
        $this->description = $description;
    }
    
    public function set_credits($credits) {
        $this->credits = $credits;
    }
}

function list_courses(){
       global $database;
       
       $query = 'SELECT code, name, description, credits FROM course';
       
       $statement = $database->prepare($query);
       
       $statement->execute();
       
       $courses = $statement->fetchAll();
       
       $statement->closeCursor();
       
       $courses_array = array();
       
       foreach ($courses as $course) {
           $courses_array[] = new Course($course['code'], $course['name'],
                   $course['description'], $course['credits']);
       }
       
       return $courses_array;
}

function insert_course($course){
    global $database;
    
    $query = "INSERT INTO course (code, name, description, credits) "
            . " VALUES (:code, :name, :description, :credits)";
    
    $statement = $database->prepare($query);
    $statement->bindValue(":code", $course->get_code());
    $statement->bindValue(":name", $course->get_name());
    $statement->bindValue(":description", $course->get_description());
    $statement->bindValue(":credits", $course->get_credits());
    
    $statement->execute();
    
    $statement->closeCursor();
}

function update_course($course){
    global $database;
    
    $query = "update course set name = :name, description = :description, credits = :credits "
            . " where code = :code";
    
    $statement = $database->prepare($query);
    $statement->bindValue(":code", $course->get_code());
    $statement->bindValue(":name", $course->get_name());
    $statement->bindValue(":description", $course->get_description());
    $statement->bindValue(":credits", $course->get_credits());
    
    $statement->execute();
    
    $statement->closeCursor();
}

function delete_course($course){
    global $database;
    
    $query = "delete from course "
            . " where code = :code";
    
    $statement = $database->prepare($query);
    $statement->bindValue(":code", $course->get_code());
    
    $statement->execute();
    
    $statement->closeCursor();
}