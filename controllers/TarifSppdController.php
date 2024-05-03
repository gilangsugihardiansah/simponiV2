<?php

namespace app\controllers;

use Yii;
use app\models\TarifSppd;
use app\models\TarifSppdSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\helpers\Json;
use kartik\mpdf\Pdf;
use yii\helpers\ArrayHelper;

/**
 * TarifSppdController implements the CRUD actions for TarifSppd model.
 */
class TarifSppdController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $action = ['none'];
        if(!yii::$app->user->isGuest AND isset(Yii::$app->user->identity->USERNAME)):
            if(Yii::$app->user->identity->JENIS == "1" OR Yii::$app->user->identity->JENIS == "2" OR Yii::$app->user->identity->JENIS == "4" OR Yii::$app->user->identity->JENIS == "6"):
                $action = ['index','create','update','delete'];
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
                'only' => ['index','create','update','delete'],
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

    /**
     * Lists all TarifSppd models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TarifSppdSearch();
        $dataProvider =$searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all TarifSppd models.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TarifSppd();

        if ($model->load(Yii::$app->request->post()) ) :
            if(Yii::$app->user->identity->JENIS != "1"): 
                $model->COMPANY = Yii::$app->user->identity->COMPANY;
            endif;
            if($model->save()):
                Yii::$app->session->setFlash('info', "Data berhasil ditambahkan.");
            else:
                Yii::$app->session->setFlash('error', "Penambahan Data tidak berhasil : ".yii::$app->AllComponent->getMsgError($model->getErrors()));
            endif;
        endif;

        return $this->redirect(['index']);
    }

    /**
     * Lists all TarifSppd models.
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = TarifSppd::findOne($id);

        if ($model->load(Yii::$app->request->post())) :
            if(Yii::$app->user->identity->JENIS != "1"): 
                $model->COMPANY = Yii::$app->user->identity->COMPANY;
            endif;
            if($model->save()):
                Yii::$app->session->setFlash('info', "Data berhasil diubah.");
                return $this->redirect(['index']);
            else:
                Yii::$app->session->setFlash('error', "Perubahan Data tidak berhasil : ".yii::$app->AllComponent->getMsgError($model->getErrors()));
            endif;
        endif;

        return $this->render('update',[
            'model'=>$model
        ]);
    }

    /**
     * Lists all TarifSppd models.
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = TarifSppd::findOne($id);
        $model->delete();
        Yii::$app->session->setFlash('info', "Data berhasil dihapus.");

        return $this->redirect(['index']);
    }

    /**
     * Finds the TarifSppd model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TarifSppd the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TarifSppd::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetTarifByApp() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])):
            $values = $_POST['depdrop_parents'];

            $list = TarifSppd::find()
            ->andWhere(['COMPANY'=>$values])
            ->groupBy(['ID'])
            ->asArray()->all();

            $arr=[];
            if (count($list) > 0):
                foreach ($list as $i => $val):
                    $out[] = ['id' => $val['ID'], 'name' => 'Akomodasi : '.$val['TARIF_AKOMODASI'].' & Penginapan : '.$val['TARIF_MENGINAP']];
                endforeach;
                // // Shows how you can preselect a value
                return ['output' => $out, 'selected' => ''];
            endif;

        endif;
        return ['output' => '', 'selected' => ''];
    }
}
