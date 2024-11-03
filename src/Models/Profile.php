<?php

require_once __DIR__ . '/Database.php';

class Profile
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO profiles (datasetId, name, surname, gender, age, email, profession, country, city) VALUES (:datasetId, :name, :surname, :gender, :age, :email, :profession, :country, :city)");

        $stmt->bindParam(':datasetId', $data['datasetId']);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':surname', $data['surname']);
        $stmt->bindParam(':gender', $data['gender']);
        $stmt->bindParam(':age', $data['age']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':profession', $data['profession']);
        $stmt->bindParam(':country', $data['country']);
        $stmt->bindParam(':city', $data['city']);

        return $stmt->execute();
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM profiles");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM profiles WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByDatasetId($datasetId)
    {
        $stmt = $this->db->prepare("SELECT * FROM profiles WHERE datasetId = :datasetID");
        $stmt->bindParam(':datasetId', $datasetId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE profiles SET datasetId = :datasetId, name = :name, surname = :surname, gender = :gender, age = :age, email = :email, profession = :profession, country = :country, city = :city WHERE id = :id");

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':datasetId', $data['datasetID;']);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':surname', $data['surname']);
        $stmt->bindParam(':gender', $data['gender']);
        $stmt->bindParam(':age', $data['age']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':profession', $data['profession']);
        $stmt->bindParam(':country', $data['country']);
        $stmt->bindParam(':city', $data['city']);

        return $stmt->execute();
    }

    public function deleteById($id)
    {
        $stmt = $this->db->prepare("DELETE FROM profiles WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deleteByDatasetId($datasetId)
    {
        $stmt = $this->db->prepare("DELETE FROM profiles WHERE datasetId = :datasetId");
        $stmt->bindParam(':datasetId', $datasetId);
        return $stmt->execute();
    }
}
