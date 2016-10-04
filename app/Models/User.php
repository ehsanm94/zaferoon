<?php
namespace App\Models;

use Zardak\Model;

class User extends Model
{
    private static $table = 'participants';

    /**
     * @param $cookie
     * @return array|Record
     */
    public static function getUserByCookie($cookie) {
        return Model::QueryOn(self::$table)
            ->where('cookie', $cookie)
            ->first()
            ->get();
    }

    public static function getUserByToken($token) {
        return Model::queryOn(self::$table)
            ->where('token',$token)
            ->first()
            ->get();
    }

    public static function updateCookie($user_id, $cookie) {
        Model::queryOn(self::$table)
            ->where('id', $user_id)
            ->update(array(
                'cookie' => $cookie,
            ));
    }
}