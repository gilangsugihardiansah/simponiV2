<?php

namespace app\controllers;

use Yii;
use app\models\ChangePassword;
use app\models\Admin;
use app\models\AdminSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\helpers\Json;
use kartik\mpdf\Pdf;
use yii\helpers\ArrayHelper;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class AdminController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $action = ['none'];
        if(!yii::$app->user->isGuest AND isset(Yii::$app->user->identity->USERNAME)):
            if(Yii::$app->user->identity->JENIS == "1"):
                $action = ['index','create','update','delete','change-password'];
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
     * Lists all Admin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminSearch();
        $dataProvider =$searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Admin models.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Admin();

        if ($model->load(Yii::$app->request->post()) ) :

            $model->ID = mt_rand(1000000, 9999999).'-'.uniqid().'-'.mt_rand(10000, 99999);
            $model->COMPANY = $model->valueCompany;
            $model->UNIT = $model->valueUnit;
            $model->DATA_BAWAHAN = $model->valueBawahan;

            $model->PASSWORD = $model->setPassword();

            if($model->validate() & $model->save()):
                Yii::$app->session->setFlash('info', "Data berhasil ditambahkan.");
            else:
                Yii::$app->session->setFlash('error', "Penambahan Data tidak berhasil : ".yii::$app->AllComponent->getMsgError($model->getErrors()));
            endif;
        endif;

        return $this->redirect(['index']);
    }

    /**
     * Lists all Admin models.
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = Admin::findOne($id);

        if ($model->load(Yii::$app->request->post())) :

            $model->COMPANY = $model->valueCompany;
            $model->UNIT = $model->valueUnit;
            $model->DATA_BAWAHAN = $model->valueBawahan;

            if($model->validate() & $model->save()):
                Yii::$app->session->setFlash('info', "Data berhasil diubah.");
                return $this->redirect(['index']);
            else:
                Yii::$app->session->setFlash('error', "Perubahan Data tidak berhasil : ".yii::$app->AllComponent->getMsgError($model->getErrors()));
            endif;
        endif;
        
        if( ($model->JENIS == "7" OR $model->JENIS == "8") AND !empty($model->DATA_BAWAHAN)): 
            $model->DATA_BAWAHAN = explode(";", $model->DATA_BAWAHAN);
        endif;
        
        if($model->JENIS == "13"): 
            $model->MSB = $model->UNIT;
        endif;

        return $this->render('update',[
            'model'=>$model
        ]);
    }

    /**
     * Updates an existing DataPengguna model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionChangePassword()
    {
        $model = new ChangePassword();

        if ($model->load(Yii::$app->request->post()) ):
            if($model->validate()):
                $id = Yii::$app->user->identity->USERNAME;
                $modelAdmin = Admin::find()->andWhere(['USERNAME'=>$id])->one();
                $modelAdmin->PASSWORD = $model->PASSWORD_BARU;
                $modelAdmin->PASSWORD = $modelAdmin->setPassword();
                if($modelAdmin->save()):
                    Yii::$app->session->setFlash('info', "Perubahan paswword ".$modelAdmin->NAMA." berhasil disimpan.");
                    return $this->redirect(['/site']);
                else:
                    Yii::$app->session->setFlash('error', "Perubahan password ".$modelAdmin->NAMA." tidak berhasil : ".yii::$app->AllComponent->getMsgError($modelPeg->getErrors()));
                endif;
            endif;
        endif;
        return $this->render('changePass', ['model' => $model]);
    }

    /**
     * Lists all Admin models.
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = Admin::findOne($id);
        $model->delete();
        Yii::$app->session->setFlash('info', "Data berhasil dihapus.");

        return $this->redirect(['index']);
    }

    /**
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
