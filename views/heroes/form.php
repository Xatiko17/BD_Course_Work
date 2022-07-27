<?php
$heroModel = new models\Heroes();

$skills = $heroModel->GetSkillsByHeroId($model['id']);
$talents = $heroModel->GetTalentsByHeroId($model['id']);
?>


<form method="post" action="" enctype="multipart/form-data" id="form">
    <fieldset>
        <legend>Герой</legend>
        <div class="mb-3">
            <label for="name" class="form-label">Имя героя</label>
            <input type="text" name="name" value="<?= $model['name'] ?>" class="form-control" id="name">
        </div>
        <div class="mb-3">
            <label for="story" class="form-label">История героя</label>
            <textarea name="story" class="form-control" id="story"><?= $model['story'] ?></textarea>
        </div>
        <div class="mb-3">
            <label for="photo" class="form-label">Фото героя</label>
            <input type="file" accept="image/jpeg, image/png" name="photo" class="form-control" id="photo">
        </div>
        <div class="mb-3">
            <? if (is_file('files/heroes/' . $model['photo'] . '_hero.jpg')) : ?>
                <img src="/files/heroes/<?= $model['photo'] ?>_hero.jpg">
            <? endif; ?>
        </div>
        <div class="mb-3">
            <label for="photo_icon" class="form-label">Иконка героя</label>
            <input type="file" accept="image/jpeg, image/png" name="photo_icon" class="form-control" id="photo_icon">
        </div>
        <div class="mb-3">
            <? if (is_file('files/heroes/' . $model['photo_icon'] . '_icon.jpg')) : ?>
                <img src="/files/heroes/<?= $model['photo_icon'] ?>_icon.jpg">
            <? endif; ?>
        </div>
        <label for="main_attribute">Основной атриут</label>
        <select id="main_attribute" name="main_attribute">
            <option value="Сила">Сила</option>
            <option value="Ловкость">Ловкость</option>
            <option value="Интелект">Интелект</option>
        </select>
        <div class="mb-3">
            <label class="form-label"">Вид атаки</label><br>
            <input type="radio" name="attack_type" value="Дальний" id="type1" checked>
            <label for="type1" class="form-label">Дальний</label>
            <input type="radio" name="attack_type" value="Ближний" id="type2">
            <label for="type2" class="form-label">Ближний</label>
        </div>
        <div class="mb-3">
            <label for="aganim_boost" class="form-label">Улучшение от Aganim's Scipetr</label>
            <textarea name="aganim_boost" class="form-control"
                      id="aganim_boost"><?= $model['aganim_boost'] ?></textarea>
        </div>
        <div class="mb-3">
            <label for="shard_boost" class="form-label">Улучшение от Aganim's Shard</label>
            <textarea name="shard_boost" class="form-control" id="shard_boost"><?= $model['shard_boost'] ?></textarea>
        </div>
    </fieldset>
    <fieldset>
        <legend>Таланты</legend>
        <div class="mb-3">
            <label for="lvl_10_1" class="form-label">Левый талант 10 уровня</label>
            <textarea name="lvl_10_1" class="form-control" id="lvl_10_1"><?= $talents['lvl_10_1'] ?></textarea>
        </div>
        <div class="mb-3">
            <label for="lvl_10_2" class="form-label">Правый талант 10 уровня</label>
            <textarea name="lvl_10_2" class="form-control" id="lvl_10_2"><?= $talents['lvl_10_2'] ?></textarea>
        </div>
        <div class="mb-3">
            <label for="lvl_15_1" class="form-label">Левый талант 15 уровня</label>
            <textarea name="lvl_15_1" class="form-control" id="lvl_15_1"><?= $talents['lvl_15_1'] ?></textarea>
        </div>
        <div class="mb-3">
            <label for="lvl_15_2" class="form-label">Правый талант 15 уровня</label>
            <textarea name="lvl_15_2" class="form-control" id="lvl_15_2"><?= $talents['lvl_15_2'] ?></textarea>
        </div>
        <div class="mb-3">
            <label for="lvl_20_1" class="form-label">Левый талант 20 уровня</label>
            <textarea name="lvl_20_1" class="form-control" id="lvl_20_1"><?= $talents['lvl_20_1'] ?></textarea>
        </div>
        <div class="mb-3">
            <label for="lvl_20_2" class="form-label">Правый талант 20 уровня</label>
            <textarea name="lvl_20_2" class="form-control" id="lvl_20_2"><?= $talents['lvl_20_2'] ?></textarea>
        </div>
        <div class="mb-3">
            <label for="lvl_25_1" class="form-label">Левый талант 25 уровня</label>
            <textarea name="lvl_25_1" class="form-control" id="lvl_25_1"><?= $talents['lvl_25_1'] ?></textarea>
        </div>
        <div class="mb-3">
            <label for="lvl_25_2" class="form-label">Правый талант 25 уровня</label>
            <textarea name="lvl_25_2" class="form-control" id="lvl_25_2"><?= $talents['lvl_25_2'] ?></textarea>
        </div>
    </fieldset>
    <fieldset>
        <legend>Характеристики</legend>
        <table>
            <tr>
                <th>Название</th>
                <th>Значение</th>
            </tr>
            <tr>
                <td>
                    <label for="power" class="form-label">Сила</label>
                </td>
                <td>
                    <input type="number" name="power" value="<?= $model['power'] ?>" class="form-control" id="power">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="power_up" class="form-label">Прирост силы</label>
                </td>
                <td>
                    <input type="number" step="0.1" name="power_up" value="<?= $model['power_up'] ?>"
                           class="form-control" id="power_up">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="agility" class="form-label">Ловкость</label>
                </td>
                <td>
                    <input type="number" name="agility" value="<?= $model['agility'] ?>" class="form-control"
                           id="agility">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="agility_up" class="form-label">Прирост ловкости</label>
                </td>
                <td>
                    <input type="number" step="0.1" name="agility_up" value="<?= $model['agility_up'] ?>"
                           class="form-control" id="agility_up">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="intelligence" class="form-label">Интелект</label>
                </td>
                <td>
                    <input type="number" name="intelligence" value="<?= $model['intelligence'] ?>" class="form-control"
                           id="intelligence">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="intelligence_up" class="form-label">Прирост интелекта</label>
                </td>
                <td>
                    <input type="number" step="0.1" name="intelligence_up" value="<?= $model['intelligence_up'] ?>"
                           class="form-control" id="intelligence_up">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="health" class="form-label">Здоровье</label>
                </td>
                <td>
                    <input type="number" name="health" value="<?= $model['health'] ?>" class="form-control" id="health">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="mana" class="form-label">Мана</label>
                </td>
                <td>
                    <input type="number" name="mana" value="<?= $model['mana'] ?>" class="form-control" id="mana">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="move_speed" class="form-label">Скорость передвижения</label>
                </td>
                <td>
                    <input type="number" name="move_speed" value="<?= $model['move_speed'] ?>" class="form-control" id="move_speed">
                </td>
            </tr>
            <tr>
            <tr>
                <td>
                    <label for="damage" class="form-label">Урон</label>
                </td>
                <td>
                    <input type="number" name="damage" value="<?= $model['damage'] ?>" class="form-control" id="damage">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="armor" class="form-label">Броня</label>
                </td>
                <td>
                    <input type="number" name="armor" value="<?= $model['armor'] ?>" class="form-control" id="armor">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="attack_speed" class="form-label">Скорость атаки</label>
                </td>
                <td>
                    <input type="number" name="attack_speed" value="<?= $model['attack_speed'] ?>" class="form-control"
                           id="attack_speed">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="attack_range" class="form-label">Дальность атаки</label>
                </td>
                <td>
                    <input type="number" name="attack_range" value="<?= $model['attack_range'] ?>" class="form-control"
                           id="attack_range">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="hp_regen" class="form-label">Регенерация здоровья</label>
                </td>
                <td>
                    <input type="number" step="0.1" name="hp_regen" value="<?= $model['hp_regen'] ?>"
                           class="form-control"
                           id="hp_regen">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="mp_regen" class="form-label">Регенерация маны</label>
                </td>
                <td>
                    <input type="number" step="0.1" name="mp_regen" value="<?= $model['mp_regen'] ?>"
                           class="form-control"
                           id="mp_regen">
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset>
        <?php for ($i = 1; $i < 5; $i++) : ?>
            <legend>Способность <?= $i ?></legend>
            <div class="mb-3">
                <label for="<?= $i ?>_name" class="form-label">Название способности</label>
                <input type="text" name="<?= $i ?>_name" value="<?= $skills[$i - 1]['name'] ?>" class="form-control"
                       id="<?= $i ?>_name">
            </div>
            <div class="mb-3">
                <label for="<?= $i ?>_description" class="form-label">Описание</label>
                <textarea name="<?= $i ?>_description" class="form-control"
                          id="<?= $i ?>_description"><?= $skills[$i - 1]['description'] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="<?= $i ?>_characteristics" class="form-label">Характеристики</label>
                <textarea name="<?= $i ?>_characteristics" class="form-control"
                          id="<?= $i ?>_characteristics"><?= $skills[$i - 1]['characteristics'] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="<?= $i ?>_mana_cost" class="form-label">Стоимость маны</label>
                <input type="text" name="<?= $i ?>_mana_cost" value="<?= $skills[$i - 1]['mana_cost'] ?>"
                       class="form-control"
                       id="<?= $i ?>_mana_cost">
            </div>
            <div class="mb-3">
                <label for="<?= $i ?>_cooldown" class="form-label">Перезарядка</label>
                <input type="text" name="<?= $i ?>_cooldown" value="<?= $skills[$i - 1]['cooldown'] ?>"
                       class="form-control"
                       id="<?= $i ?>_cooldown">
            </div>
            <div class="mb-3">
                <label for="<?= $i ?>_skill_type">Тип способности</label>
                <select id="<?= $i ?>_skill_type" name="<?= $i ?>_skill_type">
                    <option value="Пасивная" <?php if ($skills[$i - 1]['skill_type'] == 'Пассивная') echo 'selected' ?>>
                        Пассивная
                    </option>
                    <option value="Направленная на юнита" <?php if ($skills[$i - 1]['skill_type'] == 'Направленная на юнита') echo 'selected' ?>>
                        Направленная на юнита
                    </option>
                    <option value="Ненаправленная" <?php if ($skills[$i - 1]['skill_type'] == 'Ненаправленная') echo 'selected' ?>>
                        Ненаправленная
                    </option>
                    <option value="Направленная на область" <?php if ($skills[$i - 1]['skill_type'] == 'Направленная на область') echo 'selected' ?>>
                        Направленная на область
                    </option>
                    <option value="Аура" <?php if ($skills[$i - 1]['skill_type'] == 'Аура') echo 'selected' ?>>Аура
                    </option>
                    <option value="Направленная на точку" <?php if ($skills[$i - 1]['skill_type'] == 'Направленная на точку') echo 'selected' ?>>
                        Направленная на точку
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label"">Тип урона</label><br>
                <input type="radio" name="<?= $i ?>_damage_type" value="Чистый"
                    <?php if ($skills[$i - 1]['damage_type'] == 'Чистый') echo 'checked' ?> id="<?= $i ?>_damage_type1">
                <label for="<?= $i ?>_damage_type1" class="form-label">Чистый</label>
                <input type="radio" name="<?= $i ?>_damage_type" value="Магический"
                    <?php if ($skills[$i - 1]['damage_type'] == 'Магический') echo 'checked' ?>
                       id="<?= $i ?>_damage_type2">
                <label for="<?= $i ?>_damage_type2" class="form-label">Магический</label>
                <input type="radio" name="<?= $i ?>_damage_type" value="Физический"
                    <?php if ($skills[$i - 1]['damage_type'] == 'Физический') echo 'checked' ?>
                       id="<?= $i ?>_damage_type3">
                <label for="<?= $i ?>_damage_type3" class="form-label">Физический</label>
            </div>
            <div class="mb-3">
                <label class="form-label"">Сквозь иммунитет к магии</label><br>
                <input type="radio" name="<?= $i ?>_through_immunity" value="Да"
                    <?php if ($skills[$i - 1]['through_immunity'] == 'Да') echo 'checked' ?>
                       id="<?= $i ?>_through_immunity1">
                <label for="<?= $i ?>_through_immunity1" class="form-label">Да</label>
                <input type="radio" name="<?= $i ?>_through_immunity" value="Нет"
                    <?php if ($skills[$i - 1]['through_immunity'] == 'Нет') echo 'checked' ?>
                       id="<?= $i ?>_through_immunity2">
                <label for="<?= $i ?>_through_immunity2" class="form-label">Нет</label>
            </div>
            <div class="mb-3">
                <label class="form-label"">Можно развеять</label><br>
                <input type="radio" name="<?= $i ?>_dispelled_possibility" value="Да"
                    <?php if ($skills[$i-1]['dispelled_possibility'] == 'Да') echo 'checked'?>
                       id="<?= $i ?>_dispelled_possibility1">
                <label for="<?= $i ?>_dispelled_possibility1" class="form-label">Да</label>
                <input type="radio" name="<?= $i ?>_dispelled_possibility" value="Нет"
                    <?php if ($skills[$i-1]['dispelled_possibility'] == 'Нет') echo 'checked'?>
                       id="<?= $i ?>_dispelled_possibility2">
                <label for="<?= $i ?>_dispelled_possibility2" class="form-label">Нет</label>
            </div>
            <div class="mb-3">
                <label for="<?= $i ?>_photo_skill" class="form-label">Фото способности</label>
                <input type="file" accept="image/jpeg, image/png" name="<?= $i ?>_photo_skill" class="form-control"
                       id="<? $i ?>_photo_skill">
            </div>
            <div class="mb-3">
                <? if (is_file('files/heroes/' . $skills[$i-1]['photo_skill'] . '_skill.jpg')) : ?>
                    <img src="/files/heroes/<?= $skills[$i-1]['photo_skill'] ?>_skill.jpg">
                <? endif; ?>
            </div>
        <? endfor; ?>
    </fieldset>
    <button type="submit" class="btn btn-primary">Сохранить</button>

</form>