<?php

class Users
{
    private $_id;
    private $_nom;
    private $_prenom;
    private $_pseudo;
    private $_password;

    public function __construct(string $_nom, string $_prenom, string $_pseudo, string $_password)
    {
        $this->_nom = $_nom;
        $this->_prenom = $_prenom;
        $this->_pseudo = $_pseudo;
        $this->_password = $_password;
    }

    public function getId(): string
    {
        return $this->_id;
    }

    public function setId(string $id): void
    {
        $this->_id = $id;
    }

    public function getNom(): string
    {
        return $this->_nom;
    }

    public function setNom(string $_nom): void
    {
        $this->_nom = $_nom;
    }

    public function getPrenom(): string
    {
        return $this->_prenom;
    }

    public function setPrenom(string $_prenom): void
    {
        $this->_prenom = $_prenom;
    }

    public function getPseudo(): string
    {
        return $this->_pseudo;
    }

    public function setPseudo(string $_pseudo): void
    {
        $this->_pseudo = $_pseudo;
    }

    public function getPassword(): string
    {
        return $this->_password;
    }

    public function setPassword(string $_password): void
    {
        $this->_password = $_password;
    }
}
