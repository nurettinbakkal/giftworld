<?php
/**
 * Created by PhpStorm.
 * User: nurettin
 * Date: 01.01.2016
 * Time: 11:10
 */

namespace Application\Config;

class DatabaseConfig
{
    /**
     * @var
     */
    private $connectionParams;

    public function __construct()
    {
        $this->prepareConnectionParams();
    }

    /**
     * @param $connectionParams
     */
    public function setConnectionParams($connectionParams)
    {
        $this->connectionParams = $connectionParams;
    }

    /**
     * @return mixed
     */
    public function getConnectionParams()
    {
        return $this->connectionParams;
    }

    private function prepareConnectionParams()
    {
        $connParams = array(
            'db' => array(
                'username' => '',
                'password' => '',
                'schemas' => array(
                    'default' => array(
                        'params' => array(
                            'host'     => 'localhost',
                            'port'     => '3306',
                            'user'     => '',
                            'password' => '',
                            'dbname'   => 'giftworld',
                        ),
                    ),
                ),
            ),
        );

        $this->setConnectionParams($connParams);
    }
}