<?php

nameSpace App\Mvc\Controllers;
use App\Core\Manager\UserManager;
use App\Core\Helper;
use App\Mvc\Models\Admin;
use App\Mvc\Models\User;
use App\Mvc\Views\View;
use App\Core\Request;
use App\Modules\Paginator;
use App\Core\QueryBuilder\PdoQueryBuilder;

class AdminController extends AbstractController {

    public function index($dynamicParams = []) {
        $model = $this->getModel();

        $usersCount = $model->getUsersCount();
        $request = Request::getInstance();
        $uri = $request->getUri();
        $currentPage = $request->getQuery(Paginator::QUERY);
        $paginator = new Paginator($usersCount, 1, $currentPage, $uri);
        $paginator->generate();
        $firstRow = $paginator->getFirstRow();
        $lastRow = $paginator->getLastRow();
        $limit = [
            PdoQueryBuilder::FIRST_ROW => $firstRow,
        ];

        if ($lastRow >= $usersCount) $limit[PdoQueryBuilder::LAST_ROW] = $usersCount;
        $users = $model->getUsers($limit);
        $this->view->render('Users list', [
            'users' => $users,
            'paginator' => $paginator->getHtml()
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
        $userId = $dynamicParams['id'];

        $userManager = new UserManager();
        $userData = $userManager->authorizeByToken();

        if ($userId) {
            $userModel = new User();
            if ($userData->status != User::GOD_STATUS) {
                if ($userModel->deleteUser($userId)) {
                    header('Location: /');
                } else {
                    die('Не удалось удалить пользователя');
                }
            } else {
                die('У вас недостаточно прав для выполнения данного действия');
            }
        }
    }

    public function add() {
        $userManager = new UserManager();
        $userData = $userManager->authorizeByToken();
        if ($userData->status != User::GOD_STATUS) die('Вы не имеете права создавать новых пользователей');

        $this->view->render('Добавление нового пользователя', [],'user-detail-add');
    }

    public function create() {
        $request = Request::getInstance();

        $params = $request->getPostList();
        $preparedParams = Helper::stripTagsArray($params);

        $userManager = new UserManager();
        $preparedParams[User::PASSWORD] = $userManager->hashPassword($preparedParams[User::PASSWORD]);
        $userModel = new User();
        if ($userModel->setUser($preparedParams)) {
            header('Location: /');
        } else {
            die('не получилось создать нового пользователя');
        }
    }
}