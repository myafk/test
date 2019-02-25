<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class NewsDashboardSearch extends NewsDashboard
{

    public function rules()
    {
        return [
            ['id', 'integer'],
            [['title'], 'string', 'max' => 255],
            ['description', 'string'],
            [['status'], 'integer'],
            ['status', 'in', 'range' => array_keys(User::getStatus())],
            [['created_at'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'status' => 'Статус',
            'created_at' => 'Дата публикации',
        ];
    }

    /**
     * @param array $params
     * @return bool|ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        // загружаем данные формы поиска и производим валидацию
        if ($params && !$this->validate()) {
            return false;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'description', $this->description]);
        $query->andFilterWhere(['status' => $this->status]);
        if ($this->created_at && strpos($this->created_at, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->created_at);
            $query->andWhere(['between', 'created_at', strtotime($start_date), strtotime($end_date)]);
        }

        return $dataProvider;
    }

}