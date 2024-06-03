<?php

namespace Restugedepurnama\Furni\Repository;

use PDO;
use Restugedepurnama\Furni\Domain\User;
class UserRepository
{
    private PDO $connection;
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function findByID(string $id): ?User
    {;
        $statement = $this->connection->prepare("SELECT * FROM 2230511063t_users WHERE id = ?");
        $statement->execute([$id]);
        try {
            if($row = $statement->fetch()) {
                $user = new User();
                $user->id = ($row['id']);
                $user->name = ($row['username']);
                $user->password = ($row['password']);

                return $user;

            } else {
                return null;
            }

        }finally {
            $statement->closeCursor();
        }
    }

    public function save(User $user): User
    {
        $statement = $this->connection->prepare("INSERT INTO 2230511063t_users (id, username, password) VALUES (?, ?, ?)");
        $statement->execute([
            $user->id,
            $user->name,
            $user->password,
        ]);
        return $user;
    }

    public function update(User $user): User
    {
        $statement = $this->connection->prepare("UPDATE 2230511063t_users SET username = ?, password = ? WHERE id = ?");
        $statement->execute([
            $user->id,
            $user->name,
            $user->password,
        ]);
        return $user;
    }

    public function deleteAll(): void
    {
        $this->connection->exec("DELETE from 2230511063t_users");
    }
}