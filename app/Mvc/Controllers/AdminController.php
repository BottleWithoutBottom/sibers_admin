<?php

nameSpace App\Mvc\Controllers;
use App\Mvc\Models\Admin;

class AdminController extends AbstractController {
    public function __construct() {
        $this->setModel(new Admin());
    }

    public function index() {
        $model = $this->getModel();
        while(ob_get_length()){ob_end_clean();}echo("<pre>");print_r($model->getUsers());echo("</pre>");die();
    }
}