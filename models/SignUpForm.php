<?php

namespace app\models;

use yii\base\Model;
use Yii;

class SignUpForm extends Model
{

    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            [['username', 'email', 'password'], 'trim'],
            ['username', 'string'],
            ['email', 'email'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Имя пользователя уже занято'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'E-mail уже занят'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'email' => 'E-mail',
            'password' => 'Пароль',
        ];
    }

    public function signUp()
    {
        if (!$this->validate())
            return false;
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        if ($user->save()) {
            $auth = Yii::$app->authManager;
            $role = $auth->getRole('user');
            $auth->assign($role, $user->getId());
            return true;
        } else {
            return false;
        }
    }

}