<?php
$shopSections = ['Начальный закуп', 'Начало игры',
    'Середина игры', 'Конец игры', 'Другое'];
$heroModel = new \models\Heroes();
$itemsModel = new \models\Items();
$userModel = new \models\Users();
$guideModel = new \models\Guides();
$hero = $heroModel->GetHeroById($model['hero_id']);
$skills_up = explode(';', $model['post']);
array_pop($skills_up);
$comments = $guideModel->GetCommentsByGuideId($model['id']);
$rowItems = nl2br($model['items'], false);
$rowItems = preg_replace('#(<br>[\r\n]+){2}#', '</p><p>', $rowItems);
$rowItems = explode('<br>', $rowItems);
array_pop($rowItems);
for ($i = 0; $i < count($rowItems); $i++) {
    $items [$shopSections[$i]] = explode(';', $rowItems[$i]);
    array_pop($items [$shopSections[$i]]);
    array_shift($items [$shopSections[$i]]);
}
$likes = 0;
$dislikes = 0;
$result = countLikes($comments);
$likes = $result['likes'];
$dislikes = $result['dislikes'];
function countLikes($comments)
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

?>
<div class="guide">
    <div style="display: flex;">
        <div>
            <img style="margin: 10px 20px 20px 0" width="180" src="/files/heroes/<?= $hero['photo_icon'] ?>_icon.jpg">
        </div>
        <div style="margin: 10px 0 20px 0">
            <span style="color: darkgray">Гайд создан пользвователем <?= $userModel->GetUserById($model['user_id'])['login'] ?></span>
            <p style="font-size: 24px"><?= $model['description'] ?></p>
            <div>
                <img width="35" style="margin-right: 15px" src="/files/like.jpg"><span
                        style="font-size: 20px;margin-right: 15px"><?= $likes ?></span>
                <img width="35" style="margin-right: 15px" src="/files/dislike.jpg"><span
                        style="font-size: 20px;margin-right: 15px"><?= $dislikes ?></span>
            </div>
            <span style="color: darkgray"><?= $model['datetime'] ?></span>
        </div>
    </div>
    <h4>Порядок улучшения способностей</h4>
    <div>
        <table>
            <?php for ($i = 0;
                       $i < count($skills_up) / 2;
                       $i += 1) : ?>
                <tr>
                    <td>Уровень <?= $i + 1 ?>:</td>
                    <td>
                        <?php if ($skills_up[$i] == 'atr') : ?>
                            <img width="40" src="/files/heroes/plus.jpg">
                        <?php elseif (strstr($skills_up[$i], 'lvl') != false) : ?>
                            <img width="40" src="/files/heroes/talent.jpg">
                            <?= $heroModel->GetTalentsByHeroId($model['hero_id'])[$skills_up[$i]] ?>
                        <?php else: ?>
                            <img width="40"
                                 src="/files/heroes/<?= $heroModel->GetSkillById($skills_up[$i])['photo_skill'] ?>_skill.jpg">
                        <? endif; ?>
                    </td>
                    <td>Уровень <?= $i + count($skills_up) / 2 + 1 ?>:</td>
                    <td>
                        <?php if ($skills_up[$i + count($skills_up) / 2] == 'atr') : ?>
                            <img width="40" src="/files/heroes/plus.jpg">
                        <?php elseif (strstr($skills_up[$i + count($skills_up) / 2], 'lvl') != false) : ?>
                            <img width="40" src="/files/heroes/talent.jpg">
                            <?= $heroModel->GetTalentsByHeroId($model['hero_id'])[$skills_up[$i + count($skills_up) / 2]] ?>
                        <?php else: ?>
                            <img width="40"
                                 src="/files/heroes/<?= $heroModel->GetSkillById($skills_up[$i + count($skills_up) / 2])['photo_skill'] ?>_skill.jpg">
                        <? endif; ?>
                    </td>

                </tr>
            <?php endfor; ?>
        </table>
    </div>
    <div class="adapt" style="margin-top: 20px; display: flex; justify-content: space-between">
        <div>
            <?php for ($i = 0; $i < 4; $i++) : ?>
                <?php if (!empty($model['skill_comment_' . $i])) : ?>
                    <div style="margin-bottom: 20px">
                        <img width="100"
                             src="/files/heroes/<?= $heroModel->GetSkillsByHeroId($hero['id'])[$i]['photo_skill'] ?>_skill.jpg">
                        <span style="font-size: 20px"><?= $model['skill_comment_' . $i] ?></span>
                    </div>
                <?php endif; ?>
            <? endfor; ?>
        </div>
        <div style="text-align: center; margin-right: 20px">
            <?php for ($i = 0; $i < count($shopSections); $i++) : ?>
                <h5><?= $shopSections[$i] ?></h5>
                <div>
                    <?php foreach ($items[$shopSections[$i]] as $item) : ?>
                        <img src="/files/items/<?= $itemsModel->GetItemById($item)['photo'] ?>_s.jpg">
                    <?php endforeach; ?>
                    <p style="color: darkgray; font-size: 14px"><?= $model['comment_' . $i] ?></p>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</div>
<?php if (empty($userModel->GetCurrentUser())) : ?>
    <p style="color: darkgray; font-size: 20px">Для комментирования нужно авторизоваться</p>
<?php else : ?>
    <a href="/guides/comment?id=<?= $model['id'] ?>" class="btn btn-primary">Написать комментарий</a>
<?php endif; ?>
<div style="margin-top: 20px" class="comments">
    <?php foreach ($comments as $comment) : ?>
        <div style="border: 1px solid whitesmoke; padding: 10px; margin-top: 15px">
            <p>Пользователь: <?= $userModel->GetUserById($comment['user_id'])['login'] ?></p>

            <?php if ($comment['liked'] == 'true') : ?>
                <img width="35" style="margin-right: 15px" src="/files/like.jpg">
            <?php else : ?>
                <img width="35" style="margin-right: 15px" src="/files/dislike.jpg">
            <?php endif; ?>
            <span style="font-size: 16px">
                <?= $comment['text'] ?>
            </span>
            <p style="font-size: 12px; color: darkgray; align-self: end;"><?= $comment['datetime'] ?></p>

        </div>
        <?php if ($userModel->GetCurrentUser()['id'] == $comment['user_id'] || $userModel->GetCurrentUser()['access'] >= 1) : ?>
            <a href="/guides/refactor?id=<?= $comment['id'] ?>" class="btn btn-primary">Редактировать комментарий</a>
            <a href="/guides/ban?id=<?= $comment['id'] ?>" class="btn btn-danger">Удалить комментарий</a>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
