<?php

namespace Restugedepurnama\Furni\Middleware;

use Restugedepurnama\Furni\Config\Database;
use Restugedepurnama\Furni\Repository\UserRepository;
use Restugedepurnama\Furni\Service\SessionService;
use Restugedepurnama\Furni\Repository\SessionRepository;
use Restugedepurnama\Furni\App\View;
class MustLoginMiddleware implements Middleware
{
    private SessionService $sessionService;

    public function __construct()
    {
        $sessionRepository = new SessionRepository(Database::getConnection());
        $userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    public function before(): void
    {
        $user = $this->sessionService->current();
        if($user == null) {
            View::redirect('/users/login');
        }
    }
}