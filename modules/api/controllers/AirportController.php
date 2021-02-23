<?php

namespace app\modules\api\controllers;

use app\modules\api\models\Airport;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;

/**
 * Airport controller for the `api` module
 */
class AirportController extends BaseController
{
    public $modelClass = 'app\modules\api\models\Airport';
}
