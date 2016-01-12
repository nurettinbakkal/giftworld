<?php
/**
 * Created by PhpStorm.
 * User: nurettin
 * Date: 01.01.2016
 * Time: 00:09
 */

namespace Application;


class Util
{
    public static function hashPassword($plainPassword)
    {
        return md5(PASSWORD_SALT.sha1($plainPassword.PASSWORD_SALT));
    }
}