<?php
/**
 * Created by PhpStorm.
 * User: Wojtek
 * Date: 13.05.2018
 * Time: 15:58
 */

namespace app\controllers;

use app\models\Customer;
use app\models\Transaction;
use Yii;
use yii\db\Query;
use yii\helpers\Url;
use yii\rest\ActiveController;

class CustomerController extends ActiveController
{
    public $modelClass = 'app\models\Customer';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new \app\models\CustomerSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }

    public function actionPointsByCompany($id,$all=false){
        $points = (new Query())
            ->select("SUM(value) AS points, company.*")
            ->from('transaction')
            ->leftJoin('company',"transaction.company = company.id")
            ->where(['=','customer',$id])
            ->orderBy(['points' => SORT_DESC])
            ->groupBy('company','id');
        if($all){
            $points = $points->where('points > 0');
        }
        return $points->all();
    }

    public function actionCreate(){
        $customer = Customer::find()->where(['=','email',$_POST['customer']['email']])->all();
        if($customer === null){
            $model = new Customer();
            $model->load(Yii::$app->getRequest()->getBodyParams(), '');
            if ($model->save()) {
                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);
                $id = implode(',', array_values($model->getPrimaryKey(true)));
                $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
            } elseif (!$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }

            return $model;
        }
        return '{"errorMessage":"Użytkownik o podanym adresie email już istnieje"}';
    }
}