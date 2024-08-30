<?php

// オブジェクトの定義
class User
{
    // 属性（プロパティ）
    private $id;
    private $name;
    private $email;
    private $password;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        if (empty($name)) {
            $name = '匿名';
        }

        $this->name = $name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }
}
