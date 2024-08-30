<?php

require_once __DIR__ . '/User.php';

class Diary
{
    private $id;
    private $title;
    private $body; // 本文
    private User $author; // 投稿者
    private $createdAt; // 作成日時

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
