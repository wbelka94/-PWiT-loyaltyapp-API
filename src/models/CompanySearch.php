<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Company;
use yii\db\Query;

/**
 * CompanySearch represents the model behind the search form of `app\models\Company`.
 */
class CompanySearch extends Company
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
     * @param null $customerID
     * @return ActiveDataProvider
     */
    public function search($params, $customerID = null)
    {

        if($customerID) {
            $query = (new Query())
                ->select('company.*, p.points')
                ->from('company')
                ->leftJoin("(SELECT SUM(value) AS points, company FROM transaction WHERE customer = $customerID GROUP BY company) p", "p.company = company.id");
        }
        else{
            $query = Company::find();
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, 'filter');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
