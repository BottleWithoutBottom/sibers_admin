<?php

namespace App\Core\Manager;
use App\Core\Request;
use App\Core\Helper;
use App\Mvc\Models\User;
use App\Mvc\Models\UserToken;

class UserManager {
    protected CONST AUTHORIZED_STATUS = 1;
    protected CONST CONFIRMED_STATUS = 2;
    protected CONST GOD_STATUS = 3;

    protected CONST TOKEN_LENGTH = 128;

    protected CONST SESSID = 'sessid';
    protected CONST HASH_PASSWORD = 'hashPassword';

    public function __construct() {
        $this->model = new User();
    }


    public function login($params) {
        if (
            empty($params[User::LOGIN])
            ||  empty($params[User::PASSWORD])
        ) {
            return false;
        }

        $preparedParams = $this->prepareParams($params);

        $user = $this->model->getUser(User::LOGIN, '=', $preparedParams[User::LOGIN]);

        if ($user) {
            if ($this->verifyPassword($preparedParams[User::PASSWORD], $user->password)) {
                $token = $this->generateToken();
                $userToken = new UserToken();
                if ($userToken->insertToken($user->id, $token)) {
                    $this->setTokenInStorages($token);
                    return true;
                }
            }
        } else {
            die('Пользователя с таким логином не существует');
        }

        return false;
    }

    private function hashPassword($password) {
        if (empty($password)) return false;

        return password_hash($password, PASSWORD_BCRYPT);
    }

    private function verifyPassword($password, $hash) {
        if (empty($password) || empty($hash)) return false;
        return password_verify($password, $hash);
    }

    private function generateToken() {
        return substr(bin2hex(random_bytes(static::TOKEN_LENGTH)), 0, static::TOKEN_LENGTH);
    }

    private function prepareParams($params) {
        if (empty($params)) return false;

        $preparedParams = [];
        foreach($params as $key => $param) {
            $preparedParams[$key] = Helper::stripTags($param);
        }

        return $preparedParams;
    }

    private function setTokenInStorages($token) {
        if (empty($token)) return false;

        $request = Request::getInstance();

        $request->setSession(static::SESSID, $token);
        $request->setCookie(static::SESSID, $token, 3600 * 24 * 7);
    }
}