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
        $query = Libros::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'isbn' => $this->isbn,
            'anyo' => $this->anyo,
        ]);

        $query->andFilterWhere(['ilike', 'titulo', $this->titulo]);

        return $dataProvider;
    }
}