<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once 'models/database.php';
require_once 'models/stores.php';
require_once 'models/items.php';

$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);

$segments = explode('/', trim($path, '/'));

$apiIndex = array_search('api', $segments);

$resource = $segments[$apiIndex + 1] ?? null;

$id = (isset($segments[$apiIndex + 2]) && is_numeric($segments[$apiIndex + 2]))
    ? (int)$segments[$apiIndex + 2]
    : null;

$sub = $segments[$apiIndex + 3] ?? null;
$method = $_SERVER['REQUEST_METHOD'];
  
// api/stores

if($resource === 'stores' && $sub === null){
    if ($method === 'GET') {
    
        if ($id === null) {
            $stores = list_stores();
            $result = [];

            foreach ($stores as $store){
                $result[] = [
                    'id' => $store->get_id(),
                    'name' => $store->get_name(),
                    'created_at' => $store->get_created_at(),
                ];
            }

            echo json_encode($result);
        }

        exit;

    } else if ($method === 'POST') {

        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['name'])){
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            exit;
        }

        $store = new Store(0, $data['name'], null);
        insert_store($store);

        echo json_encode(['message' => 'Store created']);
        exit;

    } else if ($method === 'DELETE') {

        if ($id === null){
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            exit;
        }

        $store = new Store($id, '', '');
        delete_store($store);

        echo json_encode(['message' => 'Store deleted']);
        exit;

    } else if ($method === 'PUT') {

        $data = json_decode(file_get_contents("php://input"), true);

        if ($id === null || !isset($data['name'])){
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            exit;
        }

        $store = new Store($id, $data['name'], null);
        update_store($store);

        echo json_encode(['message' => 'Store updated']);
        exit;

    }
    
// api/stores/{id}/items
} else if($resource === 'stores' && $sub === 'items'){
    
    if ($id === null){
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }
    
    if ($method === 'GET') {
    
        $items = list_items_from_store($id);
        
        $result = [];

        foreach ($items as $item){
            $result[] = [
                'id' => $item->get_id(),
                'store_id' => $item->get_store_id(),
                'name' => $item->get_name(),
                'quantity' => $item->get_quantity(),
                'checked' => $item->get_checked(),
                'created_at' => $item->get_created_at(),
            ];
        }

        echo json_encode($result);
        exit;

    } else if ($method === 'POST') {

        $data = json_decode(file_get_contents("php://input"), true);

        if ($id === null || !isset($data['checked']) || !isset($data['name']) || !isset($data['quantity'])){
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            exit;
        }

        $item = new Item(0, $id, $data['name'], $data['quantity'], $data['checked'], null);
        insert_item($item);

        echo json_encode(['message' => 'Item created']);
        exit;

    }
    
// api/items/{id}
} else if($resource === 'items'){
    if ($method === 'DELETE') {

        if ($id === null){
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            exit;
        }

        $item = new Item($id, 0, '', 0, 0, null);
        delete_item($item);

        echo json_encode(['message' => 'Item deleted']);
        exit;

    } else if ($method === 'PUT') {

        $data = json_decode(file_get_contents("php://input"), true);

        if ($id === null || !isset($data['checked']) || !isset($data['name']) || !isset($data['quantity'])){
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            exit;
        }

        $item = new Item($id, 0, $data['name'], $data['quantity'], $data['checked'], null);
        update_item($item);

        echo json_encode(['message' => 'Item updated']);
        exit;

    }
}