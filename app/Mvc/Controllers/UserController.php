<?

namespace App\Mvc\Controllers;
use App\Core\Request;
use App\Mvc\Models\User;
use App\Core\Manager\UserManager;
use App\Core\Helper;

class UserController extends AbstractController {

    public function login() {
        $this->view->render('Sign in', [], 'user-login');
    }

    public function authorize() {
        $request = Request::getInstance();
        $params = $request->getPostList();

        $userManager = new UserManager();
        if ($userManager->login($params)) {
            header('Location:/');
        } else {
            var_dump('Cannot sign in. Check your data one more time');
        }
    }

    public function register() {
        $this->view->render('Sign up', [], 'user-register');
    }

    public function reg() {
        $request = Request::getInstance();
        $preparedParams = Helper::stripTagsArray($request->getPostList());

        $userManager = new UserManager();

        if($userManager->register($preparedParams)) {
            header('Location: /');
        } else {
            var_dump('Cannot sign up. Check your data one more time');
        }
    }
}