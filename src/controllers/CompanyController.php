<?php
/**
 * Created by PhpStorm.
 * User: Wojtek
 * Date: 13.05.2018
 * Time: 15:58
 */

namespace app\controllers;

use app\models\Coupon;
use Yii;
use yii\rest\ActiveController;

class CompanyController extends ActiveController
{
    public $modelClass = 'app\models\Company';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $customerID = Yii::$app->request->get('customer');
        $searchModel = new \app\models\CompanySearch();
        return $searchModel->search(\Yii::$app->request->queryParams,$customerID);
    }

    public function actionGetCoupons($id){
        $coupons = Coupon::find()
            ->where(['=','company',$id])
            ->all();
        return $coupons;
    }

}