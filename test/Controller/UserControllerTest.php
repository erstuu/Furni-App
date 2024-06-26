<?php

namespace Restugedepurnama\Furni\App {
    function header(string $value)
    {
        echo $value;
    }
}

namespace Restugedepurnama\Furni\Service {
    function setcookie($name, $value) {
        echo "$name: $value";
    }
}

namespace Restugedepurnama\Furni\Controller {
    use PHPUnit\Framework\TestCase;
    use Restugedepurnama\Furni\Repository\SessionRepository;
    use Restugedepurnama\Furni\Repository\UserRepository;
    use Restugedepurnama\Furni\Domain\User;
    use Restugedepurnama\Furni\Config\Database;

    class UserControllerTest extends TestCase
    {
        private UserController $userController;
        private UserRepository $userRepository;
        private SessionRepository $sesionRepository;

        protected function setUp(): void {
            $this->userController = new UserController();

            $this->sesionRepository = new SessionRepository(Database::getConnection());
            $this->sesionRepository->deleteAll();

            $this->userRepository = new UserRepository(Database::getConnection());
            $this->userRepository->deleteAll();

            putenv("mode=test");
        }

        public function testRegister() {
            $this->userController->register();

            TestCase::expectOutputRegex("[Register]");
            TestCase::expectOutputRegex("[Id]");
            TestCase::expectOutputRegex("[Name]");
            TestCase::expectOutputRegex("[Password]");
            TestCase::expectOutputRegex("[Register New User]");
        }

        public function testPostRegisterSuccess() {
            $_POST['id'] = 'restu';
            $_POST['name'] = 'restu';
            $_POST['password'] = 'restu';

            $this->userController->postRegister();

            TestCase::expectOutputRegex("[Location: /users/login]");
        }

        public function testPostRegisterValidationError() {
            $_POST['id'] = '';
            $_POST['name'] = 'restu';
            $_POST['password'] = 'restu';

            $this->userController->postRegister();

            TestCase::expectOutputRegex("[Register]");
            TestCase::expectOutputRegex("[Id]");
            TestCase::expectOutputRegex("[Name]");
            TestCase::expectOutputRegex("[Password]");
            TestCase::expectOutputRegex("[Register New User]");
            TestCase::expectOutputRegex("[id, name, password cannot blank!]");
        }

        public function testPostRegisterDuplicate() {

            $user = new User();
            $user->id = "restu";
            $user->name = "restu";
            $user->password = "restu";

            $this->userRepository->save($user);

            $_POST['id'] = 'restu';
            $_POST['name'] = 'restu';
            $_POST['password'] = 'restu';

            $this->userController->postRegister();

            TestCase::expectOutputRegex("[Register]");
            TestCase::expectOutputRegex("[Id]");
            TestCase::expectOutputRegex("[Name]");
            TestCase::expectOutputRegex("[Password]");
            TestCase::expectOutputRegex("[Register New User]");
            TestCase::expectOutputRegex("[User is Already Exist!]");
        }

        public function testLogin() {
            $this->userController->login();

            TestCase::expectOutputRegex("[Login User]");
            TestCase::expectOutputRegex("[Id]");
            TestCase::expectOutputRegex("[Password]");
        }

        public function testLoginSuccess() {
            $user = new User();
            $user->id = "restu";
            $user->name = "restu";
            $user->password = password_hash("restu", PASSWORD_BCRYPT);

            $this->userRepository->save($user);

            $_POST['id'] = "restu";
            $_POST['password'] = "restu";

            $this->userController->postLogin($user);

            TestCase::expectOutputRegex("[Location: /admin]");
            TestCase::expectOutputRegex("[X-FURNI-SESSION: ]");

        }

        public function testLoginValidationError() {
            $_POST['id'] = "";
            $_POST['password'] = "";

            $this->userController->postLogin();

            TestCase::expectOutputRegex("[Login User]");
            TestCase::expectOutputRegex("[Id]");
            TestCase::expectOutputRegex("[Password]");
            TestCase::expectOutputRegex("[Id, Password can not blank]");
        }

        public function testLoginUserNotfound() {
            $_POST['id'] = "notfound";
            $_POST['password'] = "notfound";

            $this->userController->postLogin();

            TestCase::expectOutputRegex("[Login User]");
            TestCase::expectOutputRegex("[Id]");
            TestCase::expectOutputRegex("[Password]");
            TestCase::expectOutputRegex("[Id or password is wrong!]");
        }

        public function testLoginWrongPassword() {
            $user = new User();
            $user->id = "restu";
            $user->name = "restu";
            $user->password = password_hash("restu", PASSWORD_BCRYPT);

            $this->userRepository->save($user);

            $_POST['id'] = "restu";
            $_POST['password'] = "salah";

            $this->userController->postLogin();

            TestCase::expectOutputRegex("[Login User]");
            TestCase::expectOutputRegex("[Id]");
            TestCase::expectOutputRegex("[Password]");
            TestCase::expectOutputRegex("[Id or password is wrong!]");
        }
    }

}

