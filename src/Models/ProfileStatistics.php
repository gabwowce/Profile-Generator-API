<?php

require_once __DIR__ . '/Database.php';

class ProfileStatistics
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Gauti statistinius duomenis pagal datasetId
    public function getStatisticsByDatasetId($datasetId)
    {
        $stmt = $this->db->prepare("
            SELECT 
                COUNT(*) as totalProfiles,
                AVG(age) as averageAge,
                COUNT(DISTINCT country) as uniqueCountries
            FROM profiles
            WHERE datasetId = :datasetId
        ");
        $stmt->bindParam(':datasetId', $datasetId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Palyginti duomenų rinkinius pagal datasetId
    public function compareDatasets($datasetId1, $datasetId2)
    {
        $stmt = $this->db->prepare("
            SELECT 
                datasetId,
                COUNT(*) as totalProfiles,
                AVG(age) as averageAge,
                COUNT(DISTINCT city) as uniqueCities,
                GROUP_CONCAT(DISTINCT profession) as professions
            FROM profiles
            WHERE datasetId = :datasetId1 OR datasetId = :datasetId2
            GROUP BY datasetId
        ");

        $stmt->bindParam(':datasetId1', $datasetId1);
        $stmt->bindParam(':datasetId2', $datasetId2);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
