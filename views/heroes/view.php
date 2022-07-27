<?php
$heroModel = new models\Heroes();
$userModel = new \models\Users();
$user = $userModel->GetCurrentUser();
$skills = $heroModel->GetSkillsByHeroId($model['id']);
$talents = $heroModel->GetTalentsByHeroId($model['id']);

?>
<?php if (!empty($user)) : ?>
    <?php if ($user['access'] == 2): ?>
        <a href="/heroes/edit?hero_id==<?= $model['id'] ?>" class="btn btn-success">Редактировать</a>
        <a href="/heroes/delete?hero_id==<?= $model['id'] ?>" class="btn btn-danger">Удалить</a>
        <a href="/guides/add?hero_id=<?= $model['id'] ?>" class="btn btn-primary">Создать гайд</a>
    <?php elseif ($user['access'] >= 0) : ?>
        <a href="/guides/add?hero_id=<?= $model['id'] ?>" class="btn btn-primary">Создать гайд</a>
    <?php endif; ?>
<?php endif; ?>
<div class="hero">
    <div class="info-container">
        <div class="photo_story adapt" style="display: flex; margin-bottom: 15px">
            <div style="width: 380px; height: 380px">
                <? if (is_file('files/heroes/' . $model['photo'] . '_hero.jpg')) : ?>
                    <img style="margin: 10px 15px 10px 0" class="bd-placeholder-img rounded float-start"
                         src="/files/heroes/<?= $model['photo'] ?>_hero.jpg">
                <? endif; ?>
            </div>
            <div class="story" style="margin-left: 20px">
                <h4><?= $model['name'] ?></h4>
                <span style="color: darkgray"><?= $model['attack_type'] ?> бой</span>
                <span style="font-size: 18px"><b><?= $model['main_attribute'] ?></b></span>
                <p><?= $model['story'] ?></p>
            </div>
        </div>
        <div class="stats_talents adapt" style="display: flex; justify-content: space-around; margin-bottom: 15px">
            <table class="stats">
                <tr style="color: red">
                    <td width="250px">
                        <img src="/files/heroes/power.png" width="25">
                        Сила
                    </td>
                    <td width="150px"><?= $model['power'] . '+' . $model['power_up'] ?></td>
                </tr>
                <tr style="color: lawngreen">
                    <td>
                        <img src="/files/heroes/agility.png" width="25">
                        Ловкость
                    </td>
                    <td><?= $model['agility'] . '+' . $model['agility_up'] ?></td>
                </tr>
                <tr style="color: #1a9aef">
                    <td>
                        <img src="/files/heroes/intelligence.png" width="25">
                        Интелект
                    </td>
                    <td><?= $model['intelligence'] . '+' . $model['intelligence_up'] ?></td>
                </tr>
                <tr>
                    <td>
                        <img src="/files/heroes/damage.png" width="25">
                        Урон
                    </td>
                    <td><?= $model['damage'] ?></td>
                </tr>
                <tr>
                    <td>
                        <img src="/files/heroes/armor.png" width="25">
                        Броня
                    </td>
                    <td><?= $model['armor'] ?></td>
                </tr>
                <tr>
                    <td>
                        <img src="/files/heroes/move_speed.png" width="25">
                        Скорость передвижения
                    </td>
                    <td><?= $model['move_speed'] ?></td>
                </tr>
                <tr>
                    <td>Здоровье</td>
                    <td><?= $model['health'] . '+' . $model['hp_regen'] ?></td>
                </tr>
                <tr>
                    <td>Мана</td>
                    <td><?= $model['mana'] . '+' . $model['mp_regen'] ?></td>
                </tr>
                <tr>
                    <td>Скорость атаки</td>
                    <td><?= $model['attack_speed'] ?></td>
                </tr>
                <tr>
                    <td>Дальность атаки</td>
                    <td><?= $model['attack_range'] ?></td>
                </tr>
            </table>
            <table class="talents">
                <tr>
                    <td><?= $talents['lvl_10_1'] ?></td>
                    <td width="40px">
                        <div style="display: inline-block; font-size: 22px;
                        width: 40px; height: 40px;
                        border: 3px solid coral; border-radius: 50%">
                            10
                        </div>
                    </td>
                    <td><?= $talents['lvl_10_2'] ?></td>
                </tr>
                <tr>
                    <td><?= $talents['lvl_15_1'] ?></td>
                    <td>
                        <div style="display: inline-block; font-size: 22px;
                        width: 40px; height: 40px;
                        border: 3px solid coral; border-radius: 50%">
                            15
                        </div>
                    </td>
                    <td><?= $talents['lvl_15_2'] ?></td>
                </tr>
                <tr>
                    <td><?= $talents['lvl_20_1'] ?></td>
                    <td>
                        <div style="display: inline-block; font-size: 22px;
                        width: 40px; height: 40px;
                        border: 3px solid coral; border-radius: 50%">
                            20
                        </div>
                    </td>
                    <td><?= $talents['lvl_20_2'] ?></td>
                </tr>
                <tr>
                    <td><?= $talents['lvl_25_1'] ?></td>
                    <td>
                        <div style="display: inline-block; font-size: 22px;
                        width: 40px; height: 40px;
                        border: 3px solid coral; border-radius: 50%">
                            25
                        </div>
                    </td>
                    <td><?= $talents['lvl_25_2'] ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="skills" style="display: flex; flex-direction: column">
        <h3>Способности</h3>
        <?php foreach ($skills

                       as $skill) : ?>
            <div class="adapt" style="margin-bottom: 20px; display: flex">
                <img src="/files/heroes/<?= $skill['photo_skill'] ?>_skill.jpg"
                     width="180px" height="180px" style="margin: 15px 15px 0 0">
                <div style="width: 100%">
                    <h5><?= $skill['name'] ?></h5>
                    <span>Тип: <?= $skill['skill_type'] ?></span><br>
                    <?php if (!empty($skill['damage_type'])) : ?>
                        <span>Тип урона: <?= $skill['damage_type'] ?></span><br>
                    <?php endif; ?>
                    <?php if (!empty($skill['through_immunity'])) : ?>
                        <span>Сквозь невосприимчевость к магии: <?= $skill['through_immunity'] ?></span><br>
                    <?php endif; ?>
                    <?php if (!empty($skill['dispelled_possibility'])) : ?>
                        <span>Можно развеять: <?= $skill['dispelled_possibility'] ?></span><br>
                    <?php endif; ?>
                    <p style="margin-top: 15px"><?= $skill['description'] ?></p>
                </div>
            </div>
            <div>
                <?php if (!empty($skill['mana_cost']) || !empty($skill['cooldown'])) : ?>
                    <div class="adapt" style="display: flex; justify-content: space-between; align-items: end">
                        <pre><?= $skill['characteristics'] ?></pre>
                        <div>
                            <?php if (!empty($skill['mana_cost'])) : ?>
                                <span>
                                <img width="20" src="/files/heroes/mana.png">
                                <?= $skill['mana_cost'] ?>
                            </span>
                            <?php endif; ?>
                            <?php if (!empty($skill['cooldown'])) : ?>
                                <span>
                                <img width="20" src="/files/heroes/cooldown.png">
                                <?= $skill['cooldown'] ?>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else : ?>
                    <pre><?= $skill['characteristics'] ?></pre>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

    </div>
</div>