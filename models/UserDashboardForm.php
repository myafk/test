<?php

namespace app\models;

use yii\base\Model;
use Yii;

/**
 * Class UserDashboardForm
 * @package app\models
 * @property User $user
 */
class UserDashboardForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $status = User::STATUS_ACTIVATED;

    protected $user;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'email', 'status'], 'required'],
            ['password', 'required', 'when' => function() {
                return $this->user->isNewRecord;
            }, 'whenClient' => "function (attribute, value) {
                return $('#is-new-record').val() == 1;
            }"],
            [['username', 'email', 'password'], 'string'],
            [['username', 'email', 'password'], 'trim'],
            ['email', 'email'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Имя пользователя уже занято', 'when' => function() {
                return $this->user->isAttributeChanged('username');
            }],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'E-mail уже занят', 'when' => function() {
                return $this->user->isAttributeChanged('email');
            }],
            ['status', 'integer'],
            ['status', 'in', 'range' => array_keys(User::getStatus())],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'email' => 'E-mail',
            'password' => 'Пароль',
            'status' => 'Статус',
            'role' => 'Роль'
        ];
    }

    /**
     * UserDashboardForm constructor.
     * @param User|null $user
     * @param array $config
     */
    public function __construct($user = null, array $config = [])
    {
        if (!$user)
            $user = new UserDashboard();
        $this->user = $user;
        if (!$this->user->isNewRecord) {
            $this->setAttributes($this->user->attributes);
        }
        parent::__construct($config);
    }

    public function getUser()
    {
        return $this->user;
    }

    public function save()
    {
        $this->user->setAttributes($this->attributes, false);
        if (!$this->validate())
            return false;
        $new = $this->user->isNewRecord;
        if ($this->password)
            $this->user->setPassword($this->password);
        if ($new)
            $this->user->generateAuthKey();
        if ($this->user->save()) {
            $manager = Yii::$app->authManager;
            if ($new) {
                $manager->assign($manager->getRole('user'), $this->user->getId());
            }
            return true;
        } else {
            return false;
        }
    }

}