<?php
$userModel = new \models\Users();
$user = $userModel->GetCurrentUser();

if (!empty($items))
    $keys = array_keys($items);
?>
<div>
    <?php if (!empty($items)) : ?>
        <?php foreach ($keys as $key) : ?>
            <h4><?= $key ?></h4>
            <?php foreach ($items[$key] as $item) : ?>
                <a href="/items/view?id=<?= $item['id'] ?>">
                <img class="bd-placeholder-img rounded" src="/files/items/<?= $item['photo'] ?>_s.jpg">
                </a>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<? if ($user['access'] == 2) : ?>
    <a href="/items/add" class="btn btn-success">Добавить предмет</a>
<? endif; ?>
