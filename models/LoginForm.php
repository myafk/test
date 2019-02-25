<?php

namespace app\models;

use yii\base\Model;
use Yii;

class LoginForm extends Model
{

    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить меня'
        ];
    }

    /**
     * @return User
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::find()->andWhere(['username' => $this->username])->one();
        }

        return $this->_user;
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неправильный логин или пароль');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            if ($user->status == User::STATUS_ACTIVATED) {
                $user->logged_at = time();
                $user->save(false);
                return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
            } else {
                $this->addError('username', 'Ваш профиль не активен, пожалуйста дождитесь активации от администрации');
                return false;
            }
        } else {
            return false;
        }
    }

}