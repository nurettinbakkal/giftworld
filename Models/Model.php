<?php
/**
 * Created by PhpStorm.
 * User: nurettin
 * Date: 01.01.2016
 * Time: 11:44
 */

namespace Framework;

use Application\Config\DatabaseConfig;

class Model
{
    /**
     * @var
     */
    private $_databaseConfig;

    /**
     * @var
     */
    private $connection;

    /**
     * @param $databaseConfig
     */
    public function setDatabaseConfig($databaseConfig)
    {
        $this->_databaseConfig = $databaseConfig;
    }

    /**
     * @return mixed
     */
    public function getDatabaseConfig()
    {
        return $this->_databaseConfig;
    }

    /**
     * @param $conn
     */
    public function setConnection($conn)
    {
        $this->connection = $conn;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    /**
     *
     */
    private function __construct()
    {
        $databaseConfig = new DatabaseConfig();
        $this->setDatabaseConfig($databaseConfig);
    }

    public function __destruct() {
        $this->closeSchema();
    }

    /**
     * @param $schema
     */
    public function connectSchema($schema)
    {
        $dbCOnfig = new DatabaseConfig();
        $connectionParams = $dbCOnfig->getConnectionParams();

        $servername = 'localhost';
        $username = $connectionParams['db']['username'];
        $password = $connectionParams['db']['password'];
        $dbname = $connectionParams['db']['schemas'][$schema]['params']['dbname'];

        try {
            $conn = new \PDO('mysql:host=' . $servername . ';dbname=' . $dbname . '', $username, $password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        } catch (\Exception $e) {
            die('Connection failed: ' . $e->getMessage());
        }

        $this->setConnection($conn);
    }

    /**
     *
     */
    public function closeSchema()
    {
        if ($this->getConnection()) {
            $this->setConnection(null);
        }
    }
}