<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class NewsDashboardForm
 * @package app\models
 * @property News $news
 */
class NewsDashboardForm extends Model
{
    public $title;
    public $short_description;
    public $description;
    public $imageUpload;
    public $status = News::STATUS_PUBLISHED;

    protected $news;
    protected $owner_id;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title', 'short_description', 'description', 'status'], 'required'],
            [['title', 'short_description', 'description'], 'string'],
            ['status', 'integer'],
            ['status', 'in', 'range' => array_keys(NewsDashboard::getStatus())],
            ['imageUpload', 'file']
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'short_description' => 'Превью',
            'description' => 'Описание',
            'status' => 'Статус',
            'imageUpload' => 'Картинка'
        ];
    }

    /**
     * UserDashboardForm constructor.
     * @param NewsDashboard|null $news
     * @param int $owner_id
     * @param array $config
     */
    public function __construct($news = null, $owner_id, array $config = [])
    {
        if (!$news)
            $news = new NewsDashboard();
        $this->news = $news;
        if (!$this->news->isNewRecord)
            $this->setAttributes($this->news->attributes);
        $this->owner_id = $owner_id;
        parent::__construct($config);
    }

    public function getNews()
    {
        return $this->news;
    }

    public function save()
    {
        $this->imageUpload = UploadedFile::getInstance($this, 'imageUpload');
        $this->news->setAttributes($this->attributes, false);
        if (!$this->validate())
            return false;
        if ($this->imageUpload) {
            $imageName = md5_file($this->imageUpload->tempName) . '.' . $this->imageUpload->extension;
            $this->imageUpload->saveAs('uploads/news/' . $imageName);
            $this->news->image = $imageName;
        }
        return $this->news->save();
    }

}