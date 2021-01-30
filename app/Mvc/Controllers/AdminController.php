<?php

nameSpace App\Mvc\Controllers;
use App\Mvc\Models\Admin;

class AdminController extends AbstractController {

    public function index() {
        $model = $this->getModel();

        $users = $model->getUsers();
        $this->view->render('Users list', [
            'users' => $users,
        ],
        'users-list');
    }
}