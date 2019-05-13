<?php
/**
 * Created by PhpStorm.
 * User: s.aqajjef
 * Date: 13/05/2019
 * Time: 15:20
 */

namespace App\Lib;


class SPDO
{
    public $PDOInstance = null;

    private static $instance = null;

    const DEFAULT_SQL_USER = 'root';

    const DEFAULT_SQL_HOST = 'mysql';

    const DEFAULT_SQL_PASS = 'root';

    const DEFAULT_SQL_DTB = 'iad_chat';

    const DEFAULT_SQL_PORT = 8989;

    /**
     * SPDO constructor.
     */
    private function __construct() {
        try {
            $this->PDOInstance = new \PDO('mysql:dbname='.self::DEFAULT_SQL_DTB.';host='.self::DEFAULT_SQL_HOST.';port='.self::DEFAULT_SQL_PORT,self::DEFAULT_SQL_USER ,self::DEFAULT_SQL_PASS);
            $this->PDOInstance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch(\PDOException $e){
            echo 'Error: ' . $e->getMessage();
            exit();
        }

    }

    /**
     * get instance pdo if not exist
     * @return SPDO|null
     */
    public static function getInstance()	    {
        if(null === self::$instance OR !isset(self::$instance))      {
            self::$instance = new self();
        }
        return self::$instance;
    }
}