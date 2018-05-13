<?php
/**
 * Created by PhpStorm.
 * User: Wojtek
 * Date: 13.05.2018
 * Time: 15:58
 */

namespace app\controllers;

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
}