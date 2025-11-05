<?php
// Set headers for CORS and JSON response
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}
// Include the POA model and Database( to get the poa data and also use the db connection )
require_once __DIR__ . '/../app/models/Poa.php';
require_once __DIR__ . '/../core/Database.php';
// Initialize database connection and POA model
try {
    $database = new Database();
    $connection = $database->connect();
    $poaModel = new Poa();
} catch (Exception $e) {
    sendResponse(null, 500, 'Database connection error: ' . $e->getMessage());
}

// Method to get the response of the API
function sendResponse(?array $data, int $status = 200, string $message = ''): void {
    http_response_code($status);
    echo json_encode([
        'status' => $status,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}
// Get request method
$method = $_SERVER['REQUEST_METHOD'];
try {
    switch($method):
        case 'GET':
            handleGetRequest($poaModel, $connection);
            break;

        default:
            sendResponse(null, 405, 'Method not allowed');
            break;
    endswitch;
} 
catch (Exception $e) {
    sendResponse(null, 500, 'Server error: ' . $e->getMessage());
}


// -- FUNCTIONS -- //

// Handle the request, in order to send the right status response ( 200 if it's right, 400 if it's missing )
function handleGetRequest(Poa $poaModel, PDO $connection): void {
    // Check if we're looking for a specific POA by ID
    $poaId = $_GET['poaId'] ?? null;
    if ($poaId) 
        getPoaById($poaModel, $connection, $poaId);
    else 
        sendResponse(null, 400, 'Missing poaId parameter. Usage: /api.php?poaId=1');
}

// Get the poa's data 
function getPoaById(Poa $poaModel, PDO $connection, mixed $poaId): void {
    // Validate that poaId is a positive integer
    if (!is_numeric($poaId) || $poaId <= 0) 
        sendResponse(null, 400, 'Invalid POA ID. Must be a positive integer.');
    // Convert to integer
    $poaId = (int)$poaId;
    try {
        // First, check if POA exists using a simple query
        if (!poaExists($connection, $poaId)) 
            sendResponse(null, 404, 'POA not found. No POA exists with ID: ' . $poaId);
        // Get POA data 
        $poaData = $poaModel->getPoaData($poaId);
        // Forms the data response 
        $formattedResponse = [
            'id' => $poaId,
            'description' => $poaData['GENERALDESCRIPTION'] ?? '',
            'date' => $poaData['PRODUCTIONDATE'] ?? '',
            'fiscalYear' => $poaData['FISCALYEAR'] ?? '',
            'observations' => $poaData['OBSERVATIONS'] ?? '',
            'startDate' => $poaData['STARTDATE'] ?? '',
            'endDate' => $poaData['ENDDATE'] ?? '',
            'subarea' => $poaData['SUBAREA'] ?? '',
            'area' => $poaData['AREA'] ?? '',
            'user' => $poaData['POAUSER'] ?? '',
            'estimatedTotal' => $poaData['ESTIMATEDTOTAL'] ?? '',
            'status' => $poaData['STATUS'] ?? ''
        ];
        sendResponse($formattedResponse, 200, 'POA found successfully');
    } catch (Exception $e) {
        sendResponse(null, 500, 'Error retrieving POA: ' . $e->getMessage());
    }
}

// Validates if the POA exists
function poaExists(PDO $connection, int $poaId): bool {
    try {
        $query = "SELECT COUNT(*) as count FROM POAS WHERE ID = ?";
        $stmt = $connection->prepare($query);
        $stmt->execute([$poaId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return ($result && $result['count'] > 0);
    } catch (Exception $e) {
        return false;
    }
}
?>