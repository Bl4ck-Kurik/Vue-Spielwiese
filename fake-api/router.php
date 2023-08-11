<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');  // Allowing all origins for testing purposes

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Allow any headers the client may need
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    header('Content-Length: 0');
    header('Content-Type: text/plain');
    die();
}

error_log("Requested URI: " . $_SERVER['REQUEST_URI']);

$dataDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'data';
$uploadDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'uploads';

/**
 * Load data from fake db file
 */
function loadData($dbFile) {
    if (file_exists($dbFile)) {
        return unserialize(file_get_contents($dbFile));
    }
    return [];
}

/**
 * Save data to fake db
 */
function saveData($dbFile, $data) {
    file_put_contents($dbFile, serialize($data));
}

/**
 * Returns data from json Post request
 */
function getJsonRequest() {
    $JSON = file_get_contents("php://input");
    return json_decode($JSON, true);
}

/**
 * Send JSON response
 */
function sendResponse($data, $response_code = 200) {
    header('Content-Type: application/json', true, $response_code);
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
    echo json_encode($data, JSON_PRETTY_PRINT);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && strpos($_SERVER['REQUEST_URI'], '/get-image') === 0) {
    $action = 'get-image';
    $image = explode( "/", $_SERVER['REQUEST_URI']);
} else {
    list($action, $table, $id) = array_pad(sscanf($_SERVER['REQUEST_URI'], '/%[^-]-%[^/]/%s'), 3, null);
    $dbFile = "{$dataDir}/{$table}.serialized";
}

switch ($action) {
    case 'addfile': {
        error_log("Inside add-file case");
        if ($_FILES['file']) {
            $errors = array();
            $file_name = $_FILES['file']['name'];
            $file_size = $_FILES['file']['size'];
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_type = $_FILES['file']['type'];

            $file_parts = explode('.', $_FILES['file']['name']);
            $file_ext = strtolower(end($file_parts));
            
            $extensions = array("jpeg", "jpg", "png");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "Extension not allowed, please choose a JPEG or PNG file.";
            }

            if ($file_size > 2097152) {
                $errors[] = 'File size must be less than 2MB';
            }

            if (empty($errors) == true) {
                $file_path = $uploadDir . DIRECTORY_SEPARATOR . $file_name;
                if (move_uploaded_file($file_tmp, $file_path)) {
                    echo "done";
                    exit;
                } else {
                    echo "File upload failed: " . error_get_last()['message'];
                    exit;
                }
            } else {
                echo "Error: " . implode(", ", $errors);
                exit;
            }
        } else {
            echo "No file uploaded.";
            exit;
        }
        break;
    }

    case 'listfiles': {
        $files = glob($uploadDir . DIRECTORY_SEPARATOR . '*.{jpg,jpeg,png}', GLOB_BRACE);
        $fileNames = array_map('basename', $files); 
        
        error_log("Files found: " . implode(", ", $fileNames));

        $imageUrls = array_map(function($fileName) {
            error_log("File=" . $fileName);
            return "http://localhost:10000/get-image/$fileName";
        }, $fileNames);
    
        header('Content-Type: application/json');
        echo json_encode($imageUrls);
        exit;
        break;
    }

    case 'get-image': {
        $imageName = $image[2];
    
        $filePath = $uploadDir . DIRECTORY_SEPARATOR . $imageName;

        if (file_exists($filePath)) {
            $info = getimagesize($filePath);
            header("Content-Type: " . $info["mime"]);
            readfile($filePath);
            exit;
        } else {
            header("HTTP/1.0 404 Not Found");
            echo "Image not found.";
            exit;
        }
        break;
    }

    case 'get':
        if (file_exists($dbFile)) {
            sendResponse(loadData($dbFile));
        } else {
            sendResponse(['error' => "Unknown table {$table}"], 404);
        }
        break;

    case 'update':
        $data = loadData($dbFile);
        if (array_key_exists($id, $data)) {
            $newData = (array) getJsonRequest();
            $newData['last-modified'] = date('H:i:s');
            $data[$id] = array_merge((array) $data[$id], $newData);
            saveData($dbFile, $data);
            sendResponse($data[$id]);
        } else {
            sendResponse(['error' => "no entry with id {$id}"], 404);
        }
        break;

    case 'add':
        $requestData = getJsonRequest();
        if (empty($requestData)) {
            sendResponse(['error' => 'Empty data received'], 400);
            exit;
        }
        $data = loadData($dbFile) ?: [];
        $data[] = $requestData;
        saveData($dbFile, $data);
        end($data);
        $last_id = key($data);
        sendResponse(['id' => $last_id], 201);
        error_log("Inside add case");
        break;

    case 'delete':
        $data = loadData($dbFile);
        if (array_key_exists($id, $data)) {
            unset($data[$id]);
            saveData($dbFile, $data);
            sendResponse(['deleted' => $id]);
        } else {
            sendResponse(['error' => 'nothing to delete', 404]);
        }
        break;

    default:
        sendResponse(['error' => "Unknown Action {$action} {$table}", 'debug' => [$action, $table, $id]], 405);
        break;
}
?>