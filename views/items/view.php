<?php
$itemModel = new models\Items();
$userModel = new \models\Users();
$user = $userModel->GetCurrentUser();
?>
<?php if ($user['access'] == 2): ?>
    <a href="/items/edit?id=<?= $model['id'] ?>" class="btn btn-success">Редактировать</a>
    <a href="/items/delete?id=<?= $model['id'] ?>" class="btn btn-danger">Удалить</a>
<?php endif; ?>
<div class="item">
    <div >
        <? if (is_file('files/items/' . $model['photo'] . '_b.jpg')) : ?>
            <img style="margin: 10px 15px 10px 0" class="bd-placeholder-img rounded float-start" src="/files/items/<?= $model['photo'] ?>_b.jpg">
        <? endif; ?>
    </div>
    <div class="info-container">
        <div>
            <h4><?= $model['name'] ?></h4>
        </div>
        <div>
            <?= $model['price'] ?>
            <img src="/files/items/gold.png">
        </div>
        <div style="color: silver; margin-bottom: 15px">
            <?= $model['description'] ?>
        </div>
        <div>
            <?php if (!empty($model['active'])) : ?>
                <h5>Активный эффект</h5>
                <?= $model['active'] ?>
            <?php endif; ?>
            <?php if (!empty($model['passive'])) : ?>
                <h5>Пассивный эффект</h5>
                <?= $model['passive'] ?>
            <?php endif; ?>
        </div>
        <div>
            <?= $model['attributes'] ?>
        </div>
    </div>
</div>