<p>
    Вы действительно хотите удалить этот гайд <b><?= $model['name'] ?></b>?
</p>
<p>
    <a href="/guides/delete?id=<?= $model['id'] ?>&confirm=yes" class="btn btn-danger">Удалить</a>
    <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary">Отмена</a>
</p>