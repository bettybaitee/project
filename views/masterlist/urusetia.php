<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MasterlistPero */

$this->title = 'Create Masterlist Pero';
$this->params['breadcrumbs'][] = ['label' => 'Masterlist Peros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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

    <?= $form->field($model, 'jangka_pelawa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jangka_sst')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'anggarankos')->textInput() ?>

    <?= $form->field($model, 'peringkat_penilaian')->dropDownList(
        ArrayHelper::map(\app\models\KonfRujukan::getAllRujukanByFlag('peringkat'), 'id', 'rujukanNama'),
        ['prompt' => Yii::t('app', 'Pilih Satu ...')])
    ?>

    <?= $form->field($model, 'catatan')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>