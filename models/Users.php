<?php

namespace models;

use core\Model;
use core\Utils;

class Users extends Model
{
    public function Validate($formRow)
    {
        $errors = [];
        if (empty($formRow['login']))
            $errors [] = 'Поле "Логин" не может быть пустым';
        $user = $this->GetUserByLogin($formRow['login']);
        if (!empty($user))
            $errors [] = 'Пользователь с таким логином уже зарегистрирован';
        if (empty($formRow['password']))
            $errors [] = 'Поле "Пароль" не может быть пустым';
        if ($formRow['password'] != $formRow['password2'])
            $errors [] = 'Пароли не совпадают';
        if (empty($formRow['firstname']))
            $errors [] = 'Поле "Имя" не может быть пустым';
        if (empty($formRow['lastname']))
            $errors [] = 'Поле "Фамилия" не может быть пустым';
        if (count($errors) > 0)
            return $errors;
        else
            return true;
    }
    public function IsUserAuthenticated()
    {
        return isset($_SESSION['user']);
    }
    public function GetCurrentUser()
    {
        if ($this->IsUserAuthenticated())
            return $_SESSION['user'];
        else
            return null;
    }

    public function AddUser($userRow)
    {
        $validateResult =  $this->Validate($userRow);
        if (is_array($validateResult))
            return $validateResult;
        $fields = ['login', 'password', 'firstname', 'lastname'];
        $userRowFiltered = Utils::ArrayFilter($userRow, $fields);
        $userRowFiltered['password'] = md5($userRowFiltered['password']);
        \core\Core::getInstance()->getDB()->insert('users', $userRowFiltered);
        return true;
    }
    public function AuthUser($login, $password)
    {
        $password = md5($password);
        $users = \core\Core::getInstance()->getDB()->select('users', '*',
        [
            'login' => $login,
            'password' => $password
        ]);
        if (count($users) > 0)
        {
            $user = $users[0];
            return $user;
        } else
            return false;
    }

    public function GetUserByLogin($login)
    {
        $rows = \core\Core::getInstance()->getDB()->select('users', '*',
            ['login' => $login]);
        if (count($rows) > 0)
            return $rows[0];
        else
            return null;
    }
    public function GetUserById($id)
    {
        $rows = \core\Core::getInstance()->getDB()->select('users', '*',
            ['id' => $id]);
        if (count($rows) > 0)
            return $rows[0];
        else
            return null;
    }

    public function GetUsers()
    {
        return \core\Core::getInstance()->getDB()->select('users', '*', null);
    }
}