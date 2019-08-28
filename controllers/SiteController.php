<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Signup;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSignup()
    {
        $model = new Signup();
        $model->attributes = $_POST;

        if ($model->validate()) {
            $messageOfConfirm = $model->signup();
            return $this->render('emailConfirm', ['messageOfConfirm' => $messageOfConfirm]);
        }
        return $this->render('signup', ['model' => $model]);
    }

    public function actionConfirm()
    {
        $model = new Signup();
        $messageOfConfirm = $model->emailConfirm();
        return $this->render('emailConfirm', ['messageOfConfirm' => $messageOfConfirm]);
    }
}
