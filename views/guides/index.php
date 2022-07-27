<?php
$userModel = new \models\Users();
$heroModel = new \models\Heroes();
$user = $userModel->GetCurrentUser();
?>
<?php foreach ($guides as $guide) : ?>
    <div class="news-record">
        <h3><?= $guide['name'] ?></h3>
        <div class="photo">
            <? if (is_file('files/heroes/' . $heroModel->GetHeroById($guide['hero_id'])['photo_icon'] . '_icon.jpg')) : ?>
                <img class="bd-placeholder-img rounded float-start" src="/files/heroes/<?= $heroModel->GetHeroById($guide['hero_id'])['photo_icon'] ?>_icon.jpg">
            <? else: ?>
                <svg class="bd-placeholder-img rounded float-start" width="200" height="200"
                     xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice"
                     focusable="false">
                    <rect width="100%" height="100%" fill="#868e96"></rect>
                </svg>
            <? endif; ?>
        </div>
        <div>
            <?= $userModel->GetUserById($guide['user_id'])['login'] ?>
        </div>
        <div>
            <?= $guide['description'] ?>
        </div>
        <div>
            <a href="/guides/view?id=<?= $guide['id'] ?>" class="btn btn-primary">Посмотреть</a>
            <? if ($guide['user_id'] == $user['id'] || $user['access'] >= 1) : ?>
                <a href="/guides/edit?id=<?= $guide['id'] ?>&hero_id=<?= $guide['hero_id'] ?>" class="btn btn-success">Редактировать</a>
                <a href="/guides/delete?id=<?= $guide['id'] ?>" class="btn btn-danger">Удалить</a>
            <? endif; ?>
        </div>
    </div>
<?php endforeach; ?>