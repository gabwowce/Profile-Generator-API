<?php

require_once __DIR__ . '/../Controllers/ProfileGenerationController.php';

$generationController = new ProfileGenerationController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['count']) || !isset($data['datasetName']) || empty($data['datasetName'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Required parameters "count" and "datasetName" must be provided and cannot be empty.'
        ]);
        http_response_code(400);
        exit;
    }

    $count = $data['count'];
    $datasetName = $data['datasetName'];

    $result = $generationController->generateProfilesFromAPI($count, $datasetName);
    echo json_encode($result);
}
