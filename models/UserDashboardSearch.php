<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class UserDashboardSearch extends UserDashboard
{

    public function rules()
    {
        return [
            ['id', 'integer'],
            [['username', 'email'], 'string', 'max' => 255],
            [['status'], 'integer'],
            ['status', 'in', 'range' => array_keys(self::getStatus())],
            [['created_at', 'logged_at'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Имя пользователя',
            'email' => 'E-mail',
            'status' => 'Статус',
            'created_at' => 'Дата регистрации',
            'logged_at' => 'Дата последней авторизации'
        ];
    }

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
        $query->andFilterWhere(['username' => $this->username]);
        $query->andFilterWhere(['email' => $this->email]);
        $query->andFilterWhere(['status' => $this->status]);
        if ($this->created_at) {
            $query->andWhere(['between', 'created_at', strtotime($this->created_at), strtotime($this->created_at) + 60 * 60 * 24]);
        }
        if ($this->logged_at) {
            $query->andWhere(['between', 'logged_at', strtotime($this->logged_at), strtotime($this->logged_at) + 60 * 60 * 24]);
        }

        return $dataProvider;
    }

}