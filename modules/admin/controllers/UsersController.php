<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Users;
use app\models\UsersSearch;
use app\models\PasswordHelper;
use app\models\Constants;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'bulkdelete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                // everything else is denied
                ],
            ],
        ];
    }

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Users();

        if ($model->load(Yii::$app->request->post())) {
            $model->password = PasswordHelper::encode($model->password);
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Constants::DATA_SUCCESS);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->password = PasswordHelper::decode($model->password);
        if ($model->load(Yii::$app->request->post())) {
            $model->password = PasswordHelper::encode($model->password);
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Constants::DATA_SUCCESS);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($id != 1) {
            $this->findModel($id)->delete();
        } else {
            Yii::$app->session->setFlash('error', Constants::INVALID_OPERATION);
        }
        return $this->redirect(['index']);
    }

    /**
     * Deletes multiple Users .
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionBulkdelete()
    {
        $action = Yii::$app->request->post('action');
        $selection = (array)Yii::$app->request->post('selection');//typecasting
        if ($action == 'delete' && count($selection) > 0) {
            foreach ($selection as $id) {
                $e = Users::findOne((int)$id);//make a typecasting
                if ($id != 1) {
                    $e->delete();
                }
            }
            Yii::$app->session->setFlash('success', Constants::DATA_SUCCESS);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Constants::NO_PAGE);
        }
    }


}
