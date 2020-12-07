<?php

require_once __DIR__ . '/../../../app/config/DbHandler.php';
require_once __DIR__ . '/../Entity/Users.php';

class UsersRepository
{
    private $_db;

    public function __construct()
    {
        $this->_db = DbHandler::getDb();
    }

    public function findUser($pseudo, $password)
    {
        $results = $this->_db->prepare("SELECT * FROM Users WHERE pseudo = :pseudo AND password = :password");
        $results->execute([':pseudo' => $pseudo, ':password' => sha1($password)]);

        $articles_from_tables = $results->fetchAll();

        $count = count($articles_from_tables);

        if ($count === 1) {
            return $articles_from_tables;
        }

        return false;
    }

    public function findUserById($id)
    {
        $results = $this->_db->prepare("SELECT * FROM Users WHERE id = :id");
        $results->execute([':id' => $id]);

        $articles_from_tables = $results->fetchAll();

        $count = count($articles_from_tables);

        if ($count === 1) {
            return $this->convertToObject($articles_from_tables[0]);
        }

        return false;
    }

    public function addUser(Users $user)
    {
        $results = $this->_db->prepare(
            "INSERT INTO users (nom, prenom, pseudo, password) 
            VALUE (:nom, :prenom, :pseudo, :password)");

        $results->execute([
            ':nom' => $user->getPrenom(),
            ':prenom' => $user->getPrenom(),
            ':pseudo' => $user->getPseudo(),
            ':password' => $user->getPassword()
        ]);

        if ($results) {
            return true;
        }

        return false;
    }

    private function convertToObject(array $user)
    {
        return new Users($user['nom'], $user['prenom'], $user['pseudo'], $user['password']);
    }
}