<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/User.php';

class UserData
{
    private PDO $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    public function save(User $user)
    {
        $sql = <<<SQL
            INSERT INTO users
            (name, email, password)
            VALUES
            (:name, :email, :password)
        SQL;
        $state = $this->pdo->prepare($sql);
        $state->execute([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
        ]);

        $user->setId($this->pdo->lastInsertId());
    }

    /**
     * @return User[]
     */
    public function getAll(): array
    {
        $sql = <<<SQL
            SELECT * FROM users
        SQL;
        $state = $this->pdo->query($sql);

        $users = [];
        foreach ($state as $record) {
            $user = new User();
            $user->setId($record['id']);
            $user->setName($record['name']);
            $user->setEmail($record['email']);
            $user->setPassword($record['password']);
            $users[] = $user;
        }

        return $users;
    }

    public function get(string|int $id): ?User
    {
        $users = $this->getAll();
        foreach ($users as $user) {
            if (intval($user->getId()) === intval($id)) {
                return $user;
            }
        }

        return null;
    }
    public function updateUserInfo($userId, $newName, $newEmail)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $stmt->execute([$newName, $newEmail, $userId]);
    }
}
