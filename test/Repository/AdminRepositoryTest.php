<?php

namespace Restugedepurnama\Furni\Repository;

use PHPUnit\Framework\TestCase;
use Restugedepurnama\Furni\Config\Database;
use Restugedepurnama\Furni\Domain\Product;

class AdminRepositoryTest extends TestCase
{
    private AdminRepository $adminRepository;

    public function setUp(): void
    {
        $this->adminRepository = new AdminRepository(Database::getConnection());
        $this->adminRepository->deleteAll();
    }

    public function testInsertSuccess()
    {
        $product = new Product();
        $product->name = 'Restu';
        $product->price = '1000.00';
        $product->image = 'image.jpg';

        $this->adminRepository->insert($product);

        $result = $this->adminRepository->select();

        $this->assertEquals($product->name, $result[0]->name);
        $this->assertEquals($product->price, $result[0]->price);
        $this->assertEquals($product->image, $result[0]->image);
    }

}
