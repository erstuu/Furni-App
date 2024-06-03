<?php

namespace Restugedepurnama\Furni\Service;

use Exception;
use Restugedepurnama\Furni\Config\Database;
use Restugedepurnama\Furni\Exception\ValidationException;
use Restugedepurnama\Furni\Model\UserAddRequest;
use Restugedepurnama\Furni\Model\UserAddResponse;
use Restugedepurnama\Furni\Repository\AdminRepository;
use Restugedepurnama\Furni\Domain\Product;

class AdminService
{
    private AdminRepository $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function insertProduct(UserAddRequest $request): UserAddResponse {
        $this->validateUserAddRequest($request);

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->image = $request->image;
        $product->owner = $request->owner;

        try {
            Database::beginTransaction();

            $this->adminRepository->insert($product);

            Database::commitTransaction();

            $response = new UserAddResponse();
            $response->product = $product;
            return $response;

        } catch(Exception $exception) {
            Database::rollbackTransaction();
            throw $exception;
        }
    }

    private function validateUserAddRequest(UserAddRequest $request) {
        if($request->name == null || $request->price == null || $request->image == null ||
            trim($request->name) == "" || trim($request->price) == null || trim($request->image) == "")
        {
            throw new ValidationException("Name, Price, and Image must be filled!");
        }
    }

    public function selectProduct(): array {
        $rows = $this->adminRepository->select();

        $responses = [];
        foreach ($rows as $row) {
            $product = new Product();
            $product->id = $row->id;
            $product->name = $row->name;
            $product->price = $row->price;
            $product->image = $row->image;

            $responses[] = $product;
        }

        return $responses;
    }
}