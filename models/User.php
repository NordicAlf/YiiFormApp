<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public function generatePass($password) {
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($password);
    }
}
