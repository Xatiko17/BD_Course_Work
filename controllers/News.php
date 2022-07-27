<?php

namespace controllers;


use core\Controller;

/**
 * Контролер для модуля News
 * @package controllers
 */
class News extends Controller
{
    protected $user;
    protected $newsModel;
    protected $userModel;

    public function __construct()
    {
        $userModel = new \models\Users();
        $this->newsModel = new \models\News();
        $this->user = $userModel->GetCurrentUser();
    }

    /**
     * Відображення початкової сторінки модуля
     */
    public function actionIndex($id, $name)
    {
        global $Config;
        $title = 'Новости/Обновления';
        $lastNews = $this->newsModel->GetLastNews($Config['NewsCount']);
        return $this->render('index', ['lastNews' => $lastNews], [
            'PageTitle' => $title,
            'MainTitle' => $title
        ]);
    }

    /**
     * Перегляд новини
     */
    public function actionView()
    {
        $id = $_GET['id'];
        $news = $this->newsModel->GetNewsById($id);
        $title = $news['title'];
        return $this->render('view', ['model' => $news], [
            'PageTitle' => $title,
            'MainTitle' => $title
        ]);
    }

    /**
     * Додавання новини
     */
    public function actionAdd()
    {
        $titleForbidden = 'Доступ запрещен';
        if (empty($this->user))
            return $this->render('forbidden', null, [
                'PageTitle' => $titleForbidden,
                'MainTitle' => $titleForbidden
            ]);
        $title = 'Додавання новини';
        if ($this->isPost()) {
            $result = $this->newsModel->AddNews($_POST);
            if ($result['error'] === false) {
                $allowed_types = ['image/png', 'image/jpeg'];
                if (is_file($_FILES['file']['tmp_name']) && in_array($_FILES['file']['type'], $allowed_types))
                {
                    switch ($_FILES['file']['type'])
                    {
                        case 'image/png':
                            $extension = 'png';
                            break;
                        default:
                            $extension = 'jpg';
                    }
                    $name = $result['id'].'_'.uniqid().'.'.$extension;
                    move_uploaded_file($_FILES['file']['tmp_name'], 'files/news/' . $name);
                    $this->newsModel->ChangePhoto($result['id'], $name);
                }

                return $this->renderMessage('ok', 'Успешно добавлено', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title
                    ]);
            } else {
                $message = implode('</br> ', $result['messages']);
                return $this->render('form', ['model' => $_POST],
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title,
                        'MessageText' => $message,
                        'MessageClass' => 'danger'
                    ]);
            }
        } else
            return $this->render('form', ['model' => $_POST], [
                'PageTitle' => $title,
                'MainTitle' => $title
            ]);
    }

    /**
     * Редагування новини
     */
    public function actionEdit()
    {
        $id = $_GET['id'];
        $news = $this->newsModel->GetNewsById($id);
        $titleForbidden = 'Доступ запрещен';
        if (empty($this->user) || $news['user_id'] != $this->user['id'])
            return $this->render('forbidden', null, [
                'PageTitle' => $titleForbidden,
                'MainTitle' => $titleForbidden
            ]);
        $title = 'Редагування новини';
        if ($this->isPost()) {
            $result = $this->newsModel->UpdateNews($_POST, $id);
            if ($result === true) {
                $allowed_types = ['image/png', 'image/jpeg'];
                if (is_file($_FILES['file']['tmp_name']) && in_array($_FILES['file']['type'], $allowed_types))
                {
                    switch ($_FILES['file']['type'])
                    {
                        case 'image/png':
                            $extension = 'png';
                            break;
                        default:
                            $extension = 'jpg';
                    }
                    $name = $id.'_'.uniqid().'.'.$extension;
                    move_uploaded_file($_FILES['file']['tmp_name'], 'files/news/' . $name);
                    $this->newsModel->ChangePhoto($id, $name);
                }
                return $this->renderMessage('ok', 'Успешно обновлено', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title
                    ]);
            } else {
                $message = implode('</br> ', $result);
                return $this->render('form', ['model' => $news],
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title,
                        'MessageText' => $message,
                        'MessageClass' => 'danger'
                    ]);
            }
        } else
            return $this->render('form', ['model' => $news], [
                'PageTitle' => $title,
                'MainTitle' => $title
            ]);
    }

    /**
     * Видалення новини
     */
    public function actionDelete()
    {
        $title = 'Удаление новости';
        $id = $_GET['id'];
        if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
            if ($this->newsModel->DeleteNews($id))
                header('Location: /news/');
            else
                return $this->renderMessage('error', 'Ошибка удаления новости', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title
                    ]);
        }
        $news = $this->newsModel->GetNewsById($id);
        return $this->render('delete', ['model' => $news], [
            'PageTitle' => $title,
            'MainTitle' => $title
        ]);
    }

    /**
     * Відображення списку новин
     */
    public function actionList()
    {
        echo "actionList";
    }
}