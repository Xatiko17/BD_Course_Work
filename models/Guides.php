<?php

namespace models;

use core\Utils;

class Guides extends \core\Model
{
    public function AddGuide($row)
    {

        $userModel = new \models\Users();
        $user = $userModel->GetCurrentUser();
        if ($user == null) {
            $result = [
                'error' => true,
                'messages' => ['Пользователь не авторизирован']
            ];
            return $result;
        }
        $validateResult = $this->Validate($row);
        if (is_array($validateResult)) {
            $result = [
                'error' => true,
                'messages' => $validateResult
            ];
            return $result;
        }
        $fields = ['name', 'description', 'skill_comment_0', 'skill_comment_1',
            'skill_comment_2', 'skill_comment_3', 'comment_0', 'comment_1',
            'comment_2', 'comment_3', 'comment_4', 'post', 'items'];
        $rowFiltered = Utils::ArrayFilter($row, $fields);
        $rowFiltered['datetime'] = date('Y-m-d H:i:s');
        $rowFiltered['user_id'] = $user['id'];
        $rowFiltered['hero_id'] = $_GET['hero_id'];
        $id = \core\Core::getInstance()->getDB()->insert('guides', $rowFiltered);
        return [
            'error' => false,
            'id' => $id
        ];
    }

    public function AddComment($row)
    {
        $userModel = new \models\Users();
        $user = $userModel->GetCurrentUser();
        if ($user == null) {
            $result = [
                'error' => true,
                'messages' => ['Пользователь не авторизирован']
            ];
            return $result;
        }
        $validateResult = $this->ValidateComment($row);
        if (is_array($validateResult)) {
            $result = [
                'error' => true,
                'messages' => $validateResult
            ];
            return $result;
        }
        $row['datetime'] = date('Y-m-d H:i:s');

        $id = \core\Core::getInstance()->getDB()->insert('comments', $row);
        return [
            'error' => false,
            'id' => $id
        ];
    }

    public function GetCommentsByGuideId($id)
    {
        return \core\Core::getInstance()->getDB()->select('comments', '*', ['guide_id' => $id], ['datetime' => 'DESC']);
    }

    public function GetLastGuides($count)
    {
        return \core\Core::getInstance()->getDB()->select('guides', '*', null, ['datetime' => 'DESC'], $count);
    }

    public function GetGuideById($id)
    {
        $guide = \core\Core::getInstance()->getDB()->select('guides', '*', ['id' => $id]);
        if (!empty($guide))
            return $guide[0];
        else
            return null;
    }

    public function GetGuidesByUserId($id)
    {
        $guide = \core\Core::getInstance()->getDB()->select('guides', '*', ['user_id' => $id]);
        if (!empty($guide))
            return $guide;
        else
            return null;
    }
    public function GetGuides()
    {
        return \core\Core::getInstance()->getDB()->select('guides', '*', null);
    }
    public function GetBestGuides()
    {
        $guides = \core\Core::getInstance()->getDB()->select('guides', '*');
        $results = [];
        for ($i = 0; $i < count($guides); $i++) {
            $comments = $this->GetCommentsByGuideId($guides[$i]['id']);
            $result = $this->countLikes($comments);
            array_push($results, (int)$result['likes'] - $result['dislikes']);
        }

        if (count($guides) > 1) {
            $check = true;
            do {
                $check = false;
                for ($i = 1; $i < count($guides); $i++) {
                    if ($results[$i] > $results[$i-1]) {
                        list($guides[$i], $guides[$i-1]) = array($guides[$i-1], $guides[$i]);
                        list($results[$i], $results[$i-1]) = array($results[$i-1], $results[$i]);
                        $check = true;
                    }
                }
            } while ($check);
            while (count($guides) > 5)
                array_pop($guides);
            return $guides;
        }
        else {
            if (!empty($guides))
                return $guides;
            else
                return null;
        }
    }

    public function countLikes($comments)
    {
        $was = [];
        $result['likes'] = 0;
        $result['dislikes'] = 0;
        foreach ($comments as $comment) {
            if ($comment['liked'] == 'true') {
                if (!in_array($comment['user_id'], $was)) {
                    $result['likes'] += 1;
                    array_push($was, $comment['user_id']);
                }
            }
            if ($comment['liked'] == 'false') {
                if (!in_array($comment['user_id'], $was)) {
                    $result['dislikes'] += 1;
                    array_push($was, $comment['user_id']);
                }
            }

        }
        return $result;
    }

    public function GetCommentById($id)
    {
        $comment = \core\Core::getInstance()->getDB()->select('comments', '*', ['id' => $id]);
        if (!empty($comment))
            return $comment[0];
        else
            return null;
    }

    public function UpdateGuide($row, $id)
    {
        $userModel = new \models\Users();
        $user = $userModel->GetCurrentUser();
        if ($user == null)
            return false;
        $validateResult = $this->Validate($row);
        if (is_array($validateResult))
            return $validateResult;

        $fields = ['name', 'description', 'skill_comment_0', 'skill_comment_1',
            'skill_comment_2', 'skill_comment_3', 'comment_0', 'comment_1',
            'comment_2', 'comment_3', 'comment_4', 'post', 'items'];
        $rowFiltered = Utils::ArrayFilter($row, $fields);
        $rowFiltered['datetime'] = date('Y-m-d H:i:s');
        $rowFiltered['user_id'] = $user['id'];
        $rowFiltered['hero_id'] = $_GET['hero_id'];

        \core\Core::getInstance()->getDB()->update('guides', $rowFiltered, ['id' => $id]);
        return true;

    }

    public function UpdateComment($row, $id)
    {
        $userModel = new \models\Users();
        $user = $userModel->GetCurrentUser();
        if ($user == null)
            return false;
        $validateResult = $this->ValidateComment($row);
        if (is_array($validateResult)) {
            $result = [
                'error' => true,
                'messages' => $validateResult
            ];
            return $result;
        }
        $row['datetime'] = date('Y-m-d H:i:s');

        \core\Core::getInstance()->getDB()->update('comments', $row, ['id' => $id]);
        return true;
    }


    public function DeleteGuide($id)
    {
        $guide = $this->GetGuideById($id);
        $userModel = new \models\Users();
        $user = $userModel->GetCurrentUser();
        if (empty($guide) || empty($user) || ($user['id'] != $guide['user_id'] || $user['access'] != 2))
            return false;
        \core\Core::getInstance()->getDB()->delete('guides', ['id' => $id]);
        return true;
    }

    public function DeleteComment($id)
    {
        $comment = $this->GetCommentById($id);
        $userModel = new \models\Users();
        $user = $userModel->GetCurrentUser();
        if (empty($comment) || empty($user) || ($user['id'] != $comment['user_id'] || $user['access'] < 1))
            return false;
        \core\Core::getInstance()->getDB()->delete('comments', ['id' => $id]);
        return true;
    }

    public function Validate($row)
    {
        $errors = [];
        if (empty($row['name']))
            $errors [] = 'Поле "Название гайде" не может быть пустым';
        $check = $row['post'];
        $check = explode(';', $check);
        if (count($check) < 30)
            $errors [] = 'Все способности должны быть вкачены';
        if (empty($row['description']))
            $errors [] = 'Поле "Описание гайда" не может быть пустым';

        if (count($errors) > 0)
            return $errors;
        else
            return true;
    }

    public function ValidateComment($row)
    {
        $errors = [];
        if (empty($row['text']))
            $errors [] = 'Поле "Комментарий" не может быть пустым';
        if (empty($row['liked']))
            $errors [] = 'Нужно выбрать понравился ли вам гайд';
        if (count($errors) > 0)
            return $errors;
        else
            return true;
    }
}