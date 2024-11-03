<?php

require '../vendor/autoload.php';

require_once __DIR__ . '/../Controllers/ProfileController.php';
require_once __DIR__ . '/../Controllers/ProfileGenerationController.php';

$profileController = new ProfileController();
$generationController = new ProfileGenerationController();

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if (strpos($requestUri, '/api/profiles') === 0) {
    switch ($requestMethod) {
        case 'GET':
            if (isset($_GET['id'])) {
                echo json_encode($profileController->getProfileById($_GET['id']));
            } elseif (isset($_GET['datasetId'])) {
                echo json_encode($profileController->getByDatasetId($_GET['datasetId']));
            } else {
                echo json_encode($profileController->getProfiles());
            }
            break;

        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            echo json_encode($profileController->createProfile($data));
            break;

        case 'PUT':
            $data = json_decode(file_get_contents("php://input"), true);
            if (isset($data['id'])) {
                echo json_encode($profileController->updateProfile($data['id'], $data));
            } else {
                echo json_encode(["error" => "ID is required for update"]);
            }
            break;

        case 'DELETE':
            if (isset($_GET['id'])) {
                echo json_encode($profileController->deleteProfileById($_GET['id']));
            } elseif (isset($_GET['datasetId'])) {
                echo json_encode($profileController->deleteProfilesByDatasetId($_GET['datasetId']));
            } else {
                echo json_encode(["error" => "ID or datasetId is required for delete"]);
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(["error" => "Method Not Allowed"]);
            break;
    }

    // Apdoroti užklausas, kurios susijusios su profilių generavimu
} elseif (strpos($requestUri, '/api/generate-profiles') === 0) {
    if ($requestMethod === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['count']) || !isset($data['datasetName']) || empty($data['datasetName'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Required parameters "count" and "datasetName" must be provided and cannot be empty.']);
        } else {
            echo json_encode($generationController->generateProfilesFromAPI($data['count'], $data['datasetName']));
        }
    }
} else {
    http_response_code(404);
    echo json_encode(["error" => "Not Found"]);
}
