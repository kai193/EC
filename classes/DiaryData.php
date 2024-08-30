<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Diary.php';
require_once __DIR__ . '/User.php';
require_once __DIR__ . '/UserData.php';

class DiaryData
{
    private PDO $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    public function save(Diary $diary)
    {
        $sql = <<<SQL
            INSERT INTO diaries
            (title, body, author)
            VALUES (:title, :body, :author)
        SQL;
        $state = $this->pdo->prepare($sql);
        $state->execute([
            'title' => $diary->getTitle(),
            'body' => $diary->getBody(),
            'author' => $diary->getAuthor()->getId(),
        ]);
    }

    public function update(Diary $diary)
    {
        $sql = <<<SQL
            UPDATE diaries
            SET title = :title, body = :body
            WHERE id = :id
        SQL;
        $state = $this->pdo->prepare($sql);
        $state->execute([
            'title' => $diary->getTitle(),
            'body' => $diary->getBody(),
            'id' => $diary->getId(),
        ]);
    }

    public function delete(Diary $diary)
    {
        $sql = <<<SQL
            DELETE FROM diaries
            WHERE id = :id
        SQL;
        $state = $this->pdo->prepare($sql);
        $state->execute([
            'id' => $diary->getId(),
        ]);
    }

    /**
     * @return Diary[]
     */
    public function getAll(): array
    {
        $sql = <<<SQL
            SELECT * FROM diaries
        SQL;
        $state = $this->pdo->query($sql);

        $diaries = [];
        foreach ($state as $record) {
            $diary = new Diary();
            $diary->setId($record['id']);
            $diary->setTitle($record['title']);
            $diary->setBody($record['body']);

            $userId = $record['author'];
            $userData = new UserData();
            $user = $userData->get($userId);
            $diary->setAuthor($user);

            $diary->setCreatedAt($record['created_at']);
            $diaries[] = $diary;
        }

        return $diaries;
    }

    public function get(string|int $id): ?Diary
    {
        $sql = <<<SQL
            SELECT * FROM diaries
            WHERE id = :id
        SQL;
        $state = $this->pdo->prepare($sql);
        $state->execute([
            'id' => $id,
        ]);

        $record = $state->fetch();

        if ($record === false) {
            return null;
        }

        $diary = new Diary();
        $diary->setId($record['id']);
        $diary->setTitle($record['title']);
        $diary->setBody($record['body']);
        $diary->setCreatedAt($record['created_at']);

        $userId = $record['author'];
        $userData = new UserData();
        $user = $userData->get($userId);
        $diary->setAuthor($user);

        return $diary;
    }
}

