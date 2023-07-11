<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  header('Access-Control-Allow-Origin: http://localhost:8080');
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
  header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
  header('Access-Control-Allow-Credentials: true');
  exit;
}

/**
 * router.php
 *
 * @author Peter Gunold  <pg@eventclass.com>
 * @since  2023-07-07
 */

$dataDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'data';

/**
 * Load data from fake db file
 *
 * @param String $dbFile
 *
 * @return array
 */
function loadData($dbFile) {
  if (file_exists($dbFile)) {
    return unserialize(file_get_contents($dbFile));
  } else return [];
}

/**
 * Save data to fake db
 *
 * @param string $dbFile
 * @param mixed $data
 *
 */
function saveData($dbFile, $data) {
  file_put_contents($dbFile, serialize($data));
}


/**
 * Returns data from json Post request
 *
 * @return mixed
 */
function getJsonRequest() {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $JSON = file_get_contents("php://input");
    return json_decode($JSON, true);
  } else {
    sendResponse(['error' => 'use POST method', 405]);
    die();
  }
}

/**
 * @param array $data
 * @param int $response_code
 */
function sendResponse($data, $response_code = 200) {
  header('Content-Type: application/json', true, $response_code);
  header('Access-Control-Allow-Origin: http://localhost:8080');
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
  header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');

  echo json_encode($data, JSON_PRETTY_PRINT);
}


#header('Content-Type: text/plain');
#var_export(sscanf($_SERVER['REQUEST_URI'], '/%[^-]-%[^/]/%d'));
#print_r($_SERVER);

//list($action, $table) = explode('-', $_SERVER['REQUEST_URI']);
//list($action, $table) = sscanf($_SERVER['REQUEST_URI'], '/%[^-]-%s');
list($action, $table, $id) = sscanf($_SERVER['REQUEST_URI'], '/%[^-]-%[^/]/%d');
$dbFile = "{$dataDir}/{$table}.serialized";

switch ($action) {
  // Load Data
  case 'get': {

    if (file_exists($dbFile)) {
      sendResponse(loadData($dbFile));
    } else {
      sendResponse(['error' => "Unknown table {$table}"], 404);
    }

    break;
  }

  // Update existing data
  case 'update': {
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
  }

  // Add new Data
  case 'add': {
    $data = loadData($dbFile);
    $data[] = getJsonRequest();
    saveData($dbFile, $data);

    // find last id
    end($data);
    $last_id=key($data);

    sendResponse(['id' => $last_id], 201);
    break;
  }

  // Datensatz löschen
  case 'delete': {
    $data = loadData($dbFile);
    if (array_key_exists($id, $data)) {
      unset($data[$id]);
      saveData($dbFile, $data);
      sendResponse(['deleted' => $id]);
    } else {
      sendResponse(['error' => 'nothing to delete', 404]);
    }

    break;
  }

  default: {
    sendResponse(['error' => "Unknown Action {$action} {$table}"], 405);
  }
}
?>