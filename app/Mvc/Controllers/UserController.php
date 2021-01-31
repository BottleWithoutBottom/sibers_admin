<?

namespace App\Mvc\Controllers;
use App\Core\Request;
use App\Mvc\Models\User;
use App\Core\Manager\UserManager;
use App\Core\Helper;

class UserController extends AbstractController {

    public function login() {
        $this->view->render('Войти', [], 'user-login');
    }

    public function authorize() {
        $request = Request::getInstance();
        $params = $request->getPostList();

        $userManager = new UserManager();
        if ($userManager->login($params)) {
            header('Location:/');
        } else {
            while(ob_get_length()){ob_end_clean();}echo("<pre>");print_r($params);echo("</pre>");die();
        }
    }

    public function register() {
        $this->view->render('Регистрация', [], 'user-register');
    }

    public function reg() {
        $request = Request::getInstance();
        $preparedParams = Helper::stripTagsArray($request->getPostList());

        $userManager = new UserManager();

        if($userManager->register($preparedParams)) {
            header('Location: /');
        } else {
            var_dump('Не удалось зарегистрироваться');
        }
    }
}