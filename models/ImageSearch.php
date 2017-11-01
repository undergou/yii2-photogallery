<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Image;
use app\models\Category;

/**
 * ImageSearch represents the model behind the search form about `app\models\Image`.
 */
class ImageSearch extends Image
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['author', 'category', 'title', 'date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Image::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
            'status' => $this->status,
        ]);

        $category = Category::findOne($params);
        if($category) {
            $categoryTitle = Category::findOne($params)->title;
            $query->andFilterWhere(['like', 'author', $this->author])
                ->andFilterWhere(['like', 'category', $categoryTitle])
                ->andFilterWhere(['like', 'title', $this->title]);
        } else{
            $query->andFilterWhere(['like', 'author', $this->author])
                ->andFilterWhere(['like', 'category', $this->category])
                ->andFilterWhere(['like', 'title', $this->title]);
        }


        return $dataProvider;
    }
}
