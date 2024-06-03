<?php

namespace Restugedepurnama\Furni\Repository;

use PHPUnit\Framework\TestCase;
use Restugedepurnama\Furni\Config\Database;
use Restugedepurnama\Furni\Domain\User;

class UserRepositoryTest extends TestCase
{
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;

    public function setUp(): void
    {
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->sessionRepository->deleteAll();

        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userRepository->deleteAll();
    }

    public function testSaveSuccess()
    {
        $user = new User();
        $user->id = "Restu";
        $user->name = "Restu";
        $user->password = "Restu";

        $this->userRepository->save($user);

        $result = $this->userRepository->findById($user->id);

        $this->assertEquals($user->id, $result->id);
        $this->assertEquals($user->name, $result->name);
        $this->assertEquals($user->password, $result->password);
    }

    public function testFindByIdNotFound() {
        $user = $this->userRepository->findById("Not Found!");
        $this->assertNull($user);
    }

    public function testUpdate() {
        $user = new User();
        $user->id = "Restu";
        $user->name = "Restu";
        $user->password = "Restu";

        $this->userRepository->save($user);

        $user->id = "Restu";

        $result = $this->userRepository->findById($user->id);

        $this->assertEquals($user->id, $result->id);
        $this->assertEquals($user->name, $result->name);
        $this->assertEquals($user->password, $result->password);
    }
}
