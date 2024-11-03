<?php

require_once __DIR__ . '/profileController.php';

class ProfileGenerationController
{
    private $profileController;

    public function __construct()
    {
        $this->profileController = new profileController();
    }

    public function generateProfilesFromAPI($count, $datasetName)
    {
        $url = "https://randomuser.me/api/?results=" . $count;

        // API užklausos vykdymas
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Jei užklausa nesėkminga
        if ($response === false) {
            return ['status' => 'error', 'message' => 'Failed to connect to external API'];
        }

        $data = json_decode($response, true);

        if (!isset($data['results'])) {
            return ['status' => 'error', 'message' => 'No results from API'];
        }

        $insertedProfiles = 0;

        // Įrašome kiekvieną sugeneruotą profilį į DB
        foreach ($data['results'] as $profile) {
            $profileData = [
                'datasetId' => $datasetName,
                'name' => $profile['name']['first'],
                'surname' => $profile['name']['last'],
                'gender' => $profile['gender'],
                'age' => $profile['dob']['age'],
                'email' => $profile['email'],
                'profession' => 'unknown',
                'country' => $profile['location']['country'],
                'city' => $profile['location']['city'],
            ];

            if ($this->profileController->createProfile($profileData)) {
                $insertedProfiles++;
            }
        }

        return [
            'status' => 'success',
            'message' => "$insertedProfiles profiles generated successfully."
        ];
    }
}
