<?php

namespace controllers;

use core\Controller;

class Account extends Controller
{
    public function actionIndex($id, $name)
    {
        global $Config;
        $title = 'Мои гайды';
        $guideModel = new \models\Guides();
        $userModel = new \models\Users();
        $guides = $guideModel->GetGuidesByUserId($userModel->GetCurrentUser()['id']);
        return $this->render('index', ['guides'=>$guides], [
            'PageTitle' => $title,
            'MainTitle' => $title
        ]);
    }
}