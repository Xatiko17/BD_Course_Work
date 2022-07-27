<p>
    Вы действительно хотите удалить этот предмет <b><?=$model['name'] ?></b>?

</p>
<p>
    <a href="/items/delete?id=<?= $model['id'] ?>&confirm=yes" class="btn btn-danger">Удалить</a>
    <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary">Отменить</a>
</p>