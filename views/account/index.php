<?php
$userModel = new \models\Users();
$heroModel = new \models\Heroes();
$newsModel = new \models\News();
$itemModel = new \models\Items();
$guideModel = new \models\Guides();
$guide = $guideModel->GetBestGuides()[0];
$user = $userModel->GetCurrentUser();
?>
<?php if (!empty($guides)) : ?>
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
<?php else : ?>
<p>У вас пока нету созданных гайдов,
    перейдите во вкладку желаемого героя и создайте один</p>
<?php endif; ?>
<?php if ($user['access'] == 2) : ?>
    <div class="statistic">
        <h2>Некоторая статистика</h2>
        <table>
            <tr>
                <td width="300px">Пользователей зарегестрировано</td>
                <td><?= count($userModel->GetUsers()) ?></td>
            </tr>
            <tr>
                <td>Новостей опубликовано</td>
                <td><?= count($newsModel->GetNews()) ?></td>
            </tr>
            <tr>
                <td>Героев добавлено</td>
                <td><?= count($heroModel->GetHeroes()) ?></td>
            </tr>
            <tr>
                <td>Предметов добавлено</td>
                <td><?= count($itemModel->GetAllItems()) ?></td>
            </tr>
            <tr>
                <td>Гайдов сделано</td>
                <td><?= count($guideModel->GetGuides()) ?></td>
            </tr>
        </table>
    </div>
    <div class="popular-guide">
        <h2>Самый популярный гайд</h2>
        <h4><?= $guide['name'] ?></h4>
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
<?php endif; ?>