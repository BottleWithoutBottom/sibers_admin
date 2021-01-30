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
        if (empty($dynamicParams['id'])) View::Show404();
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

    public function edit() {
        $request = Request::getInstance();
        while(ob_get_length()){ob_end_clean();}echo("<pre>");print_r(123);echo("</pre>");die();
        while(ob_get_length()){ob_end_clean();}echo("<pre>");print_r($request->getPostList());echo("</pre>");die();
    }
}