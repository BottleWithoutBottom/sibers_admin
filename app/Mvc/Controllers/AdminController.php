<?php

nameSpace App\Mvc\Controllers;
use App\Mvc\Models\Admin;
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
        if (empty($dynamicParams['id'])) {
            View::Show404();
        } else {
            $id = (int) $dynamicParams['id'];
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

    public function edit() {
        $request = Request::getInstance();
    }
}