<?php
// Base Model com acesso ao PDO
abstract class Model {
    protected PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }
}

