<?php

namespace app\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property int $id
 * @property int $status
 * @property int $owner_id
 * @property string $title
 * @property string $image
 * @property string $short_description
 * @property string $description
 * @property int $created_at
 * @property int $updated_at
 *
 * @property array $statusList
 *
 * @property User $owner
 */
class News extends \yii\db\ActiveRecord
{

    const STATUS_NOT_PUBLISHED = 0;
    const STATUS_PUBLISHED = 10;

    protected $_statusList;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_PUBLISHED],
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
            'owner_id' => 'Owner ID',
            'title' => 'Title',
            'image' => 'Image',
            'short_description' => 'Short Description',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @param int $id
     * @return News
     */
    public static function findById($id)
    {
        return self::find()->andWhere(['id' => $id])->one();
    }

    /**
     * @param int|null $key
     * @return array|string
     */
    public static function getStatus($key = null)
    {
        $array = [
            self::STATUS_NOT_PUBLISHED => 'Не опубликована',
            self::STATUS_PUBLISHED => 'Опубликована',
        ];
        if ($key === null)
            return $array;
        return ArrayHelper::getValue($array, $key);
    }

    /**
     * @return array|string
     */
    public function getStatusList()
    {
        if (!$this->_statusList) {
            $this->_statusList = self::getStatus();
        }
        return $this->_statusList;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::class, ['id' => 'owner_id']);
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        if ($this->image)
            return '/uploads/news/' . $this->image;
    }
}
