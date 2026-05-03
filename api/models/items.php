<?php

class Item {
    private $id, $store_id, $name, $quantity, $checked, $created_at;
    
    public function __construct($id, $store_id, $name, $quantity, $checked, $created_at){
        $this->set_id($id);
        $this->set_store_id($store_id);
        $this->set_name($name);
        $this->set_quantity($quantity);
        $this->set_checked($checked);
        $this->set_created_at($created_at);
    }
    
    public function get_id() {
        return $this->id;
    }
    
    public function get_store_id() {
        return $this->store_id;
    }
    
    public function get_name() {
        return $this->name;
    }
    
    public function get_quantity() {
        return $this->quantity;
    }
    
    public function get_checked() {
        return $this->checked;
    }
    
    public function get_created_at() {
        return $this->created_at;
    }
    
    public function set_id($id) {
        $this->id = $id;
    }
    
    public function set_store_id($store_id) {
        $this->store_id = $store_id;
    }
    
    public function set_name($name) {
        $this->name = $name;
    }
    
    public function set_quantity($quantity) {
        $this->quantity = $quantity;
    }
    
    public function set_checked($checked) {
        $this->checked = $checked;
    }
    
    public function set_created_at($created_at) {
        $this->created_at = $created_at;
    }
}

function list_items_from_store($store_id) {
    global $database;
    
    $query = "SELECT * FROM items WHERE store_id = :store_id";
    
    $statement = $database->prepare($query);
    
    $statement->bindValue(':store_id', $store_id);
    
    $statement->execute();
    
    $rows = $statement->fetchAll();
    
    $statement->closeCursor();
    
    $items = [];
    foreach ($rows as $row) {
        $items[] = new Item(
            $row['id'],
            $row['store_id'],
            $row['name'],
            $row['quantity'],
            $row['checked'],
            $row['created_at']
        );
    }

    return $items;
}

function list_item(){
       global $database;
       
       $query = 'SELECT id, store_id, name, quantity, checked, created_at FROM items';
       
       $statement = $database->prepare($query);
       
       $statement->execute();
       
       $items = $statement->fetchAll();
       
       $statement->closeCursor();
       
       $items_array = array();
       
       foreach ($items as $item) {
           $items_array[] = new Item($item['id'], $item['store_id'],
                   $item['name'], $item['quantity'], $item['checked'], $item['created_at']);
       }
       
       return $items_array;
}

function insert_item($item){
    global $database;
    
    $query = "INSERT INTO items (store_id, name, quantity, checked) "
            . " VALUES (:store_id, :name, :quantity, :checked)";
    
    $statement = $database->prepare($query);
    $statement->bindValue(":store_id", $item->get_store_id());
    $statement->bindValue(":name", $item->get_name());
    $statement->bindValue(":quantity", $item->get_quantity());
    $statement->bindValue(":checked", $item->get_checked());
    
    $statement->execute();
    
    $statement->closeCursor();
}

function update_item($item){
    global $database;
    
    $query = "UPDATE items SET name = :name, quantity = :quantity, checked = :checked "
            . " WHERE id = :id";
    
    $statement = $database->prepare($query);
    $statement->bindValue(":id", $item->get_id());
    $statement->bindValue(":name", $item->get_name());
    $statement->bindValue(":quantity", $item->get_quantity());
    $statement->bindValue(":checked", $item->get_checked());
    
    $statement->execute();
    
    $statement->closeCursor();
}

function delete_item($item){
    global $database;
    
    $query = "DELETE FROM items "
            . " WHERE id = :id";
    
    $statement = $database->prepare($query);
    $statement->bindValue(":id", $item->get_id());
    
    $statement->execute();
    
    $statement->closeCursor();
}