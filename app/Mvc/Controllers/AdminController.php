<?php

nameSpace App\Mvc\Controllers;
use App\Core\Manager\UserManager;
use App\Core\Helper;
use App\Mvc\Models\Admin;
use App\Mvc\Models\User;
use App\Mvc\Views\View;
use App\Core\Request;

class AdminController extends AbstractController {

    public function index($dynamicParams = []) {
        $model = $this->getModel();

        $users = $model->getUsers();
        $this->view->render('Users list', [
            'users' => $users,
        ],
        'users-list');
    }

    public function show($dynamicParams = []) {
        if (empty($dynamicParams[User::ID])) {
            View::Show404();
        } else {
            $id = (int) $dynamicParams[User::ID];
            $model = $this->getModel();
            $user = $model->getUser($id);
            $this->view->render(
                'Пользователь: ' . $user->login,
                [
                    'user' => $user,
                ],
                'users-detail'
            );
        }
    }

    public function edit($dynamicParams = []) {
        if (empty($dynamicParams[User::ID])) {
            View::Show404();
        } else {

            $request = Request::getInstance();
            $postList = $request->getPostList();

            $id = (int) $dynamicParams[User::ID];
            $model = $this->getModel();
            $user = $model->getUser($id);

            $this->view->render(
                'Редактирование пользователя ' . $user->login,
                [
                    'user' => $user,
                ],
                'users-detail-edit'
            );
        }
    }

    public function update() {
        $request = Request::getInstance();
        $fields = $request->getPostList();

        foreach ($fields as $field) {
            if (empty($field)) die('Невозможно установить значение как null');
        }

        $preparedFields = Helper::stripTagsArray($fields);

        $userModel = new User();

        if ($userModel->updateUser($preparedFields)) {
            header('Location: /');
        } else {
            die('Не удалось обновить пользователя');
        }
    }

    public function delete($dynamicParams = []) {
        $request = Request::getInstance();
        $userId = $dynamicParams['id'];

        $userManager = new UserManager();
        $userData = $userManager->authorizeByToken();

        if ($userId) {
            $userModel = new User();
            if ($userModel->deleteUser($userId)) {
                header('Location: /');
            } else {
                die('Не удалось удалить пользователя');
            }

        } elseif ($userData[User::STATUS] !== User::GOD_STATUS){
            die('У вас недостаточно прав для выполнения данного действия');
        } else {
            die('Не могу удалить пользователя без указания его ID');
        }

    }
}