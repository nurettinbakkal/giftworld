<?php
/**
 * Created by PhpStorm.
 * User: nurettin
 * Date: 01.01.2016
 * Time: 10:45
 */

namespace Application\Model;

use Application\Util;
use Framework\Model;

class User extends Model
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
    public $username;

    /**
     * @var string
     */
    public $first_name;

    /**
     * @var string
     */
    public $last_name;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $last_login_time;

    public function __construct($id = null,
                                $username = null,
                                $firstName = null,
                                $lastName = null,
                                $password = null,
                                $lastLoginTime = null)
    {
        if ( null !== $id ) {
            $this->id = $id;
            $this->username = $username;
            $this->first_name = $firstName;
            $this->last_name = $lastName;
            $this->password = $password;
            $this->last_login_time = $lastLoginTime;
        }
        $this->connectSchema($this->schema);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $users = array();
        $result = $this->getConnection()->prepare('SELECT * FROM users');
        $result->execute();
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $response = $result->fetchAll();

        foreach( $response as $user ) {
            $users[] = new User(
                $user['id'],
                $user['username'],
                $user['first_name'],
                $user['last_name'],
                $user['password'],
                $user['last_login_time']
            );
        }

        return $users;
    }

    /**
     * @param $id
     * @return User
     */
    public function findById($id)
    {
        $id = intval($id);
        $result = $this->getConnection()->prepare('SELECT * FROM users WHERE id = :id');
        $result->bindParam(':id', $id, \PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $response = $result->fetch();

        return new User(
            $response['id'],
            $response['username'],
            $response['first_name'],
            $response['last_name'],
            null,
            $response['last_login_time']
        );
    }

    /**
     * @param $username
     * @return User
     */
    public function getIdByUsername($username)
    {
        $username = $username;
        $result = $this->getConnection()->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $result->bindParam(':username', $username);
        $result->execute();
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $response = $result->fetch();

        if ( isset($response['id']) && !is_null($response['id']) ) {
            return $response['id'];
        }
        return false;
    }

    /**
     * login
     *
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function doLogIn($username, $password)
    {
        $result = $this->getConnection()->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $result->bindParam(':username', $username);
        $result->execute();
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $response = $result->fetch();

        $userId = isset($response['id']) ? $response['id'] : null;
        $hashedPassword = isset($response['password']) ? $response['password'] : null;
        $firstName = isset($response['first_name']) ? $response['first_name'] : null;
        $lastName = isset($response['last_name']) ? $response['last_name'] : null;

        if ( $hashedPassword !== Util::hashPassword($password) ) {
            return false;
        }

        $data = array(
            'userid' => $userId,
            'username' => $username,
            'firstname' => $firstName,
            'lastname' => $lastName,
        );

        return $data;
    }
}