<?php

namespace controllers;

use core\Controller;


class Guides extends Controller
{
    protected $user;
    protected $guideModel;
    protected $userModel;

    public function __construct()
    {
        $userModel = new \models\Users();
        $this->guideModel = new \models\Guides();
        $this->user = $userModel->GetCurrentUser();
    }

    public function actionIndex($id, $name)
    {
        global $Config;
        $title = 'Гайды';
        $lastGuides = $this->guideModel->GetLastGuides(20);
        return $this->render('index', ['guides' => $lastGuides], [
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
        $guide = $this->guideModel->GetGuideById($id);
        $title = $guide['name'];
        return $this->render('view', ['model' => $guide], [
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
        $title = 'Добавление гайда';
        if ($this->isPost()) {
            $result = $this->guideModel->AddGuide($_POST);
            if ($result['error'] === false) {
                return $this->renderMessage('ok', 'Гайд добавлен', null,
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
    public function actionComment() {
        $titleForbidden = 'Доступ запрещен';
        if (empty($this->user))
            return $this->render('forbidden', null, [
                'PageTitle' => $titleForbidden,
                'MainTitle' => $titleForbidden
            ]);
        $title = 'Добавление комментария';
        if ($this->isPost()) {
            $result = $this->guideModel->AddComment($_POST);
            if ($result['error'] === false) {
                return $this->renderMessage('ok', 'Коментарий добавлен', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title
                    ]);
            } else {
                $message = implode('</br> ', $result['messages']);
                return $this->render('view', ['model' => $_POST],
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title,
                        'MessageText' => $message,
                        'MessageClass' => 'danger'
                    ]);
            }
        } else
            return $this->render('comment', ['model' => $_POST], [
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
        $guide = $this->guideModel->GetGuideById($id);
        $titleForbidden = 'Доступ зазапрещен';
        if (empty($this->user) || ($guide['user_id'] != $this->user['id'] && $this->user['access'] < 2))
            return $this->render('forbidden', null, [
                'PageTitle' => $titleForbidden,
                'MainTitle' => $titleForbidden
            ]);
        $title = 'Редактирование гайда';
        if ($this->isPost()) {
            $result = $this->guideModel->UpdateGuide($_POST, $id);
            if ($result === true) {
                return $this->renderMessage('ok', 'Гайд сохранен', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title
                    ]);
            } else {
                $message = implode('</br> ', $result);
                return $this->render('form', ['model' => $guide],
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title,
                        'MessageText' => $message,
                        'MessageClass' => 'danger'
                    ]);
            }
        } else
            return $this->render('form', ['model' => $guide], [
                'PageTitle' => $title,
                'MainTitle' => $title
            ]);
    }
    public function actionRefactor() {
        $id = $_GET['id'];
        $comment = $this->guideModel->GetCommentById($id);
        $titleForbidden = 'Доступ зазапрещен';
        if (empty($this->user) || ($comment['user_id'] != $this->user['id'] && $this->user['access'] < 1))
            return $this->render('forbidden', null, [
                'PageTitle' => $titleForbidden,
                'MainTitle' => $titleForbidden
            ]);
        $title = 'Редактирование комментария';
        if ($this->isPost()) {
            $result = $this->guideModel->UpdateComment($_POST, $id);
            if ($result === true) {
                return $this->renderMessage('ok', 'Комментарий сохранен', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title
                    ]);
            } else {
                $message = implode('</br> ', $result);
                return $this->render('comment', ['model' => $comment],
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title,
                        'MessageText' => $message,
                        'MessageClass' => 'danger'
                    ]);
            }
        } else
            return $this->render('comment', ['model' => $comment], [
                'PageTitle' => $title,
                'MainTitle' => $title
            ]);
    }
    /**
     * Видалення новини
     */
    public function actionDelete()
    {
        $title = 'Удаление гайда';
        $id = $_GET['id'];
        if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
            if ($this->guideModel->DeleteGuide($id))
                header('Location: /guides/');
            else
                return $this->renderMessage('error', 'Ошибка удаления гайда', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title
                    ]);
        }
        $guide = $this->guideModel->GetGuideById($id);
        return $this->render('delete', ['model' => $guide], [
            'PageTitle' => $title,
            'MainTitle' => $title
        ]);
    }
    public function actionBan() {
        $title = 'Удаление комментария';
        $id = $_GET['id'];
        if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
            if ($this->guideModel->DeleteComment($id))
                header('Location: /guides/');
            else
                return $this->renderMessage('error', 'Ошибка удаления комментария', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title
                    ]);
        }
        $comment = $this->guideModel->GetCommentById($id);
        return $this->render('ban', ['model' => $comment], [
            'PageTitle' => $title,
            'MainTitle' => $title
        ]);
    }
}