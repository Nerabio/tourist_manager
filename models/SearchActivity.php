<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Activity;
use yii\helpers\ArrayHelper;

/**
 * SearchActivity represents the model behind the search form of `app\models\Activity`.
 */
class SearchActivity extends Activity
{
    public $monthSearch;
    public $placeSearch;
    public $isFaforite;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status_id', 'adress_id', 'look_counter', 'owner_user_id', 'creator_user_id', 'modyfy_user_id'], 'integer'],
            [['title', 'description', 'mark', 'color', 'picture_url', 'date_start', 'date_end', 'created_at', 'updated_at','monthSearch','isFaforite'], 'safe'],
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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Activity::find();

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


        if(!empty($this->isFaforite)){
            $query->andFilterWhere(['in','id',$this->getFavoriteId()]);
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status_id' => $this->status_id,
            'adress_id' => $this->adress_id,
            'look_counter' => $this->look_counter,
            'owner_user_id' => $this->owner_user_id,
            'creator_user_id' => $this->creator_user_id,
            'modyfy_user_id' => $this->modyfy_user_id,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'mark', $this->mark])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'picture_url', $this->picture_url]);



       if(!empty($this->monthSearch)){
           $query = $this->monthNumberToDateTime($query);
        }

        return $dataProvider;
    }

    public function monthNumberToDateTime($query){
        $currentYear = date('Y');
        $dayInMonth = cal_days_in_month(CAL_GREGORIAN, $this->monthSearch, $currentYear);
        $startDate = $currentYear.'.'.$this->monthSearch.'.01 00:00:00';
        $endDate = $currentYear.'.'.$this->monthSearch.'.'.$dayInMonth.' 23:59:59';
        $query->andFilterWhere(['between', 'date_start', $startDate, $endDate]);
        return $query;
    }

    public function getFavoriteId()
    {
        if (!Yii::$app->user->isGuest) {
            /**
             * @var $favorite FavoritActivity
             */
            $favorite = Yii::$app->user->identity->favoritActivities;
        }else{
            $favorite = null;
        }

        return ArrayHelper::getColumn(ArrayHelper::toArray($favorite), 'activity_id');
    }
}
