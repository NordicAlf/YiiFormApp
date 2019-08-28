<?php

namespace app\models;

use yii\base\Model;
use Yii;

class signup extends Model
{
    public $name;
    public $email;
    public $password;
    public $reCaptcha;
    public $status;
    public $confirmation_key;

    public function rules()
    {
        return [
            [['name', 'email', 'password'], 'required','message' => 'Поле не может быть пустым'],
            ['name', 'string', 'min'=>3, 'max'=>30, 'message' => 'Выберите имя от 3 до 30 символов'],
            ['email', 'email', 'message' => 'Введите правильный email'],
            ['email', 'unique', 'targetClass'=>'app\models\User', 'message' => 'Такая почта уже существует'],
            ['password', 'string', 'min'=>6, 'max'=>32, 'message' => 'Пароль должен быть от 6 до 32 символов'],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => '6LcQ_LQUAAAAAAc0iDh3N1N-yYSsdLTUvjXfJ0eM', 'uncheckedMessage' => 'Жмякни шо ты не бот'],
        ];
    }

    public function signup()
    {
        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->generatePass($this->password);

        $user->confirmation_key = rand(100000, 999999);


        $ero = $this->sentEmailConfirm($user);
        $user->save();
        $result = 'Для продолжения регистрации на ваш почтовый ящик отправлен ссылка-ключ для подтверждения';
        return $result;
    }

    public function emailConfirm()
    {
        //$_GET['emailConfirm'] = '638ea6a0c129e2c18b5ed361afc77cf238a48579';
        $confirmationKey = $_GET['emailConfirm'];
        $userInDB = User::find()->where(['confirmation_key' => $confirmationKey])->one();
        if (isset($userInDB)) {
            $userInDB->status = 1;
            $userInDB->update();
            $result = 'Электронная почта подтверждена!';;
        } else {
            $result = 'Код подтверждения не совпадает.';
        }
        return $result;

    }

    public function sentEmailConfirm(User $user)
    {
        $email = $user->email;
        $confirmKey = $user->confirmation_key;

        $sent = Yii::$app->mailer->compose()
            ->setFrom('admin@admin.com')
            ->setTo($email)
            ->setSubject('Тема сообщения')
            ->setTextBody('http://yii.loc/site/confirm?emailConfirm=' . $confirmKey)
            ->setHtmlBody('http://yii.loc/site/confirm?emailConfirm=' . $confirmKey)
            ->send();

        if (!$sent) {
            throw new \RuntimeException('Sending error.');
        }
        return $confirmKey;
    }
}