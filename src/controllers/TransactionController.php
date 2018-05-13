<?php
/**
 * Created by PhpStorm.
 * User: Wojtek
 * Date: 13.05.2018
 * Time: 15:58
 */

namespace app\controllers;

use yii\rest\ActiveController;

class TransactionController extends ActiveController
{
    public $modelClass = 'app\models\Transaction';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new \app\models\TransactionSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }

}