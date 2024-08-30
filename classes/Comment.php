<?php

require_once __DIR__ . '/User.php';
require_once __DIR__ . '/Diary.php';

class Comment
{
    private $id;
    private $comment; // 本文
    private User $author; // 投稿者
    private Diary $diary; // 作成日時

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function setDiary(Diary $diary)
    {
        $this->diary = $diary;
    }

    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getDiary(): Diary
    {
        return $this->diary;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }
}
