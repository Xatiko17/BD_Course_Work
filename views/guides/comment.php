<?php
$userModel = new \models\Users();
?>
<form name="comment" action="" method="post">
    <div class="mb-3">
        <label class="form-label" for="text">Комментарий:</label>
        <textarea class="form-control" name="text" id="text"><?= $model['text'] ?></textarea>
    </div>
    <div class="mb-3">
        <label>Понравился гайд?</label>
        <input type="radio" name="liked" value="true" id="type1"
        <?php if ($model['liked'] == 'true') echo 'checked' ?>
        >
        <label for="type1" class="form-label">Да</label>
        <input type="radio" name="liked" value="false" id="type2"
        <?php if ($model['liked'] == 'false') echo 'checked' ?>
        >
        <label for="type2" class="form-label">Нет</label>
    </div>
    <input type="submit" value="Отправить"/>
    <p>
        <input type="hidden" name="guide_id" value="<?= $_GET['id'] ?>" />
        <input type="hidden" name="user_id" value="<?= $userModel->GetCurrentUser()['id'] ?>" />
    </p>
</form>