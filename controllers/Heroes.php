<?php

namespace controllers;


use core\Controller;

class Heroes extends Controller
{
    protected $user;
    protected $heroModel;
    protected $userModel;

    public function __construct()
    {
        $userModel = new \models\Users();
        $this->heroModel = new \models\Heroes();
        $this->user = $userModel->GetCurrentUser();
    }

    /**
     * Відображення початкової сторінки модуля
     */
    public function actionIndex($id, $name)
    {
        global $Config;
        $title = 'Герои';
        $heroes = $this->heroModel->GetHeroes();
        return $this->render('index', ['heroes' => $heroes], [
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
        $hero = $this->heroModel->GetHeroById($id);
        $title = $hero['name'];
        return $this->render('view', ['model' => $hero], [
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
        if (empty($this->user) || $this->user['access'] < 2)
            return $this->render('forbidden', null, [
                'PageTitle' => $titleForbidden,
                'MainTitle' => $titleForbidden
            ]);
        $title = 'Добавление героя';
        if ($this->isPost()) {
            $result = $this->heroModel->AddHero($_POST);
            if ($result['error'] === false) {
                $allowed_types = ['image/png', 'image/jpeg'];
                $i = 0;
                foreach ($_FILES as $file) {
                    if (is_file($file['tmp_name']) && in_array($file['type'], $allowed_types)) {
                        switch ($file['file']['type']) {
                            case 'image/png':
                                $extension = 'png';
                                break;
                            default:
                                $extension = 'jpg';
                        }

                        $name = $result['id'][$i] . '_' . uniqid() . '.' . $extension;
                        move_uploaded_file($file['tmp_name'], 'files/heroes/' . $name);
                        if ($i == 0) {
                            $this->heroModel->ChangePhoto($result['id'][0], $name, 'photo');
                        } elseif ($i == 1) {
                            $this->heroModel->ChangePhoto($result['id'][0], $name, 'photo_icon');
                        } else {
                            $this->heroModel->ChangePhoto($result['id'][$i], $name, 'skill');
                        }
                    }
                    $i++;
                }
                $i = 0;
                return $this->renderMessage('ok', 'Герой добавлен', null,
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
        $hero = $this->heroModel->GetHeroById($id);

        $titleForbidden = 'Доступ запрещен';
        if (empty($this->user) || $this->user['access'] < 2)
            return $this->render('forbidden', null, [
                'PageTitle' => $titleForbidden,
                'MainTitle' => $titleForbidden
            ]);
        $title = 'Изменение героя';

        if ($this->isPost()) {
            $result = $this->heroModel->UpdateHero($_POST, $id);
            if ($result === true) {
                $allowed_types = ['image/png', 'image/jpeg'];
                $i = 0;
                foreach ($_FILES as $file) {
                    if (is_file($file['tmp_name']) && in_array($file['type'], $allowed_types)) {
                        switch ($file['file']['type']) {
                            case 'image/png':
                                $extension = 'png';
                                break;
                            default:
                                $extension = 'jpg';
                        }
                        if ($i == 0) {
                            $name = $id . '_' . uniqid() . '.' . $extension;
                            move_uploaded_file($file['tmp_name'], 'files/heroes/' . $name);
                            $this->heroModel->ChangePhoto($id, $name, 'photo');
                        } elseif ($i == 1) {
                            $talents = $this->heroModel->GetTalentsByHeroId($id);
                            $name = $talents['id'] . '_' . uniqid() . '.' . $extension;
                            move_uploaded_file($file['tmp_name'], 'files/heroes/' . $name);
                            $this->heroModel->ChangePhoto($talents['id'], $name, 'photo_icon');
                        } else {
                            $skills = $this->heroModel->GetSkillsByHeroId($id);
                            $skill = $skills[$i-2];
                            $name = $skill['id'] . '_' . uniqid() . '.' . $extension;
                            move_uploaded_file($file['tmp_name'], 'files/heroes/' . $name);
                            $this->heroModel->ChangePhoto($skill['id'], $name, 'skill');
                        }
                    }
                    $i++;
                }
                $i = 0;
                return $this->renderMessage('ok', 'Герой изменен', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title
                    ]);
            } else {
                $message = implode('</br> ', $result);
                return $this->render('form', ['model' => $hero],
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title,
                        'MessageText' => $message,
                        'MessageClass' => 'danger'
                    ]);
            }
        } else
            return $this->render('form', ['model' => $hero], [
                'PageTitle' => $title,
                'MainTitle' => $title
            ]);
    }

    /**
     * Видалення новини
     */
    public function actionDelete()
    {
        $title = 'Удаление героя';
        $id = $_GET['id'];
        if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
            if ($this->heroModel->DeleteHero($id))
                header('Location: /heroes/');
            else
                return $this->renderMessage('error', 'Ошибка удаление героя', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title
                    ]);
        }
        $hero = $this->heroModel->GetHeroById($id);
        return $this->render('delete', ['model' => $hero], [
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