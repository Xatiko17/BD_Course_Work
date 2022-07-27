<?php
$userModel = new \models\Users();
$user = $userModel->GetCurrentUser();
?>
<form class="d-flex" role="search" style="margin: 20px 0 20px 0">
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-outline-success" type="submit">Search</button>
</form>
<div>
    <?php if (!empty($heroes)) : ?>
            <?php foreach ($heroes as $hero) : ?>
                <a href="/heroes/view?id=<?= $hero['id'] ?>">
                    <img class="bd-placeholder-img rounded" src="/files/heroes/<?= $hero['photo_icon'] ?>_icon.jpg" alt="<?= $hero['name']?>">
                </a>
            <?php endforeach; ?>
    <?php endif; ?>
</div>
<? if ($user['access'] == 2) : ?>
    <a href="/heroes/add" class="btn btn-success" style="margin-top: 15px">Добавить героя</a>
<? endif; ?>
<script>

</script>
