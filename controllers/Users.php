<?php

namespace controllers;

use core\Controller;

class Users extends Controller
{
    protected $usersModel;

    function __construct()
    {
        $this->usersModel = new \models\Users();
    }
    function actionLogout()
    {
        $title = 'Выход из аккаунта';
        unset($_SESSION['user']);
        return $this->renderMessage('ok', 'Вы вышли из аккаунта', null,
            [
                'PageTitle' => $title,
                'MainTitle' => $title
            ]);
    }
    function actionLogin()
    {
        $title = 'Вхід на сайт';
        if (isset($_SESSION['user']))
            return $this->renderMessage('ok', 'Вы уже вошли', null,
                [
                    'PageTitle' => $title,
                    'MainTitle' => $title
                ]);
        if ($this->isPost())
        {
            $user = $this->usersModel->AuthUser($_POST['login'], $_POST['password']);
            if (!empty($user))
            {
                $_SESSION['user'] = $user;
                return $this->renderMessage('ok', 'Вы вошли на сайт', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title
                    ]);
            } else
            {
                return $this->render('login', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title,
                        'MessageText' => 'Неправильный логин и пароль',
                        'MessageClass' => 'danger'
                    ]);
            }
        } else {
            $params = [
                'PageTitle' => $title,
                'MainTitle' => $title
            ] ;
            return $this->render('login', null, $params);
        }
    }

    function actionRegister()
    {
        if ($this->isPost()) {
            $result = $this->usersModel->AddUser($_POST);
            if ($result === true) {
                return $this->renderMessage('ok', 'Пользователь успешно зарегестрирован', null,
                    [
                        'PageTitle' => 'Регистрация на сайте',
                        'MainTitle' => 'Регистрация на сайте'
                    ]);
            } else
            {
                $message = implode('</br> ', $result);
                return $this->render('register', null,
                    [
                        'PageTitle' => 'Регистрация на сайте',
                        'MainTitle' => 'Регистрация на сайте',
                        'MessageText' => $message,
                        'MessageClass' => 'danger'
                    ]);
            }
        } else {
            $params = [
                'PageTitle' => 'Регистрация на сайте',
                'MainTitle' => 'Регистрация на сайте'
            ] ;
            return $this->render('register', null, $params);
            }
    }
}