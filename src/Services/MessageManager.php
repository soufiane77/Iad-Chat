<?php
/**
 * Created by PhpStorm.
 * User: s.aqajjef
 * Date: 13/05/2019
 * Time: 14:55
 */

namespace App\Services;

use App\Lib\SPDO;

class MessageManager
{
    /**
     * @var SPDO
     */
    protected $pdo;

    public function __construct() {
        $this->pdo = SPDO::getInstance()->PDOInstance;
    }

    public function findAll() {
        $stmt = $this->pdo->prepare('SELECT * FROM messages');
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function findOneById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM messages m left join users u on u.id = m.user_id  where m.id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public function addMessage($message, $user_id) {
        $stmt = $this->pdo->prepare("INSERT INTO messages (user_id, text, createdAt ) VALUES (?, ?, NOW())");
        $stmt->execute([$user_id, $message]);
        return $this->findOneById($this->pdo->lastInsertId());
    }

}