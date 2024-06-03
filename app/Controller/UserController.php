<?php

namespace Restugedepurnama\Furni\Controller;

use Restugedepurnama\Furni\App\View;
use Restugedepurnama\Furni\Service\UserService;
use Restugedepurnama\Furni\Service\SessionService;
use Restugedepurnama\Furni\Repository\UserRepository;
use Restugedepurnama\Furni\Repository\SessionRepository;
use Restugedepurnama\Furni\Model\UserRegisterRequest;
use Restugedepurnama\Furni\Model\UserLoginRequest;
use Restugedepurnama\Furni\Exception\ValidationException;
use Restugedepurnama\Furni\Config\Database;
class UserController
{
    private UserService $userService;
    private SessionService $sessionService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $userRepository = new UserRepository($connection);
        $this->userService = new UserService($userRepository);

        $sessionRepository = new SessionRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    public function register()  {
        View::render("User/register", [
            'title' => 'Register New User',
        ]);
    }

    public function postRegister() {
        $request = new UserRegisterRequest();
        $request->id = $_POST['id'];
        $request->name = $_POST['name'];
        $request->password = $_POST['password'];

        try{
            $this->userService->register($request);
            View::redirect('/users/login');

        }catch(ValidationException $exception) {
            View::render("User/register", [
                'title' => 'Register New User',
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function login() {
        View::render("User/login", [
            "title" => "FurniTuu. Login",
        ]);
    }
//
    public function postLogin() {
        $request = new UserLoginRequest();
        $request->id = $_POST['id'];
        $request->password = $_POST['password'];

        try{
            $response = $this->userService->login($request);

            $this->sessionService->create($response->user->id);

            View::redirect('/admin');

        }catch(ValidationException $exception) {
            View::render("User/login", [
                'title' => 'Login User',
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function logout() {
        $this->sessionService->destroy();
        View::redirect('/');
    }

}