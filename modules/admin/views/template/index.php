<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchEmailTemplate */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Email Templates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-template-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Email Template', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    
<?=Html::beginForm(['template/bulkdelete'],'post');?>
<?=Html::dropDownList('action','',[''=>'Mark selected as: ','delete'=>'Delete'],['class'=>'dropdown',])?>&nbsp;
<?=Html::submitButton('Send', ['class' => 'btn btn-info',]);?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            'subject',
            'type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?= Html::endForm(); ?> 
<?php Pjax::end(); ?></div>
