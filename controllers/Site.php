<?php

namespace controllers;

use core\Controller;

class Site extends Controller
{
    public function actionIndex()
    {
        $result = [
            'Title' => 'Заголовок',
            'Content' => 'Контент'
        ];
        return $this->render('index',null, [
            'MainTitle'=>'Главная страница',
            'PageTitle'=>'Главная страница'
        ]);
    }

    public function actionBackup()
    {
        global $Config;
        $filename='files/backups/db_backup_'.date('G_a_d_m_y').'.sql';
        $command='mysqldump --opt -h' . $Config['Database']['Server'] .' -u' .$Config['Database']['Username'] .' -p'
            .$Config['Database']['Password'] .' ' . $Config['Database']['Database'] .' > ' .$filename;
        exec($command,$output,$worked);

        $title = "Backup was created";
        return $this->renderMessage('ok', 'You made backup', null,
            [
                'PageTitle' => $title,
                'MainTitle' => $title
            ]);
    }
}