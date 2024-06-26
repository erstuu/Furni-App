<?php

namespace Restugedepurnama\Furni\Service;

use Exception;
use Restugedepurnama\Furni\Config\Database;
use Restugedepurnama\Furni\Domain\User;
use Restugedepurnama\Furni\Exception\ValidationException;
use Restugedepurnama\Furni\Model\UserRegisterRequest;
use Restugedepurnama\Furni\Model\UserRegisterResponse;
use Restugedepurnama\Furni\Model\UserLoginRequest;
use Restugedepurnama\Furni\Model\UserLoginResponse;
use Restugedepurnama\Furni\Repository\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // Register Service Request
    public function register(UserRegisterRequest $request): UserRegisterResponse
    {
        $this->validateUserRegistrationRequest($request);

        try {
            Database::beginTransaction();

            $user = $this->userRepository->findById($request->id);
            if($user != null) {
                throw new ValidationException("User is Already Exist!");
            }

            $user = new User();
            $user->id = $request->id;
            $user->name = $request->name;
            $user->password = password_hash($request->password, PASSWORD_BCRYPT);

            $this->userRepository->save($user);

            $response = new UserRegisterResponse();
            $response->user = $user;

            Database::commitTransaction();

            return $response;
        } catch(Exception $exception) {
            Database::rollbackTransaction();

            throw $exception;
        }
    }

    // Validate Register Service Request
    private function validateUserRegistrationRequest(UserRegisterRequest $request) {
        if($request->id == null || $request->name == null || $request->password == null ||
            trim($request->id) == "" || trim($request->name) == null || trim($request->password) == "")
        {
            throw new ValidationException("id, name, password cannot blank!");
        }
    }

    // Login Service Request
    public function login(UserLoginRequest $request): UserLoginResponse
    {
        $this->validateUserLoginRequest($request);

        $user = $this->userRepository->findById($request->id);
        if ($user == null) {
            throw new ValidationException("Id or password is wrong!");
        }

        if (password_verify($request->password, $user->password)) {
            $response = new UserLoginResponse();
            $response->user = $user;
            return $response;

        } else {
            throw new ValidationException("Id or password is wrong!");
        }
    }
//
//    // Validate Login Request
    private function validateUserLoginRequest(UserLoginRequest $request)
    {
        if ($request->id == null || $request->password == null ||
            trim($request->id) == "" || trim($request->password) == "") {
            throw new ValidationException("Id, Password can not blank");
        }
    }
//
//    public function updateProfile(UserProfileUpdateRequest $request): UserProfileUpdateResponse
//    {
//        $this->validateUpdateProfileRequest($request);
//
//        try {
//            Database::beginTransaction();
//
//            $user = $this->userRepository->findById($request->id);
//            if ($user == null) {
//                throw new ValidationException("User is not found!");
//            }
//
//            $user->name = $request->name;
//            $this->userRepository->update($user);
//
//            Database::commitTransaction();
//
//            $response = new UserProfileUpdateResponse();
//            $response->user = $user;
//
//            return $response;
//        } catch (Exception $exception) {
//            Database::rollbackTransaction();
//            throw $exception;
//        }
//    }
//
//    private function validateUpdateProfileRequest(UserProfileUpdateRequest $request)
//    {
//        if ($request->id == null || $request->name == null ||
//            trim($request->id) == "" || trim($request->name) == "") {
//            throw new ValidationException("Id, Name can not blank");
//        }
//    }
//
//    public function updatePassword(UserPasswordUpdateRequest $request): UserPasswordUpdateResponse
//    {
//        $this->validateUserPasswordUpdateRequest($request);
//
//        try {
//            Database::beginTransaction();
//
//            $user = $this->userRepository->findById($request->id);
//            if($user == null) {
//                throw new ValidationException("User is not found!");
//            }
//
//            if(!password_verify($request->oldPassword, $user->password)) {
//                throw new ValidationException("Old password is wrong!");
//            }
//
//            $user->password = password_hash($request->newPassword, PASSWORD_BCRYPT);
//            $this->userRepository->update($user);
//
//            Database::commitTransaction();
//
//            $response = new UserPasswordUpdateResponse();
//            $response->user = $user;
//            return $response;
//
//        } catch(Exception $exception) {
//            Database::rollbackTransaction();
//            throw $exception;
//        }
//    }
//
//    private function validateUserPasswordUpdateRequest(UserPasswordUpdateRequest $request)
//    {
//        if ($request->id == null || $request->oldPassword == null || $request->newPassword == null ||
//            trim($request->id) == "" || trim($request->oldPassword) == "" || trim($request->newPassword == null)) {
//            throw new ValidationException("Id, Old Password, New Password can not blank!");
//        }
//    }
}