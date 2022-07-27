<p>
    Вы действительно хотите удалить этого героя <b><?= $model['name'] ?></b>?
</p>
<p>
    <a href="/heroes/delete?id=<?= $model['id'] ?>&confirm=yes" class="btn btn-danger">Удалить</a>
    <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary">Отмена</a>
</p>