<?php

namespace app\modules\api\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;

/**
 * Base controller for the `api` module
 */
class BaseController extends Controller
{
    public $modelClass;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter' ] = [
            'class' => \yii\filters\Cors::className(),
        ];
        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::className(),
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }

        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $this->modelClass;

        $query = $modelClass::find();

        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $query,
            'pagination' => [
                'params' => $requestParams,
            ],
            'sort' => [
                'params' => $requestParams,
            ],
        ]);
    }

    public function actionCreate()
    {
        $modelClass = new $this->modelClass;
        $modelClass->attributes = \yii::$app->request->post();

        if($modelClass->validate()) {
            $modelClass->save();
            return [
                'status' => true,
                'data'=> 'Record is added'
            ];
        } else {
            return [
                'status'=>false,
                'data'=> $modelClass->getErrors()
            ];
        }
    }

    public function actionUpdate($id)
    {
        $modelClass = new $this->modelClass;
        $model = $modelClass::findOne($id);
        if ($model) {
            $model->attributes = \yii::$app->request->post();
            $model->save();
            return [
                'status' => true,
                'data'=> 'Record is updated'
            ];
        } else {
            return [
                'status'=>false,
                'data'=> 'Record is not found'
            ];
        }
    }

    public function actionDelete($id)
    {
        $modelClass = new $this->modelClass;
        $model = $modelClass::findOne($id);
        if ($model) {
            $model->delete();
            return [
                'status' => true,
                'data'=> 'Record is deleted'
            ];
        } else {
            return [
                'status'=>false,
                'data'=> 'Record is not found'
            ];
        }
    }
}
