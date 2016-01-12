<?php
/**
 * Created by PhpStorm.
 * User: nurettin
 * Date: 01.01.2016
 * Time: 10:45
 */

namespace Application\Model;

use Framework\Model;

class Gift extends Model
{
    /**
     * @var string
     */
    private $schema = 'default';

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $gift_name;

    public function __construct($id = null, $gift_name = null)
    {
        if ( null !== $id ) {
            $this->id = $id;
            $this->gift_name = $gift_name;
        }
        $this->connectSchema($this->schema);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $gifts = array();
        $result = $this->getConnection()->prepare('SELECT * FROM gifts');
        $result->execute();
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $response = $result->fetchAll();

        foreach ($response as $user) {
            $gifts[] = new Gift(
                $user['id'],
                $user['gift_name']
            );
        }

        return $gifts;
    }
}