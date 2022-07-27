<?php
$userModel = new \models\Users();
$user = $userModel->GetCurrentUser();
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $MainTitle ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"/>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <style>
        body {
            background-color: #26272C;
            color: #f2f2f2;
        }
        div .hero .stats td{
            border: 2px double #f2f2f2;
            padding: 3px;
        }
        div .hero .talents td:nth-child(2){
            height: 25px;
            padding: 3px;
            text-align: center;
        }
        div .hero .talents td:last-child{text-align: left;}
        div .hero .talents td:first-child{text-align: right;}
        div .hero td:last-child{
            text-align: center;
        }
        @media screen and (max-width: 1000px){
            .adapt {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
        }

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #111111">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Dota 2</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/news">Новости/Обновления</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/info">Информация</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Библиотека
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="/heroes">Герои</a></li>
                        <li><a class="dropdown-item" href="/items">Предметы</a></li>
                        <li><a class="dropdown-item" href="/guides">Гайды</a></li>
                    </ul>
                </li>
            </ul>
            <form class="d-flex">
                <? if (!$userModel->IsUserAuthenticated()) : ?>
                    <a href="/users/register" class="btn btn-outline-primary">Реєстрація</a>
                    <a href="/users/login" class="btn btn-primary">Увійти</a>
                <? else: ?>
                    <? if ($user['access'] == 2): ?>
                        <a href="/site/backup" class="btn btn-primary">Make back-up</a>
                    <? endif ?>
                    <span class="navbar-text">
                        <a href="/account"><?= $user['login'] ?></a>
                    </span>
                    <a href="/users/logout" class="btn btn-primary">Вийти</a>
                <? endif ?>
            </form>
        </div>
    </div>
</nav>
<div class="container">
    <h1 class="mt-5"><?= $PageTitle ?></h1>
    <? if (!empty($MessageText)) : ?>
        <div class="alert alert-<?= $MessageClass ?>" role="alert">
            <?= $MessageText ?>
        </div>
    <? endif ?>
    <? ?>
    <?= $PageContent ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
<? if ($userModel->IsUserAuthenticated()) : ?>
    <script src="/alien/build/ckeditor.js"></script>
    <script>
        let editors = document.querySelectorAll('.editor');
        for (let i in editors) {
            ClassicEditor
                .create(editors[i], {

                    licenseKey: '',


                })
                .then(editor => {
                    window.editor = editor;


                })
                .catch(error => {
                    console.error('Oops, something went wrong!');
                    console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
                    console.warn('Build id: 7bh1wp303ki1-nohdljl880ze');
                    console.error(error);
                });
        }
    </script>
<? endif; ?>
</body>
</html>
