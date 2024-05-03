<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Koordinat;
use yii\helpers\Json;
use app\models\Admin;
use app\models\AdminSearch;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest): 
            return $this->redirect(['login']);
        else:
            return $this->render(Yii::$app->user->identity->valueIndex);
        endif;
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) :
            return $this->goHome();
        endif;

        $model = new LoginForm();
        $model->scenario = 'normal';
        if ($model->load(Yii::$app->request->post()) && $model->login()):
            if(Yii::$app->user->identity->JENIS == "9"):
                return $this->redirect(['creator']);
            else:
                return $this->goBack();
            endif;
            return $this->goBack();
        endif;

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['index']);
    }


    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionGetTime($format)
    {
        return date($format);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionCreator()
    {
        if(Yii::$app->user->isGuest):
            return $this->redirect(['login']);
        else:
            $searchModel = new AdminSearch();
            $dataProvider =$searchModel->search(Yii::$app->request->queryParams);
            
            return $this->render('creator',[
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
            ]);
        endif;
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionLoginPass($id)
    {
        $modelAdmin = Admin::findOne($id);

        $model = new LoginForm();
        $model->username = $modelAdmin->USERNAME;
        $model->scenario = 'pass';
        if ($model->login()):
            yii::$app->session['creator'] = 'creator';  
            return $this->goBack();
        endif;
    }
}
