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
        $currentPage = $request->getQuery(Paginator::QUERY) ?: 1;
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
                'User: ' . $user->login,
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
                'Editing the user ' . $user->login,
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
            if (empty($field)) die('The field cannot be set as null');
        }

        $preparedFields = Helper::stripTagsArray($fields);

        $userModel = new User();

        if ($userModel->updateUser($preparedFields)) {
            header('Location: /');
        } else {
            die('Cannot edit user\'s data');
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
                    die('Cannot delete the user');
                }
            } else {
                die('Permission denied');
            }
        }
    }

    public function add() {
        $userManager = new UserManager();
        $userData = $userManager->authorizeByToken();
        if ($userData->status != User::GOD_STATUS) die('Permission denied');

        $this->view->render('Adding an user', [],'user-detail-add');
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
            die('Cannot create a user');
        }
    }
}