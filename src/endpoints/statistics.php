<?php

require_once __DIR__ . '/../Controllers/ProfileStatisticsController.php';


$controller = new ProfileStatisticsController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['action']) && $_GET['action'] === 'compare') {
        // Palyginti duomenų rinkinius
        $data = json_decode(file_get_contents("php://input"), true);
        $datasetId1 = $data['datasetId1'] ?? null;
        $datasetId2 = $data['datasetId2'] ?? null;
        $result = $controller->compareDatasets($datasetId1, $datasetId2);
    } else {
        // Gauti statistinius duomenis pagal datasetId
        $data = json_decode(file_get_contents("php://input"), true);
        $datasetId = $data['datasetId'] ?? null;
        $result = $controller->getDatasetStatistics($datasetId);
    }
    echo json_encode($result);
}
