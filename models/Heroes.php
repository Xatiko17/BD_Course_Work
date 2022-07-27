<?php

namespace models;


use core\Utils;
use Imagick;

class Heroes extends \core\Model
{
    public function ChangePhoto($id, $file, $type)
    {
        $folder = 'files/heroes/';
        $file_path = pathinfo($folder.$file);
        $hero = $this->GetHeroById($id);
        if ($type == 'photo')
        {
            $file_name = $file_path['filename'].'_hero';
            if (is_file($folder.$hero['photo'].'_hero.jpg') && is_file($folder.$file))
                unlink($folder.$hero['photo'].'_hero.jpg');
            $hero['photo'] = $file_path['filename'];
            $in = new Imagick();
            $in->readImage($_SERVER['DOCUMENT_ROOT'].'/'.$folder.$file);
            $in->thumbnailImage(360, 640, true);
            $in->writeImage($_SERVER['DOCUMENT_ROOT'].'/'.$folder.$file_name.'.jpg');
            unlink($folder.$file);
            $this->UpdateHero($hero, $id);
        }
        elseif ($type == 'photo_icon')
        {
            $file_name = $file_path['filename'] . '_icon';
            if (is_file($folder.$hero['photo'].'_icon.jpg') && is_file($folder.$file))
                unlink($folder.$hero['photo'].'_icon.jpg');
            $hero['photo_icon'] = $file_path['filename'];
            $in = new Imagick();
            $in->readImage($_SERVER['DOCUMENT_ROOT'].'/'.$folder.$file);
            $in->cropThumbnailImage(80, 80, true);
            $in->writeImage($_SERVER['DOCUMENT_ROOT'].'/'.$folder.$file_name.'.jpg');
            unlink($folder.$file);
            $this->UpdateHero($hero, $id);
        }
        else {
            $skill = $this->GetSkillById($id);
            $file_name = $file_path['filename'].'_skill';
            if (is_file($folder.$skill['photo_skill'].'_skill.jpg') && is_file($folder.$file))
                unlink($folder.$skill['photo_skill'].'_skill.jpg');
            $skill['photo_skill'] = $file_path['filename'];
            $in = new Imagick();
            $in->readImage($_SERVER['DOCUMENT_ROOT'].'/'.$folder.$file);
            $in->cropThumbnailImage(180, 180, true);
            $in->writeImage($_SERVER['DOCUMENT_ROOT'].'/'.$folder.$file_name.'.jpg');
            unlink($folder.$file);
            $this->UpdateSkill($skill, $id);
        }
    }
    public function AddHero($row)
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
        $keys = array_keys($row);
        $skills = [];
        $i = -1;
        foreach ($keys as $key) {
            if ($key[0] > '0' && $key[0] < '10') {
                $tmp = substr($key, 2);
                if ($tmp == 'name')
                    $i++;
                if (empty($skills[$i][$tmp]))
                    $skills[$i][$tmp] = $row[$key];

            }
        }
        $heroesFields = ['name', 'photo', 'photo_icon', 'attack_type', 'aganim_boost', 'shard_boost',
            'story', 'main_attribute', 'power', 'intelligence', 'agility', 'power_up', 'agility_up',
            'intelligence_up', 'damage', 'health', 'mana', 'armor', 'hp_regen', 'mp_regen',
            'attack_range', 'attack_speed', 'move_speed'];
        $rowHeroesFiltered = Utils::ArrayFilter($row, $heroesFields);
        $id [] = \core\Core::getInstance()->getDB()->insert('heroes', $rowHeroesFiltered);
        $talentsFields = ['lvl_10_1', 'lvl_10_2', 'lvl_15_1', 'lvl_15_2',
                        'lvl_20_1', 'lvl_20_2', 'lvl_25_1', 'lvl_25_2'];
        $rowTalentsFiltered = Utils::ArrayFilter($row, $talentsFields);
        $hero = $this->GetHeroByName($rowHeroesFiltered['name']);
        $rowTalentsFiltered['hero_id'] = $hero['id'];
        $id [] = \core\Core::getInstance()->getDB()->insert('talents', $rowTalentsFiltered);
        $skillFields = ['name', 'photo_skill', 'characteristics', 'description', 'cooldown', 'skill_type',
            'mana_cost', 'damage_type', 'through_immunity', 'dispelled_possibility'];
        foreach ($skills as $skill)
        {
            $rowSkillFiltered = Utils::ArrayFilter($skill, $skillFields);
            $rowSkillFiltered['hero_id'] = $hero['id'];
            $id [] = \core\Core::getInstance()->getDB()->insert('skills', $rowSkillFiltered);
        }
        return [
            'error' => false,
            'id' => $id
        ];
    }
    public function UpdateHero($row, $id)
    {
        $userModel = new \models\Users();
        $user = $userModel->GetCurrentUser();
        if ($user == null || $user['access'] != 2)
            return false;
        $validateResult = $this->Validate($row);
        if (is_array($validateResult))
            return $validateResult;
        $keys = array_keys($row);
        $skills = [];
        $i = -1;
        foreach ($keys as $key) {
            if ($key[0] > '0' && $key[0] < '10') {
                $tmp = substr($key, 2);
                if ($tmp == 'name')
                    $i++;
                if (empty($skills[$i][$tmp]))
                    $skills[$i][$tmp] = $row[$key];

            }
        }
        $heroesFields = ['name', 'photo', 'photo_icon', 'attack_type', 'aganim_boost', 'shard_boost',
            'story', 'main_attribute', 'power', 'intelligence', 'agility', 'power_up', 'agility_up',
            'intelligence_up', 'damage', 'health', 'mana', 'armor', 'hp_regen', 'mp_regen',
            'attack_range', 'attack_speed', 'move_speed'];
        $rowHeroesFiltered = Utils::ArrayFilter($row, $heroesFields);
        \core\Core::getInstance()->getDB()->update('heroes', $rowHeroesFiltered, ['id' =>$id]);
        $talentsFields = ['lvl_10_1', 'lvl_10_2', 'lvl_15_1', 'lvl_15_2',
            'lvl_20_1', 'lvl_20_2', 'lvl_25_1', 'lvl_25_2'];
        $rowTalentsFiltered = Utils::ArrayFilter($row, $talentsFields);
        $hero = $this->GetHeroByName($rowHeroesFiltered['name']);
        $rowTalentsFiltered['hero_id'] = $hero['id'];
        \core\Core::getInstance()->getDB()->update('talents', $rowTalentsFiltered, ['hero_id' => $id]);
        $skillFields = ['name', 'photo_skill', 'characteristics', 'description', 'cooldown', 'skill_type',
            'mana_cost', 'damage_type', 'through_immunity', 'dispelled_possibility'];
        foreach ($skills as $skill)
        {
            $rowSkillFiltered = Utils::ArrayFilter($skill, $skillFields);
            $rowSkillFiltered['hero_id'] = $hero['id'];
            \core\Core::getInstance()->getDB()->update('skills', $rowSkillFiltered, ['hero_id' => $id]);
        }
        return true;
    }
    public function UpdateSkill($row, $id)
    {
        $userModel = new \models\Users();
        $user = $userModel->GetCurrentUser();
        if ($user == null || $user['access'] != 2)
            return false;
        if (is_array($validateResult))
            return $validateResult;

        $skillFields = ['name', 'photo_skill', 'characteristics', 'description', 'cooldown', 'skill_type',
            'mana_cost', 'damage_type', 'through_immunity', 'dispelled_possibility'];

        $rowFiltered = Utils::ArrayFilter($row, $skillFields);
        \core\Core::getInstance()->getDB()->update('skills', $rowFiltered, ['id' => $id]);
        return true;
    }
    public function DeleteHero($id)
    {
        $hero = $this->GetHeroById($id);
        $userModel = new \models\Users();
        $user = $userModel->GetCurrentUser();
        if (empty($hero) || empty($user) || $user['access'] < 2)
            return false;
        $talents = $this->GetTalentsByHeroId($id);
        $skills = $this->GetSkillsByHeroId($id);
        \core\Core::getInstance()->getDB()->delete('heroes', ['id' => $id]);
        \core\Core::getInstance()->getDB()->delete('talents', ['id' => $talents['id']]);
        foreach ($skills as $skill)
            \core\Core::getInstance()->getDB()->delete('skills', ['id' => $skill['id']]);
        return true;
    }

    public function GetHeroes()
    {
        return \core\Core::getInstance()->getDB()->select('heroes', '*', null, ['name'=>'ASC']);
    }
    public function GetHeroById($id)
    {
        $hero = \core\Core::getInstance()->getDB()->select('heroes', '*', ['id' => $id]);
        if (!empty($hero))
            return $hero[0];
        else
            return null;
    }
    public function GetSkillById($id)
    {
        $skill = \core\Core::getInstance()->getDB()->select('skills', '*', ['id' => $id]);
        if (!empty($skill))
            return $skill[0];
        else
            return null;
    }
    public function GetSkillsByHeroId($id)
    {
        $skills = \core\Core::getInstance()->getDB()->select('skills', '*', ['hero_id' => $id]);
        if (!empty($skills))
            return $skills;
        else
            return null;
    }
    public function GetTalentsByHeroId($id)
    {
        $talents = \core\Core::getInstance()->getDB()->select('talents', '*', ['hero_id' => $id]);
        if (!empty($talents))
            return $talents[0];
        else
            return null;
    }
    public function GetHeroByName($name)
    {
        $hero = \core\Core::getInstance()->getDB()->select('heroes', '*', ['name' => $name]);
        if (!empty($hero))
            return $hero[0];
        else
            return null;
    }
    public function Validate($row)
    {
        $errors = [];
        $list = ['power', 'intelligence', 'agility', 'power_up', 'agility_up',
            'intelligence_up', 'damage', 'health', 'mana', 'armor', 'hp_regen', 'mp_regen',
            'attack_range', 'attack_speed', 'move_speed'];
        if (empty($row['name']))
            $errors [] = 'У героя должно быть имя';
        if (empty($row['attack_type']))
            $errors [] = 'У героя должен быть выбран тип атаки';
        if (empty($row['story']))
            $errors [] = 'У героя должна быть история';
        if (empty($row['main_attribute']))
            $errors [] = 'У героя должен быть выбран основной атрибут';
        if (empty($row['name']))
            $errors [] = 'У героя должно быть имя';
        $check = false;
        foreach ($list as $item)
        {
            if (empty($row[$item]))
            {
                $check = true;
                break;
            }
        }
        if (empty($row['name']))
            $errors [] = 'У героя должны быть указаны все атрибуты';

        if (count($errors) > 0)
            return $errors;
        else
            return true;
    }
}