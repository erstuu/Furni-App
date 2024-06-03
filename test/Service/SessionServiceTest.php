<?php

namespace Restugedepurnama\Furni\Service;

use PHPUnit\Framework\TestCase;
use Restugedepurnama\Furni\Config\Database;
use Restugedepurnama\Furni\Repository\SessionRepository;
use Restugedepurnama\Furni\Repository\UserRepository;
use Restugedepurnama\Furni\Domain\User;
use Restugedepurnama\Furni\Domain\Session;

function setcookie($name, $value) {
    echo "$name: $value";
}

class SessionServiceTest extends TestCase
{
    private SessionService $sessionService;
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    public function setUp() : void {
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($this->sessionRepository, $this->userRepository);

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();

        $user = new User();
        $user->id = "Restu";
        $user->name = "restu";
        $user->password = "rahasia";

        $this->userRepository->save($user);
    }

    public function testCreate() {
        $session = $this->sessionService->create("Restu");

        TestCase::expectOutputRegex("[X-FURNI-SESSION: $session->id]");

        $result = $this->sessionRepository->findById($session->id);
        TestCase::assertEquals("Restu", $result->userId);
    }

    public function testDestroy() {
        $session = new Session();
        $session->id = uniqid();
        $session->userId = "Restu";

        $this->sessionRepository->save($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

        $this->sessionService->destroy();

        $this->expectOutputRegex("[X-FURNI-SESSION: ]");

        $result = $this->sessionRepository->findById($session->id);
        self::assertNull($result);
    }

    public function testCurrent() {
        $session = new Session();
        $session->id = uniqid();
        $session->userId = "Restu";

        $this->sessionRepository->save($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

        $user = $this->userRepository->findById($session->userId);

        TestCase::assertEquals($session->userId, $user->id);
    }
}
