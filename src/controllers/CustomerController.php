<?php
/**
 * Created by PhpStorm.
 * User: Wojtek
 * Date: 13.05.2018
 * Time: 15:58
 */

namespace app\controllers;

use app\models\Transaction;
use yii\db\Query;
use yii\rest\ActiveController;

class CustomerController extends ActiveController
{
    public $modelClass = 'app\models\Customer';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new \app\models\CustomerSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }

    public function actionPointsByCompany($id){
        $points = (new Query())
            ->select("SUM(value) AS points, company.*")
            ->from('transaction')
            ->leftJoin('company',"transaction.company = company.id")
            ->where(['=','customer',$id])
            ->groupBy('company','id')
            ->all();
        return $points;
    }
}