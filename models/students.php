<?php

class Student {
    private $id, $name, $major;
    
    public function __construct($id, $name, $major){
        $this->set_id($id);
        $this->set_name($name);
        $this->set_major($major);
    }
    
    public function get_id() {
        return $this->id;
    }
    
    public function get_name() {
        return $this->name;
    }
    
    public function get_major() {
        return $this->major;
    }
    
    public function set_id($id) {
        $this->id = $id;
    }
    
    public function set_name($name) {
        $this->name = $name;
    }
    
    public function set_major($major) {
        $this->major = $major;
    }
}

function list_students(){
       global $database;
       
       $query = 'SELECT id, name, major FROM students';
       
       $statement = $database->prepare($query);
       
       $statement->execute();
       
       $students = $statement->fetchAll();
       
       $statement->closeCursor();
       
       $students_array = array();
       
       foreach ($students as $student) {
           $students_array[] = new Student($student['id'], $student['name'],
                   $student['major']);
       }
       
       return $students_array;
}

function insert_student($student){
    global $database;
    
    $query = "INSERT INTO students (id, name, major) "
            . " VALUES (:id, :name, :major)";
    
    $statement = $database->prepare($query);
    $statement->bindValue(":id", $student->get_id());
    $statement->bindValue(":name", $student->get_name());
    $statement->bindValue(":major", $student->get_major());
    
    $statement->execute();
    
    $statement->closeCursor();
}

function update_student($student){
    global $database;
    
    $query = "update students set name = :name, major = :major "
            . " where id = :id";
    
    $statement = $database->prepare($query);
    $statement->bindValue(":id", $student->get_id());
    $statement->bindValue(":name", $student->get_name());
    $statement->bindValue(":major", $student->get_major());
    
    $statement->execute();
    
    $statement->closeCursor();
}

function delete_student($student){
    global $database;
    
    $query = "delete from students "
            . " where id = :id";
    
    $statement = $database->prepare($query);
    $statement->bindValue(":id", $student->get_id());
    
    $statement->execute();
    
    $statement->closeCursor();
}