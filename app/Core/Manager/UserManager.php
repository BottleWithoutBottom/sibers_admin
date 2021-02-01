<?php

namespace App\Core\Manager;
use App\Core\Request;
use App\Core\Helper;
use App\Mvc\Models\User;
use App\Mvc\Models\UserToken;

class UserManager {
    protected CONST TOKEN_LENGTH = 128;

    protected CONST SESSID = 'sessid';

    public function __construct() {
        $this->model = new User();
    }

    public function login($params) {
        if (empty($params[User::LOGIN]) ||  empty($params[User::PASSWORD])) return false;

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
            var_dump('This user already exists');
        }

        return false;
    }

    public function register($params) {
        if (empty($params[User::LOGIN] || empty($params[User::PASSWORD]))) return false;

        $preparedParams = Helper::stripTagsArray($params);
        $hashedPassword = $this->hashPassword($preparedParams[User::PASSWORD]);
        $preparedParams[User::STATUS] = User::AUTHORIZED_STATUS;
        $preparedParams[User::PASSWORD] = $hashedPassword;
        if ($this->model->setUser($preparedParams)) {
            $user = $this->model->getUser(User::LOGIN, '=', $preparedParams[User::LOGIN]);

            $token = $this->generateToken();
            $userTokenModel = new UserToken();
            if ($userTokenModel->insertToken($user->id, $token)) {
                $this->setTokenInStorages($token);
                return true;
            }


            return true;
        } else {
            throw new \Exception('an error occured during register, repeat again.');
        }

    }

    public function hashPassword($password) {
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
        return true;
    }

    /** the methods checks if there is the token in any storage, and if it is so, returns user\'s data */
    public function authorizeByToken() {
        $request = Request::getInstance();
        $token = $request->getSessionOrCookie(static::SESSID);
        if ($token) {
            $userTokenModel = new UserToken();
            $user_id = $userTokenModel->selectUserIdByToken($token)->user_id;

            if ($user_id) {
                $user = $this->model->getUser(User::ID, '=', $user_id, [User::LOGIN, User::STATUS, User::ID]);
                if ($user) return $user;
            } else {
                return false;
            }
        }
    }
}