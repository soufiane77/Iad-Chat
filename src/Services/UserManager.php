<?php
/**
 * Created by PhpStorm.
 * User: s.aqajjef
 * Date: 13/05/2019
 * Time: 14:54
 */

namespace App\Services;
use App\Lib\SPDO;

class UserManager
{
    /**
     * @var SPDO
     */
    protected $pdo;

    public function __construct() {
        $this->pdo = SPDO::getInstance()->PDOInstance;
    }

    public function findOneByName($name) {
        $stmt = $this->pdo->prepare('SELECT * FROM users where name = ?');
        $stmt->execute([$name]);
        return $stmt->fetch(\PDO::FETCH_OBJ);

    }

    public function findOneById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM users where id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public function insertUser($name) {
        $stmt = $this->pdo->prepare('INSERT INTO users (name) VALUES (?)');
        if($stmt->execute([$name])) {
            return $this->findOneByName($name);
        }
    }

}