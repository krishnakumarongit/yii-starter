<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\EmailTemplate;
use app\models\SearchEmailTemplate;
use yii\web\Controller;
use app\models\Constants;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TemplateController implements the CRUD actions for EmailTemplate model.
 */
class TemplateController extends Controller
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
     * Lists all EmailTemplate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchEmailTemplate();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmailTemplate model.
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
     * Creates a new EmailTemplate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmailTemplate();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Constants::DATA_SUCCESS);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing EmailTemplate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Constants::DATA_SUCCESS);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing EmailTemplate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', Constants::DATA_SUCCESS);
        return $this->redirect(['index']);
    }

    /**
     * Deletes multiple templates .
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionBulkdelete()
    {
        $action = Yii::$app->request->post('action');
        $selection = (array)Yii::$app->request->post('selection');//typecasting
        if ($action == 'delete' && count($selection) > 0) {
            foreach ($selection as $id) {
                $e = EmailTemplate::findOne((int)$id);//make a typecasting
                $e->delete();
            }
            Yii::$app->session->setFlash('success', Constants::DATA_SUCCESS);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the EmailTemplate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmailTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmailTemplate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Constants::NO_PAGE);
        }
    }
}
