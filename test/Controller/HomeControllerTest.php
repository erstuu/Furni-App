<?php

namespace Restugedepurnama\Furni\Controller;

use PHPUnit\Framework\TestCase;
use Restugedepurnama\Furni\Config\Database;
use Restugedepurnama\Furni\Domain\Session;
use Restugedepurnama\Furni\Domain\User;
use Restugedepurnama\Furni\Repository\SessionRepository;
use Restugedepurnama\Furni\Repository\UserRepository;
use Restugedepurnama\Furni\Service\SessionService;

class HomeControllerTest extends TestCase
{
    private HomeController $homeController;
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        $this->homeController = new HomeController();
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->userRepository = new UserRepository(Database::getConnection());

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();
    }

    public function testGuest() {
        $this->homeController->index();

        $this->expectOutputRegex("[FurniTuu]");
    }

    public function testUserLogin() {
        $user = new User();
        $user->id = "restu";
        $user->name = "Restu";
        $user->password = "restu";

        $this->userRepository->save($user);

        $session = new Session();
        $session->id = uniqid();
        $session->userId = $user->id;

        $this->sessionRepository->save($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

        $this->homeController->index();

        TestCase::expectOutputRegex("[FurniTuu]");
    }
}
