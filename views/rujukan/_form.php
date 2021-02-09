<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\KonfRujukan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="konf-rujukan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'rujukanAgensi')->textInput() ?>

    <?= $form->field($model, 'rujukanFlag')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rujukanNama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rujukanDefault')->textInput() ?>

    <?= $form->field($model, 'rujukanSusunan')->textInput() ?>

    <?= $form->field($model, 'rujukanSso')->textInput() ?>

    <?= $form->field($model, 'rujukanCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rujukanCreated')->textInput() ?>

    <?= $form->field($model, 'rujukanModified')->textInput() ?>

    <?= $form->field($model, 'rujukanDeleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
