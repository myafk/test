<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property int $status 0 - Inactive\n10 - Active
 * @property string $username
 * @property string $email
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property int $created_at
 * @property int $updated_at
 * @property int $logged_at
 *
 * @property array $statusList
 *
 * @property News[] $news
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    const STATUS_NOT_ACTIVATED = 0;
    const STATUS_ACTIVATED = 10;

    protected $_statusList;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_NOT_ACTIVATED],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'role' => 'Role',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'logged_at' => 'Logged At',
        ];
    }

    /**
     * @param int $id
     * @return User
     */
    public static function findById($id)
    {
        return self::find()->andWhere(['id' => $id])->one();
    }

    public static function getStatus($key = null)
    {
        $array = [
            self::STATUS_NOT_ACTIVATED => 'Не активный',
            self::STATUS_ACTIVATED => 'Активный',
        ];
        if ($key === null)
            return $array;
        return ArrayHelper::getValue($array, $key);
    }

    public function getStatusList()
    {
        if (!$this->_statusList) {
            $this->_statusList = self::getStatus();
        }
        return $this->_statusList;
    }

    public static function getRoles($key = null)
    {
        $rbacRoles = Yii::$app->authManager->getRoles();
        $roles = [];
        foreach ($rbacRoles as $role) {
            $roles[$role->name] = $role->description;
        }

        if ($key === null)
            return $roles;
        return ArrayHelper::getValue($roles, $key);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::class, ['owner_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
}
