<?php

require_once __DIR__ . '/../Controllers/ProfileController.php';

$controller = new ProfileController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        // Gauti profilį pagal ID
        $id = $_GET['id'];
        $result = $controller->getProfileById($id);
    } elseif (isset($_GET['datasetId'])) {
        // Gauti visus profilius pagal datasetId
        $datasetId = $_GET['datasetId'];
        $result = $controller->getByDatasetId($datasetId);
    } else {
        // Gauti visus profilius
        $result = $controller->getProfiles();
    }
    echo json_encode($result);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sukurti naują profilį
    $data = json_decode(file_get_contents("php://input"), true);
    $result = $controller->createProfile($data);
    echo json_encode($result);
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Atnaulinti profilį
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'] ?? null;
    $result = $controller->updateProfile($id, $data);
    echo json_encode($result);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Ištrinti profilį
    $id = $_GET['id'] ?? null;
    $result = $controller->deleteProfileById($id);
    echo json_encode($result);
}
