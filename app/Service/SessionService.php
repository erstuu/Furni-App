<?php

namespace Restugedepurnama\Furni\Service;

use Restugedepurnama\Furni\Domain\Session;
use Restugedepurnama\Furni\Domain\User;
use Restugedepurnama\Furni\Repository\SessionRepository;
use Restugedepurnama\Furni\Repository\UserRepository;

class SessionService
{
    public static string $COOKIE_NAME = "X-FURNI-SESSION";
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;

    public function __construct(SessionRepository $sessionRepository, UserRepository $userRepository)
    {
        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
    }

    public function create(string $userId) : Session
    {
        $session = new Session();
        $session->id = uniqid();
        $session->userId = $userId;

        $this->sessionRepository->save($session);

        setcookie(SessionService::$COOKIE_NAME, $session->id, time()+(60*60*24), "/");

        return $session;
    }

    public function destroy()
    {
        $sessionId = $_COOKIE[SessionService::$COOKIE_NAME] ?? '';
        $this->sessionRepository->deleteById($sessionId);

        setcookie(SessionService::$COOKIE_NAME, '', 1, "/");
    }
    public function current(): ?User
    {
        $sessionId = $_COOKIE[SessionService::$COOKIE_NAME] ?? '';

        $session = $this->sessionRepository->findById($sessionId);
        if($session == null) {
            return null;
        }

        return $this->userRepository->findById($session->userId);
    }
}