<?php

require_once __DIR__ . '/../Models/Profile.php';

class profileController
{
    private $profile;

    public function __construct()
    {
        $this->profile = new Profile();
    }

    public function createProfile($data)
    {
        return $this->profile->create($data);
    }

    public function getProfiles()
    {
        return $this->profile->getAll();
    }

    public function getProfileById($id)
    {
        return $this->profile->getById($id);
    }

    public function getByDatasetId($datasetId)
    {
        return $this->profile->getByDatasetId($datasetId);
    }

    public function updateProfile($id, $data)
    {
        return $this->profile->update($id, $data);
    }

    public function deleteProfileById($id)
    {
        return $this->profile->deleteById($id);
    }

    public function deleteProfilesByDatasetId($id)
    {
        return $this->profile->deleteByDatasetId($id);
    }
}
