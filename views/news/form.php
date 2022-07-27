<form method="post" action="" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Вид</label><br>
        <input type="radio" name="type" value="news" id="type1">
        <label for="type1" class="form-label">Новость</label>
        <input type="radio" name="type" value="update" id="type2">
        <label for="type2" class="form-label">Обновление</label>
    </div>
    <div class="mb-3">
        <label for="title" class="form-label">Оглавление</label>
        <input type="text" name="title" value="<?=$model['title'] ?>" class="form-control" id="title">
    </div>
    <div class="mb-3">
        <label for="short_text" class="form-label">Короткий текст</label>
        <textarea name="short_text" class="form-control" id="short_text"><?=$model['short_text'] ?></textarea>
    </div>
    <div class="mb-3">
        <label for="text" class="form-label">Полный текст</label>
        <textarea style="height: 150px" name="text" class="form-control" id="text"><?=$model['text'] ?></textarea>
    </div>
    <div class="mb-3">
        <label for="file" class="form-label">Фото к новости</label>
        <input type="file" accept="image/jpeg, image/png" name="file" class="form-control" id="file">
    </div>
    <div class="mb-3">
        <? if (is_file('files/news/'.$model['photo'].'_b.jpg')) : ?>
        <img src="/files/news/<?= $model['photo'] ?>_b.jpg">
        <? endif; ?>
    </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>