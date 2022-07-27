<p>
    Вы действительно хотите удалить эту новость?<b><?=$model['title'] ?></b>?

</p>
<p>
    <a href="/news/delete?id=<?= $model['id'] ?>&confirm=yes" class="btn btn-danger">Удалить</a>
    <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary">Отмена</a>
</p>