<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class LibrosSearch extends Libros
{
    public function rules()
    {
        return [
            [['anyo'], 'number'],
            [['autor.nombre'], 'safe'],
            [['autor_id'], 'default', 'value' => null],
            [['autor_id'], 'integer'],
            [['isbn'], 'string', 'max' => 13],
            [['titulo'], 'string', 'max' => 255],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['autor.nombre']);
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Libros::find()->joinWith('autor a');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['autor.nombre'] = [
            'asc' => ['a.nombre' => SORT_ASC],
            'desc' => ['a.nombre' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'isbn' => $this->isbn,
            'anyo' => $this->anyo,
        ]);

        $query->andFilterWhere(['ilike', 'titulo', $this->titulo]);
        $query->andFilterWhere([
            'ilike',
            'a.nombre',
            $this->getAttribute('autor.nombre')
        ]);

        return $dataProvider;
    }
}