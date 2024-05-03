<?php

namespace app\controllers;

use Yii;
use app\models\Spk;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\helpers\Json;
use kartik\mpdf\Pdf;
use yii\helpers\ArrayHelper;

/**
 * BidangController implements the CRUD actions for Bidang model.
 */
class SpkController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $action = ['none'];
        if(!yii::$app->user->isGuest AND isset(Yii::$app->user->identity->USERNAME)):
            if(Yii::$app->user->identity->JENIS == "1" OR Yii::$app->user->identity->JENIS == "2" OR Yii::$app->user->identity->JENIS == "4" OR Yii::$app->user->identity->JENIS == "6"):
                $action = ['get-spk-by-app'];
            else: 
                $action = ['none'];
            endif;
        endif;
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['get-spk-by-app'],
                'rules' => [
                    // allow authenticated users
                    [
                        'actions' => $action,
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied
                    [
                        'actions' => $action,
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    public function actionGetSpkByApp() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])):
            $values = $_POST['depdrop_parents'];

            $list = Spk::find()
            ->andWhere(['APP'=>$values])
            ->groupBy(['NO_SPK'])
            ->asArray()->all();

            $arr=[];
            if (count($list) > 0):
                foreach ($list as $i => $val):
                    $out[] = ['id' => $val['NO_SPK'], 'name' => $val['NO_SPK']];
                endforeach;
                // // Shows how you can preselect a value
                return ['output' => $out, 'selected' => ''];
            endif;

        endif;
        return ['output' => '', 'selected' => ''];
    }
}
