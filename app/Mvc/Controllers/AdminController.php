<?php

nameSpace App\Mvc\Controllers;
use App\Core\Manager\UserManager;
use App\Core\Helper;
use App\Mvc\Models\User;
use App\Mvc\Views\View;
use App\Core\Request;
use App\Modules\Paginator;
use App\Core\QueryBuilder\PdoQueryBuilder;
use App\Modules\Sorter;

class AdminController extends AbstractController {

    public function index() {
        $userManager = new UserManager();
        if (!$userManager->authorizeByToken()) header('Location: /');

        $model = $this->getModel();

        $usersCount = $model->getUsersCount();
        $request = Request::getInstance();
        $uri = $request->getUri();

        // set the value of paginator by get-query or as 1;
        $currentPage = $request->getQuery(Paginator::QUERY) ?: 1;
        $paginator = new Paginator($usersCount, 2, $currentPage, $uri);
        $paginator->generate();
        $firstRow = $paginator->getFirstRow();
        $lastRow = $paginator->getLastRow();
        $limit = [
            PdoQueryBuilder::FIRST_ROW => $firstRow,
            PdoQueryBuilder::LAST_ROW => $lastRow,
        ];

        $availableFields = [User::FIRSTNAME, User::LASTNAME, User::STATUS];
        //Sort users by GET-params
        $foundSort = Sorter::getSortFromQuery($availableFields);
//        while(ob_get_length()){ob_end_clean();}echo("<pre>");print_r($foundSort);echo("</pre>");die();
        $users = $model->getUsers($limit, $foundSort);

        //Let's generate The Sorter by user's firstname's and show the Sorter in HTML
        $sorterFields = array_map(function($user) {
            return $user->firstname;
        }, $users);

        $sorterParams = [
            Sorter::TITLE => Sorter::SORT_FIELD_1_VALUE,
            Sorter::NAME => Sorter::SORT_FIELD_1,
            Sorter::VALUES => $availableFields,
        ];

        $sorter = new Sorter($uri, $sorterParams);
        $sorter->generate();
        $this->view->render('Users list', [
            'users' => $users,
            'paginator' => $paginator->getHtml(),
            'sorter' => $sorter->getHtml(),
        ],
        'users-list');
    }

    public function show($dynamicParams = []) {
        $userManager = new UserManager();
        if (!$userManager->authorizeByToken()) header('Location: /');
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
        $userManager = new UserManager();
        if (!$userManager->authorizeByToken()) header('Location: /');

        if (empty($dynamicParams[User::ID])) {
            View::Show404();
        } else {
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
        $userManager = new UserManager();
        if (!$userManager->authorizeByToken()) header('Location: /');

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
        $userManager = new UserManager();
        $userData = $userManager->authorizeByToken();
        if (!$userData) header('Location: /');

        $userId = $dynamicParams['id'];
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
        if (!$userData) header('Location: /');

        if ($userData->status != User::GOD_STATUS) die('Permission denied');

        $this->view->render('Adding an user', [],'user-detail-add');
    }

    public function create() {
        $userManager = new UserManager();
        if (!$userManager->authorizeByToken()) header('Location: /');

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