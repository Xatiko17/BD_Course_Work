<form method="post" action="" enctype="multipart/form-data" id="form">
    <div class="mb-3">
        <label for="name" class="form-label">Название предмета</label>
        <input type="text" name="name" value="<?= $model['name'] ?>" class="form-control" id="name">
    </div>
    <div class="mb-3">
        <label class="form-label">Вид</label><br>
        <input type="radio" name="type" value="shop" id="type1" checked>
        <label for="type1" class="form-label">Лавка</label>
        <input type="radio" name="type" value="neutral" id="type2">
        <label for="type2" class="form-label">Нейтральный</label>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Описание</label>
        <textarea name="description" class="form-control" id="description"><?= $model['description'] ?></textarea>
    </div>
    <div class="mb-3">
        <label for="attributes" class="form-label">Атрибуты</label>
        <textarea name="attributes" class="form-control" id="attributes"><?= $model['attributes'] ?></textarea>
    </div>
    <div class="mb-3">
        <label for="passive" class="form-label">Пассивный эффект</label>
        <textarea name="passive" class="form-control" id="passive"><?= $model['passive'] ?></textarea>
    </div>
    <div class="mb-3">
        <label for="active" class="form-label">Активный эффект</label>
        <textarea name="active" class="form-control" id="active"><?= $model['active'] ?></textarea>
    </div>
    <div class="mb-3">
        <label for="file" class="form-label">Фото предмета</label>
        <input type="file" accept="image/jpeg, image/png" name="file" class="form-control" id="file">
    </div>
    <div class="mb-3">
        <? if (is_file('files/items/' . $model['photo'] . '_b.jpg')) : ?>
            <img src="/files/items/<?= $model['photo'] ?>_b.jpg">
        <? endif; ?>
    </div>
    <div class="mb-3" id="price-div">
        <label for="price" class="form-label">Цена</label>
        <input type="number" name="price" value="<?= $model['price'] ?>" class="form-control" id="price">
    </div>
    <div class="mb-3" id="shop-type-div">
        <label for="shop_type" class="form-label">Вид предмета(Лавка)</label><br>
        <select name="shop_type" id="shop_type">
            <option value="consumables">Расходники</option>
            <option value="equipment">Снаряжение</option>
            <option value="secret shop">Потайная лавка</option>
            <option value="attributes">Атрибуты</option>
            <option value="other">Разное</option>
            <option value="accessories">Аксесуары</option>
            <option value="support">Поддержка</option>
            <option value="magic">Магия</option>
            <option value="armor">Броня</option>
            <option value="weapon">Оружие</option>
            <option value="artefacts">Артефакты</option>
        </select>
    </div>
    <div class="mb-3" id="grade-div">
        <label for="rank" class="form-label">Разряд</label>
        <input type="number" disabled name="rank" value="<?= $model['neutral_type'] ?>" class="form-control" id="rank">
    </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
<script>
    let check = document.getElementById('type1')
    let check2 = document.getElementById('type2')
    let price = document.getElementById('price')
    let shop_type = document.getElementById('shop_type')
    let grade = document.getElementById('rank')

    check.addEventListener('change', function () {
        if (check.checked) {
            grade.value = null
            grade.disabled = !grade.disabled
            shop_type.disabled = !shop_type.disabled
            price.disabled = !price.disabled
        }
    })
    check2.addEventListener('change', function () {
        if (check2.checked) {
            shop_type.value = null
            price.value = null
            components.value = null
            grade.disabled = !grade.disabled
            shop_type.disabled = !shop_type.disabled
            price.disabled = !price.disabled
        }
    })
</script>