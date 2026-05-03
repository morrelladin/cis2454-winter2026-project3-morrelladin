<?php

class Store {
    private $id, $name, $created_at;
    
    public function __construct($id, $name, $created_at){
        $this->set_id($id);
        $this->set_name($name);
        $this->set_created_at($created_at);
    }
    
    public function get_id() {
        return $this->id;
    }
    
    public function get_name() {
        return $this->name;
    }
    
    public function get_created_at() {
        return $this->created_at;
    }
    
    public function set_id($id) {
        $this->id = $id;
    }
    
    public function set_name($name) {
        $this->name = $name;
    }
    
    public function set_created_at($created_at) {
        $this->created_at = $created_at;
    }
}

function list_stores(){
       global $database;
       
       $query = 'SELECT id, name, created_at FROM stores';
       
       $statement = $database->prepare($query);
       
       $statement->execute();
       
       $stores = $statement->fetchAll();
       
       $statement->closeCursor();
       
       $stores_array = array();
       
       foreach ($stores as $store) {
           $stores_array[] = new Store($store['id'], $store['name'],
                   $store['created_at']);
       }
       
       return $stores_array;
}

function insert_store($store){
    global $database;
    
    $query = "INSERT INTO stores (name) "
            . " VALUES (:name)";
    
    $statement = $database->prepare($query);
    $statement->bindValue(":name", $store->get_name());
    
    $statement->execute();
    
    $statement->closeCursor();
}

function update_store($store){
    global $database;
    
    $query = "UPDATE stores SET name = :name "
            . " WHERE id = :id";
    
    $statement = $database->prepare($query);
    $statement->bindValue(":id", $store->get_id());
    $statement->bindValue(":name", $store->get_name());
    
    $statement->execute();
    
    $statement->closeCursor();
}

function delete_store($store){
    global $database;
    
    $query = "DELETE from stores "
            . " where id = :id";
    
    $statement = $database->prepare($query);
    $statement->bindValue(":id", $store->get_id());
    
    $statement->execute();
    
    $statement->closeCursor();
}