<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');  // Allowing all origins for testing purposes

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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && strpos($_SERVER['REQUEST_URI'], '/add-file') === 0) {
  $action = 'add-file';
} else {
  list($action, $table, $id) = sscanf($_SERVER['REQUEST_URI'], '/%[^-]-%[^/]/%d');
}

$dbFile = "{$dataDir}/{$table}.serialized";

switch ($action) {
  case 'add-file': {
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
            $errors[] = 'File size must be less than 2 MB';
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
        $data = loadData($dbFile) ?: [];
        $data[] = getJsonRequest();
        saveData($dbFile, $data);
        end($data);
        $last_id = key($data);
        sendResponse(['id' => $last_id], 201);
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
        sendResponse(['error' => "Unknown Action {$action} {$table}"], 405);
        break;
}
?>