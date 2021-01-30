<?php

namespace App\Mvc\Controllers;


class MainController extends AbstractController {

    public function index() {
        $this->view->render('main');
    }
}