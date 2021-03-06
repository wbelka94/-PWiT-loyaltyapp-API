<?php
/**
 * Created by PhpStorm.
 * User: Wojtek
 * Date: 13.05.2018
 * Time: 15:58
 */

namespace app\controllers;

use app\models\CouponSearch;
use yii\rest\ActiveController;

class CouponController extends ActiveController
{
    public $modelClass = 'app\models\Coupon';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new CouponSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }

}