<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\MasterlistPero */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="masterlist-pero-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'staff_id')->dropDownList(
        ArrayHelper::map(\app\models\KonfRujukan::getAllRujukanByFlag('staff'), 'id', 'rujukanNama'),
        ['prompt' => Yii::t('app', 'Pilih Satu ...')])
    ?>

    <?= $form->field($model, 'bahagian_id')->dropDownList(
        ArrayHelper::map(\app\models\KonfRujukan::getAllRujukanByFlag('bahagian'), 'id', 'rujukanNama'),
        ['prompt' => Yii::t('app', 'Pilih Satu ...')])
    ?>

    <?= $form->field($model, 'no_fail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_pero')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tajuk_pero')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'perihal_pero')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kaedah_id')->dropDownList(
        ArrayHelper::map(\app\models\KonfRujukan::getAllRujukanByFlag('kaedah_pero'), 'id', 'rujukanNama'),
        ['prompt' => Yii::t('app', 'Pilih Satu ...')])
    ?>

    <?= $form->field($model, 'kategori_id')->dropDownList(
        ArrayHelper::map(\app\models\KonfRujukan::getAllRujukanByFlag('kategori_pero'), 'id', 'rujukanNama'),
        ['prompt' => Yii::t('app', 'Pilih Satu ...')])
    ?>

    <?= $form->field($model, 'jenis_id')->dropDownList(
        ArrayHelper::map(\app\models\KonfRujukan::getAllRujukanByFlag('jenis_peruntukan'), 'id', 'rujukanNama'),
        ['prompt' => Yii::t('app', 'Pilih Satu ...')])
    ?>

    <?=
    $form->field($model, 'jangka_pelawa')->widget(DatePicker::className(), [
            'type' => DatePicker::TYPE_INPUT,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]
    )
    ?>

    <?=
    $form->field($model, 'jangka_sst')->widget(DatePicker::className(), [
            'type' => DatePicker::TYPE_INPUT,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]
    )
    ?>

    <?= $form->field($model, 'anggarankos')->textInput() ?>

    <?= $form->field($model, 'peringkat_penilaian')->dropDownList(
        ArrayHelper::map(\app\models\KonfRujukan::getAllRujukanByFlag('peringkat'), 'id', 'rujukanNama'),
        ['prompt' => Yii::t('app', 'Pilih Satu ...')])
    ?>

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
