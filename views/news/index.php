<?php
$userModel = new \models\Users();
$user = $userModel->GetCurrentUser();
?>
<? if ($user['access'] > 0) : ?>
    <a href="/news/add" class="btn btn-success">Добавить новость</a>
<? endif; ?>
<?php foreach ($lastNews as $news) : ?>
    <div class="news-record">
        <h3><?= $news['title'] ?></h3>
        <span style="color: #868E96"><?= $news['type']?></span>
        <div class="photo">
            <? if (is_file('files/news/' . $news['photo'] . '_s.jpg')) : ?>
                <img class="bd-placeholder-img rounded float-start" src="/files/news/<?= $news['photo'] ?>_s.jpg">
            <? else: ?>
                <svg class="bd-placeholder-img rounded float-start" width="200" height="200"
                     xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice"
                     focusable="false">
                    <rect width="100%" height="100%" fill="#868e96"></rect>
                </svg>
            <? endif; ?>
        </div>
        <div>
            <?= $news['short_text'] ?>
        </div>
        <div>
            <a href="/news/view?id=<?= $news['id'] ?>" class="btn btn-primary">Просмотреть</a>
            <? if ($news['user_id'] == $user['id']) : ?>
                <a href="/news/edit?id=<?= $news['id'] ?>" class="btn btn-success">Редактировать</a>
                <a href="/news/delete?id=<?= $news['id'] ?>" class="btn btn-danger">Удалить</a>
            <? endif; ?>
        </div>
    </div>
<?php endforeach; ?>

