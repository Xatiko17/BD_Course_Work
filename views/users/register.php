<form method="post" action="">
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Логин (email)</label>
        <input type="email" name="login" value="<?=$_POST['login'] ?>" class="form-control" id="exampleInputEmail1">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Пароль</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword2" class="form-label">Пароль (еще раз)</label>
        <input type="password" name="password2" class="form-control" id="exampleInputPassword2">
    </div>
    <div class="mb-3">
        <label for="lastname" class="form-label">Фамилия</label>
        <input type="text" name="lastname" value="<?=$_POST['lastname'] ?>" class="form-control" id="lastname">
    </div>
    <div class="mb-3">
        <label for="firstname" class="form-label">Имя</label>
        <input type="text" name="firstname" value="<?=$_POST['firstname'] ?>" class="form-control" id="firstname">
    </div>
    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
</form>