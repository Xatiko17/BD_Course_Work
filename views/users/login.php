<form method="post" action="">
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Логин (email)</label>
        <input type="email" name="login" value="<?=$_POST['login'] ?>" class="form-control" id="exampleInputEmail1">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Пароль</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
    </div>
    <button type="submit" class="btn btn-primary">Войти</button>
</form>