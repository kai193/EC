<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Diary.php';
require_once __DIR__ . '/DiaryData.php';
require_once __DIR__ . '/User.php';
require_once __DIR__ . '/UserData.php';
require_once __DIR__ . '/Comment.php';

class CommentData
{
    private PDO $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    public function save(Comment $comment)
    {
        $sql = <<<SQL
            INSERT INTO comments
            (comment, author, diary)
            VALUES (:comment, :author, :diary)
        SQL;
        $state = $this->pdo->prepare($sql);
        $state->execute([
            'comment' => $comment->getComment(),
            'author' => $comment->getAuthor()->getId(),
            'diary' => $comment->getDiary()->getId(),
        ]);
    }

   /**
     * @return Comment[]
     */
    public function getByDiaryId(int | string $diaryId): array
    {
        $sql = <<<SQL
            SELECT * FROM comments
            WHERE diary = :diaryId
        SQL;
        $state = $this->pdo->prepare($sql);
        $state->execute([
            'diaryId' => $diaryId,
        ]);

        $comments = [];
        foreach ($state as $record) {
            $comment = new Comment();
            $comment->setId($record['id']);
            $comment->setComment($record['comment']);


            $userId = $record['author'];
            $userData = new UserData();
            $user = $userData->get($userId);
            $comment->setAuthor($user);

            $diaryData = new DiaryData();
            $diary = $diaryData->get($record['diary']);
            $comment->setDiary($diary);

            $comments[] = $comment;
        }

        return $comments;
    }

}

