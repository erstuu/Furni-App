<?php

namespace Restugedepurnama\Furni\Repository;

use \PDO;
use Restugedepurnama\Furni\Domain\Product;

class AdminRepository
{
    private \PDO $connection;
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function insert(Product $product): Product {
        $statement = $this->connection->prepare("INSERT INTO 2230511063t_products (name, price, image, user_id) VALUES (?, ?, ?, ?)");
        $statement->execute([
            $product->name,
            $product->price,
            $product->image,
            $product->owner->id,
        ]);
        return $product;
    }

    public function select(): array {
        $statement = $this->connection->prepare("SELECT * FROM 2230511063t_products;");
        $statement->execute();
        try {
            $products = [];
            while($row = $statement->fetch()) {
                $product = new Product();
                $product->id = ($row['id']);
                $product->name = ($row['name']);
                $product->price = ($row['price']);
                $product->image = ($row['image']);
                $products[] = $product;
            }
            return $products;

        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteAll() {
        $this->connection->exec("DELETE FROM 2230511063t_products");
    }

}