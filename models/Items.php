<?php

namespace models;

use core\Utils;
use Imagick;

class Items extends \core\Model
{
    public function ChangePhoto($id, $file)
    {
        $folder = 'files/items/';
        $file_path = pathinfo($folder.$file);
        $file_big =  $file_path['filename'].'_b';
        $file_middle =  $file_path['filename'].'_m';
        $file_small =  $file_path['filename'].'_s';
        $item = $this->GetItemById($id);
        if (is_file($folder.$item['photo'].'_b.jpg') && is_file($folder.$file))
            unlink($folder.$item['photo'].'_b.jpg');
        if (is_file($folder.$item['photo'].'_m.jpg') && is_file($folder.$file))
            unlink($folder.$item['photo'].'_m.jpg');
        if (is_file($folder.$item['photo'].'_s.jpg') && is_file($folder.$file))
            unlink($folder.$item['photo'].'_s.jpg');
        $item['photo'] = $file_path['filename'];
        $in_b = new Imagick();
        $in_b->readImage($_SERVER['DOCUMENT_ROOT'].'/'.$folder.$file);
        $in_b->cropThumbnailImage(480, 320, true);
        $in_b->writeImage($_SERVER['DOCUMENT_ROOT'].'/'.$folder.$file_big.'.jpg');
        $in_m = new Imagick();
        $in_m->readImage($_SERVER['DOCUMENT_ROOT'].'/'.$folder.$file);
        $in_m->cropThumbnailImage(180, 135, true);
        $in_m->writeImage($_SERVER['DOCUMENT_ROOT'].'/'.$folder.$file_middle.'.jpg');
        $in_s = new Imagick();
        $in_s->readImage($_SERVER['DOCUMENT_ROOT'].'/'.$folder.$file);
        $in_s->cropThumbnailImage(60, 60, true);
        $in_s->writeImage($_SERVER['DOCUMENT_ROOT'].'/'.$folder.$file_small.'.jpg');
        unlink($folder.$file);
        $this->UpdateItem($item, $id);
    }
    public function AddItem($row)
    {
        $userModel = new \models\Users();
        $user = $userModel->GetCurrentUser();
        if ($user == null || $user['access'] < 2)
        {
            $result = [
                'error' => true,
                'messages' => ['Недостаточно прав']
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
        $fields = ['name', 'price', 'type', 'photo', 'shop_type', 'neutral_type',
            'description', 'active', 'passive', 'attributes'];
        $rowFiltered = Utils::ArrayFilter($row, $fields);

        $id = \core\Core::getInstance()->getDB()->insert('items', $rowFiltered);
        return [
            'error' => false,
            'id' => $id
        ];
    }
    public function UpdateItem($row, $id)
    {
        $userModel = new \models\Users();
        $user = $userModel->GetCurrentUser();
        if ($user == null || $user['access'] != 2)
            return false;
        $validateResult = $this->Validate($row);
        if (is_array($validateResult))
            return $validateResult;
        $fields = ['name', 'price', 'type', 'photo', 'shop_type', 'neutral_type',
            'description', 'active', 'passive', 'attributes'];
        $rowFiltered = Utils::ArrayFilter($row, $fields);

        \core\Core::getInstance()->getDB()->update('items', $rowFiltered, ['id' => $id]);
        return true;
    }

    public function DeleteItem($id)
    {
        $item = $this->GetItemById($id);
        $userModel = new \models\Users();
        $user = $userModel->GetCurrentUser();
        if (empty($item) || empty($user) || $user['access'] != 2)
            return false;
        \core\Core::getInstance()->getDB()->delete('items', ['id' => $id]);
        return true;
    }


    public function GetItemsByType() {
        $items = \core\Core::getInstance()->getDB()->select('items', '*');
        foreach ($items as $item)
            if (!empty($item['shop_type']))
                $result[$item['shop_type']] [] = $item;
        return $result;
    }
    public function GetItemById($id)
    {
        $items = \core\Core::getInstance()->getDB()->select('items', '*', ['id' => $id]);
        if (!empty($items))
            return $items[0];
        else
            return null;
    }
    public function GetItemByName($name)
    {
        $items = \core\Core::getInstance()->getDB()->select('items', '*', ['name' => $name]);
        if (!empty($items))
            return $items[0];
        else
            return null;
    }
    public function  GetAllItems()
    {
        $items = \core\Core::getInstance()->getDB()->select('items', '*');
        if (!empty($items))
            return $items;
        else
            return null;
    }

    public function Validate($row)
    {
        $errors = [];
        if (empty($row['name']))
            $errors [] = 'Поле "Название" не может быть пустым';
        if (empty($row['type']))
            $errors [] = 'Вид предмета должен быть выбран';
        else {
            if ($row['type'] == 'shop' && empty($row['price'])){
                $errors [] = 'Если этот предмет из "Лавки" цена должна быть указана';
            }
            if ($row['type'] == 'neutral' && empty($row['grade'])){
                $errors [] = 'Если этот предмет "Нейтральный" разряд должен быть указан';
            }
        }
        if (empty($row['description']))
            $errors [] = 'Поле "Описание" не может быть пустым';
        if (empty($row['attributes']))
            $errors [] = 'Поле "Атрибуты" не может быть пустым';

        if (count($errors) > 0)
            return $errors;
        else
            return true;
    }
}