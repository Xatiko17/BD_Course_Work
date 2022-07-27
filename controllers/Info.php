<?php

namespace controllers;

use core\Controller;

class Info extends Controller
{
    public function actionIndex($id, $name)
    {
        global $Config;
        $title = 'Общая информация об игре';
        return $this->render('index', null, [
            'PageTitle' => $title,
            'MainTitle' => $title
        ]);
    }
}