<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="users-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'first_name')->textInput() ?>
    <?= $form->field($model, 'last_name')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'role')->dropDownList([ 'admin' => 'Admin', 'user' => 'User', ], ['prompt' => '-select-']) ?>
    <?= $form->field($model, 'status')->radioList([ 'active' => 'active', 'inactive' => 'inactive', ]); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
