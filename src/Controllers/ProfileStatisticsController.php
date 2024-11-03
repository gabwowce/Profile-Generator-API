<?php

require_once __DIR__ . '/../Models/ProfileStatistics.php';

class ProfileStatisticsController
{
    private $statisticsModel;

    public function __construct()
    {
        $this->statisticsModel = new ProfileStatistics();
    }

    // Gauti statistinius duomenis pagal datasetId
    public function getDatasetStatistics($datasetId)
    {
        $statistics = $this->statisticsModel->getStatisticsByDatasetId($datasetId);
        if ($statistics) {
            return [
                'totalProfiles' => $statistics['totalProfiles'],
                'averageAge' => round($statistics['averageAge'], 2),
                'uniqueCountries' => $statistics['uniqueCountries']
            ];
        } else {
            return ['error' => 'Dataset not found'];
        }
    }

    // Palyginti du duomenų rinkinius
    public function compareDatasets($datasetId1, $datasetId2)
    {
        $datasets = $this->statisticsModel->compareDatasets($datasetId1, $datasetId2);

        if (count($datasets) < 2) {
            return ['error' => 'One or both dataset IDs not found'];
        }

        return [
            'dataset1' => [
                'datasetId' => $datasets[0]['datasetId'],
                'totalProfiles' => $datasets[0]['totalProfiles'],
                'averageAge' => round($datasets[0]['averageAge'], 2),
                'uniqueCities' => $datasets[0]['uniqueCities'],
                'professions' => explode(',', $datasets[0]['professions'])
            ],
            'dataset2' => [
                'datasetId' => $datasets[1]['datasetId'],
                'totalProfiles' => $datasets[1]['totalProfiles'],
                'averageAge' => round($datasets[1]['averageAge'], 2),
                'uniqueCities' => $datasets[1]['uniqueCities'],
                'professions' => explode(',', $datasets[1]['professions'])
            ],
            'differences' => [
                'totalProfilesDifference' => abs($datasets[0]['totalProfiles'] - $datasets[1]['totalProfiles']),
                'averageAgeDifference' => abs(round($datasets[0]['averageAge'] - $datasets[1]['averageAge'], 2)),
                'uniqueCitiesDifference' => abs($datasets[0]['uniqueCities'] - $datasets[1]['uniqueCities'])
            ]
        ];
    }
}
