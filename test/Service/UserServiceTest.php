<?php

namespace Restugedepurnama\Furni\Service;

use PHPUnit\Framework\TestCase;
use Restugedepurnama\Furni\Config\Database;
use Restugedepurnama\Furni\Domain\User;
use Restugedepurnama\Furni\Model\UserLoginRequest;
use Restugedepurnama\Furni\Repository\UserRepository;
use Restugedepurnama\Furni\Model\UserRegisterRequest;
use Restugedepurnama\Furni\Exception\ValidationException;

class UserServiceTest extends TestCase
{
    private UserService $userService;
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        $connection = Database::getConnection();
        $this->userRepository = new UserRepository($connection);
        $this->userService = new UserService($this->userRepository);

        $this->userRepository->deleteAll();
    }

    public function testRegisterSuccess()
    {
        $request = new UserRegisterRequest();
        $request->id = "Restu";
        $request->name = "Restu";
        $request->password = password_hash("rahasia", PASSWORD_BCRYPT);

        $response = $this->userService->register($request);

        self::assertEquals($request->id, $response->user->id);
        self::assertEquals($request->name, $response->user->name);
        self::assertNotEquals($request->password, $response->user->password);

        // Untuk algoritma BCrypt selalu mengupdate setiap diHash, maka harus menggunakan password_verify
        self::assertTrue(password_verify($request->password, $response->user->password));
    }

    public function testRegisterFailed()
    {
        $this->expectException(ValidationException::class);

        $request = new UserRegisterRequest();
        $request->id = "";
        $request->name = "";
        $request->password = "";

        $this->userService->register($request);
    }

    public function testRegisterDuplicate()
    {
        $user = new User();
        $user->id = "eko";
        $user->name = "Eko";
        $user->password = "rahasia";

        $this->userRepository->save($user);

        $this->expectException(ValidationException::class);

        $request = new UserRegisterRequest();
        $request->id = "eko";
        $request->name = "Eko";
        $request->password = "rahasia";

        $this->userService->register($request);
    }

    public function testLoginNotFound() {
        $this->expectException(ValidationException::class);

        $request = new UserLoginRequest();
        $request->id = "restu";
        $request->password = "restu";

        $this->userService->login($request);
    }
    
    public function testLoginWrongPassword() {
        $user = new User();
        $user->id = "restu";
        $user->name = "restu";
        $user->password = password_hash("salah", PASSWORD_BCRYPT);

        $this->userRepository->save($user);

        $request = new UserLoginRequest();
        $request->id = "restu";
        $request->password = "restu";

        $this->expectException(ValidationException::class);

        $this->userService->login($request);
    }

    public function testLoginSuccess() {
        $user = new User();
        $user->id = "restu";
        $user->name = "restu";
        $user->password = password_hash("restu", PASSWORD_BCRYPT);

        $this->userRepository->save($user);

        $request = new UserLoginRequest();
        $request->id = "restu";
        $request->password = "restu";

        $response = $this->userService->login($request);

        $this->assertEquals($request->id, $response->user->id);
        $this->assertTrue(password_verify($request->password, $response->user->password));
    }
}
