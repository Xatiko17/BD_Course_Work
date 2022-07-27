<?php

namespace models;

use core\Utils;
use Imagick;

class News extends \core\Model
{
    public function ChangePhoto($id, $file)
    {
        $folder = 'files/news/';
        $file_path = pathinfo($folder.$file);
        $file_big =  $file_path['filename'].'_b';
        $file_middle =  $file_path['filename'].'_m';
        $file_small =  $file_path['filename'].'_s';
        $news = $this->GetNewsById($id);
        if (is_file($folder.$news['photo'].'_b.jpg') && is_file($folder.$file))
            unlink($folder.$news['photo'].'_b.jpg');
        if (is_file($folder.$news['photo'].'_m.jpg') && is_file($folder.$file))
            unlink($folder.$news['photo'].'_m.jpg');
        if (is_file($folder.$news['photo'].'_s.jpg') && is_file($folder.$file))
            unlink($folder.$news['photo'].'_s.jpg');
        $news['photo'] = $file_path['filename'];
        $in_b = new Imagick();
        $in_b->readImage($_SERVER['DOCUMENT_ROOT'].'/'.$folder.$file);
        $in_b->cropThumbnailImage(1280, 1024, true);
        $in_b->writeImage($_SERVER['DOCUMENT_ROOT'].'/'.$folder.$file_big.'.jpg');
        $in_m = new Imagick();
        $in_m->readImage($_SERVER['DOCUMENT_ROOT'].'/'.$folder.$file);
        $in_m->cropThumbnailImage(300, 200, true);
        $in_m->writeImage($_SERVER['DOCUMENT_ROOT'].'/'.$folder.$file_middle.'.jpg');
        $in_s = new Imagick();
        $in_s->readImage($_SERVER['DOCUMENT_ROOT'].'/'.$folder.$file);
        $in_s->cropThumbnailImage(180, 180, true);
        $in_s->writeImage($_SERVER['DOCUMENT_ROOT'].'/'.$folder.$file_small.'.jpg');
        unlink($folder.$file);
        $this->UpdateNews($news, $id);
    }
    public function AddNews($row)
    {
        $userModel = new \models\Users();
        $user = $userModel->GetCurrentUser();
        if ($user == null)
        {
            $result = [
                'error' => true,
                'messages' => ['Пользователь не авторизирован']
            ];
            return $result;
        }
        $validateResult = $this->Validate($row);
        if (is_array($validateResult))
        {
            $result = [
                'error' => true,
                'messages' => $validateResult
            ];
            return $result;
        }

        $fields = ['title', 'short_text', 'text', 'type'];
        $rowFiltered = Utils::ArrayFilter($row, $fields);
        $rowFiltered['datetime'] = date('Y-m-d H:i:s');
        $rowFiltered['user_id'] = $user['id'];
        $rowFiltered['photo'] = 'photo';

        $id = \core\Core::getInstance()->getDB()->insert('news', $rowFiltered);
        return [
            'error' => false,
            'id' => $id
        ];
    }

    public function GetLastNews($count)
    {
        return \core\Core::getInstance()->getDB()->select('news', '*', null, ['datetime' => 'DESC'], $count);
    }
    public function GetNews()
    {
        return \core\Core::getInstance()->getDB()->select('news', '*', null);
    }
    public function GetNewsById($id)
    {
        $news = \core\Core::getInstance()->getDB()->select('news', '*', ['id' => $id]);
        if (!empty($news))
            return $news[0];
        else
            return null;
    }

    public function UpdateNews($row, $id)
    {
        $userModel = new \models\Users();
        $user = $userModel->GetCurrentUser();
        if ($user == null)
            return false;
        $validateResult = $this->Validate($row);
        if (is_array($validateResult))
            return $validateResult;
        $fields = ['title', 'short_text', 'text', 'type', 'photo'];
        $rowFiltered = Utils::ArrayFilter($row, $fields);
        $rowFiltered['datetime_lastedit'] = date('Y-m-d H:i:s');
        //$rowFiltered['user_id'] = $user['id'];
        //$rowFiltered['photo'] = 'photo';

        \core\Core::getInstance()->getDB()->update('news', $rowFiltered, ['id' => $id]);
        return true;

    }

    public function DeleteNews($id)
    {
        $news = $this->GetNewsById($id);
        $userModel = new \models\Users();
        $user = $userModel->GetCurrentUser();
        if (empty($news) || empty($user) || $user['id'] != $news['user_id'])
            return false;
        \core\Core::getInstance()->getDB()->delete('news', ['id' => $id]);
        return true;
    }

    public function Validate($row)
    {
        $errors = [];
        if (empty($row['title']))
            $errors [] = 'Поле "Заголовок новости" не может быть пустым';
        if (empty($row['short_text']))
            $errors [] = 'Поле "Краткий текст" не может быть пустым';
        if (empty($row['text']))
            $errors [] = 'Поле "Полный текст" не может быть пустым';

        if (count($errors) > 0)
            return $errors;
        else
            return true;
    }
}