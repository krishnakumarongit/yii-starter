<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\EmailTemplate;
use app\models\SearchEmailTemplate;
use yii\web\Controller;
use app\models\Constants;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\FileUpload;
use yii\web\UploadedFile;


/**
 * UploadController implements the file upload.
 */
class UploadController extends Controller
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
     * Displays fileupload screen.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'model' => new FileUpload(),
        ]);
    }

    /**
     * Function for uploading image
     * @return null
    */
    public function actionImageupload()
    {
        $model = new FileUpload();
        $imageFile = UploadedFile::getInstance($model, 'image');
        $directory = \Yii::getAlias('@webroot').'/img/temp' . DIRECTORY_SEPARATOR . Yii::$app->session->id . DIRECTORY_SEPARATOR;
        if (!is_dir($directory)) {
            \yii\helpers\FileHelper::createDirectory($directory);
        }
        if ($imageFile) {
            $uid = uniqid(time(), true);
            $fileName = $uid . '.' . $imageFile->extension;
            $filePath = $directory . $fileName;
            if ($imageFile->saveAs($filePath)) {
                $path = SITE_URL. '/web/img/temp/' . Yii::$app->session->id . DIRECTORY_SEPARATOR . $fileName;
                return \yii\helpers\Json::encode([
                    'files' => [
                        [
                            'name' => $fileName,
                            'size' => $imageFile->size,
                            'url' => $path,
                            'thumbnailUrl' => $path,
                            'deleteUrl' => 'imagedelete?name=' . $fileName,
                            'deleteType' => 'POST',
                        ],
                    ],
                ]);
            }
        }
        return '';
    }

    /**
     * Function for deleting image
     * @return json
    */
    public function actionImagedelete($name)
    {

        $directory = \Yii::getAlias('@webroot').'/img/temp' .  DIRECTORY_SEPARATOR . Yii::$app->session->id;
        if (is_file($directory . DIRECTORY_SEPARATOR . $name)) {
            unlink($directory . DIRECTORY_SEPARATOR . $name);
        }
        $files = \yii\helpers\FileHelper::findFiles($directory);
        $output = [];
        foreach ($files as $file) {
            $fileName = basename($file);
            $path = 'web/img/temp/' . Yii::$app->session->id . DIRECTORY_SEPARATOR . $fileName;
            $output['files'][] = [
                'name' => $fileName,
                'size' => filesize($file),
                'url' => $path,
                'thumbnailUrl' => $path,
                'deleteUrl' => 'image-delete?name=' . $fileName,
                'deleteType' => 'POST',
            ];
        }
        return \yii\helpers\Json::encode($output);
    }
}
