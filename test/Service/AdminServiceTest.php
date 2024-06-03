<?php

namespace Restugedepurnama\Furni\Service;

use PHPUnit\Framework\TestCase;
use Restugedepurnama\Furni\Exception\ValidationException;
use Restugedepurnama\Furni\Config\Database;
use Restugedepurnama\Furni\Model\UserAddRequest;
use Restugedepurnama\Furni\Model\UserAddResponse;
use Restugedepurnama\Furni\Repository\AdminRepository;

class AdminServiceTest extends TestCase
{
    private AdminRepository $adminRepository;

    protected function setUp(): void
    {
        $connection = Database::getConnection();
        $this->adminRepository = new AdminRepository($connection);
        $this->adminRepository->deleteAll();
    }

    public function testInsertProduct()
    {
        $adminService = new AdminService($this->adminRepository);

        $request = new UserAddRequest();
        $request->name = "Product 1";
        $request->price = 10000.00;
        $request->image = "image.jpg";

        $response = $adminService->insertProduct($request);

        $this->assertInstanceOf(UserAddResponse::class, $response);
        $this->assertEquals($request->name, $response->product->name);
        $this->assertEquals($request->price, $response->product->price);
        $this->assertEquals($request->image, $response->product->image);
    }

    public function testInsertProductFailed()
    {
        $this->expectException(ValidationException::class);

        $adminService = new AdminService($this->adminRepository);

        $request = new UserAddRequest();
        $request->name = "";
        $request->price = 0.00;
        $request->image = "";

        $adminService->insertProduct($request);
    }

    public function testSelectProduct()
    {
        $adminService = new AdminService($this->adminRepository);

        $request = new UserAddRequest();
        $request->name = "Product 1";
        $request->price = 10000.00;
        $request->image = "image.jpg";

        $adminService->insertProduct($request);

        $response = $adminService->selectProduct();

        $this->assertIsArray($response);
        $this->assertCount(1, $response);
        $this->assertEquals($request->name, $response[0]->product->name);
        $this->assertEquals($request->price, $response[0]->product->price);
        $this->assertEquals($request->image, $response[0]->product->image);
    }

}
