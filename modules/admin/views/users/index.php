<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    
<?=Html::beginForm(['users/bulkdelete'],'post');?>
<?=Html::dropDownList('action','',[''=>'Mark selected as: ','delete'=>'Delete'],['class'=>'dropdown',])?>&nbsp;
<?=Html::submitButton('Send', ['class' => 'btn btn-info',]);?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            'first_name',
            'last_name',
            'email:email',
            'role',
            'status',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?= Html::endForm();?>     
<?php Pjax::end(); ?></div>
