<?php

namespace Restugedepurnama\Furni\Repository;

use PHPUnit\Framework\TestCase;
use Restugedepurnama\Furni\Config\Database;
use Restugedepurnama\Furni\Domain\Session;
use Restugedepurnama\Furni\Domain\User;

class SessionRepositoryTest extends TestCase
{

    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;

    public function setUp(): void
    {
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->sessionRepository = new SessionRepository(Database::getConnection());

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();

        $user = new User();
        $user->id = "restu";
        $user->name = "restu";
        $user->password = "rahasia";

        $this->userRepository->save($user);
    }

    public function testSaveSuccess()
    {
        $session = new Session();
        $session->id = uniqid();
        $session->userId = "restu";

        $this->sessionRepository->save($session);

        $result = $this->sessionRepository->findById($session->id);

        TestCase::assertEquals($session->id, $result->id);
        TestCase::assertEquals($session->userId, $result->userId);
    }

    public function testDeleteById()
    {
        $session = new Session();
        $session->id = uniqid();
        $session->userId = "restu";

        $this->sessionRepository->save($session);

        $result = $this->sessionRepository->findById($session->id);

        TestCase::assertEquals($session->id, $result->id);
        TestCase::assertEquals($session->userId, $result->userId);

        $this->sessionRepository->deleteById($session->id);

        $result = $this->sessionRepository->findById($session->id);
        TestCase::assertNull($result);
    }

    public function testFindByIdNotFound()
    {
        $result = $this->sessionRepository->findById("NotFound");
        TestCase::assertNull($result);
    }

}
