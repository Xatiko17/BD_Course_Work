<?php

namespace controllers;

use core\Controller;
/**
 * Контролер для модуля Items
 * @package controllers
 */
class Items extends Controller
{
    protected $user;
    protected $itemsModel;
    protected $userModel;

    public function __construct()
    {
        $userModel = new \models\Users();
        $this->itemsModel = new \models\Items();
        $this->user = $userModel->GetCurrentUser();
    }

    public function actionIndex($id, $name)
    {
        global $Config;
        $title = 'Предметы';
        $items = $this->itemsModel->GetItemsByType();
        return $this->render('index', ['items' => $items], [
            'PageTitle' => $title,
            'MainTitle' => $title
        ]);
    }

    public function actionView()
    {
        $id = $_GET['id'];
        $item = $this->itemsModel->GetItemById($id);
        $title = $item['name'];
        return $this->render('view', ['model' => $item], [
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
        if (empty($this->user) || $this->user['access'] != 2)
            return $this->render('forbidden', null, [
                'PageTitle' => $titleForbidden,
                'MainTitle' => $titleForbidden
            ]);
        $title = 'Добавление предмета';
        if ($this->isPost()) {
            $result = $this->itemsModel->AddItem($_POST);
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
                    move_uploaded_file($_FILES['file']['tmp_name'], 'files/items/' . $name);
                    $this->itemsModel->ChangePhoto($result['id'], $name);
                }

                return $this->renderMessage('ok', 'Предмет добавлен', null,
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
    public function actionEdit()
    {
        $id = $_GET['id'];
        $item = $this->itemsModel->GetItemById($id);
        $titleForbidden = 'Доступ запрещен';
        if (empty($this->user) || $this->user['access'] != 2)
            return $this->render('forbidden', null, [
                'PageTitle' => $titleForbidden,
                'MainTitle' => $titleForbidden
            ]);
        $title = 'Редактирование предмета';
        if ($this->isPost()) {
            $result = $this->itemsModel->UpdateItem($_POST, $id);
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
                    move_uploaded_file($_FILES['file']['tmp_name'], 'files/items/' . $name);
                    $this->itemsModel->ChangePhoto($id, $name);
                }
                return $this->renderMessage('ok', 'Предмет обновлен', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title
                    ]);
            } else {
                $message = implode('</br> ', $result);
                return $this->render('form', ['model' => $item],
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title,
                        'MessageText' => $message,
                        'MessageClass' => 'danger'
                    ]);
            }
        } else
            return $this->render('form', ['model' => $item], [
                'PageTitle' => $title,
                'MainTitle' => $title
            ]);
    }

    /**
     * Видалення новини
     */
    public function actionDelete()
    {
        $title = 'Удаление предмета';
        $id = $_GET['id'];
        if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
            if ($this->itemsModel->DeleteItem($id))
                header('Location: /items/');
            else
                return $this->renderMessage('error', 'Ошибка удаления предмета', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title
                    ]);
        }
        $item = $this->itemsModel->GetItemById($id);
        return $this->render('delete', ['model' => $item], [
            'PageTitle' => $title,
            'MainTitle' => $title
        ]);
    }
}