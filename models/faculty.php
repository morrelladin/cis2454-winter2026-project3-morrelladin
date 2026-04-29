<?php

class Faculty {
    private $id, $name, $email;
    
    public function __construct($id, $name, $email){
        $this->set_id($id);
        $this->set_name($name);
        $this->set_email($email);
    }
    
    public function get_id() {
        return $this->id;
    }
    
    public function get_name() {
        return $this->name;
    }
    
    public function get_email() {
        return $this->email;
    }
    
    public function set_id($id) {
        $this->id = $id;
    }
    
    public function set_name($name) {
        $this->name = $name;
    }
    
    public function set_email($email) {
        $this->email = $email;
    }
}

function list_faculties(){
       global $database;
       
       $query = 'SELECT id, name, email FROM faculty';
       
       $statement = $database->prepare($query);
       
       $statement->execute();
       
       $faculties = $statement->fetchAll();
       
       $statement->closeCursor();
       
       $faculties_array = array();
       
       foreach ($faculties as $faculty) {
           $faculties_array[] = new Faculty($faculty['id'], $faculty['name'],
                   $faculty['email']);
       }
       
       return $faculties_array;
}

function insert_faculty($faculty){
    global $database;
    
    $query = "INSERT INTO faculty (id, name, email) "
            . " VALUES (:id, :name, :email)";
    
    $statement = $database->prepare($query);
    $statement->bindValue(":id", $faculty->get_id());
    $statement->bindValue(":name", $faculty->get_name());
    $statement->bindValue(":email", $faculty->get_email());
    
    $statement->execute();
    
    $statement->closeCursor();
}

function update_faculty($faculty){
    global $database;
    
    $query = "update faculty set name = :name, email = :email "
            . " where id = :id";
    
    $statement = $database->prepare($query);
    $statement->bindValue(":id", $faculty->get_id());
    $statement->bindValue(":name", $faculty->get_name());
    $statement->bindValue(":email", $faculty->get_email());
    
    $statement->execute();
    
    $statement->closeCursor();
}

function delete_faculty($faculty){
    global $database;
    
    $query = "delete from faculty "
            . " where id = :id";
    
    $statement = $database->prepare($query);
    $statement->bindValue(":id", $faculty->get_id());
    
    $statement->execute();
    
    $statement->closeCursor();
}