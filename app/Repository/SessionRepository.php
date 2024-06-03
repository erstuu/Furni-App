<?php

namespace Restugedepurnama\Furni\Repository;

use \PDO;
use Restugedepurnama\Furni\Domain\Session;

class SessionRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Session $session): Session
    {
        $statement = $this->connection->prepare("INSERT INTO 2230511063t_sessions(id, user_id) VALUES(?,?)");
        $statement->execute([$session->id, $session->userId]);

        return $session;
    }

    public function findById(string $id): ?Session
    {
        $statement = $this->connection->prepare("SELECT id, user_id FROM 2230511063t_sessions WHERE id=?");
        $statement->execute([$id]);

        try {
            if ($row = $statement->fetch()) {
                $session = new Session();
                $session->id = $row['id'];
                $session->userId = $row['user_id'];

                return $session;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteById(string $id) : void {
        $statement = $this->connection->prepare("DELETE FROM 2230511063t_sessions WHERE id=?");
        $statement->execute([$id]);
    }

    public function deleteAll(): void {
        $this->connection->exec("DELETE FROM 2230511063t_sessions");
    }
}