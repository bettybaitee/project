<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MasterlistPero */

$this->title = 'Create Masterlist Pero';
$this->params['breadcrumbs'][] = ['label' => 'Masterlist Peros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h2 class="card-title ">Maklumat Terperinci PPT</h2>
                <p class="card-category"> </p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <div class="masterlist-pero-form">

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            [
                                'attribute' => 'staff_id',
                                'value' => $model->staff->rujukanNama,
                            ],
                            [
                                'attribute' => 'bahagian_id',
                                'value' => $model->bahagian->rujukanNama,
                            ],
                            'no_fail',
                            'no_pero',
                            'tajuk_pero',
                            'perihal_pero',
                            [
                                'attribute' => 'kaedah_id',
                                'value' => $model->kaedah->rujukanNama,
                            ],
                            [
                                'attribute' => 'kategori_id',
                                'value' => $model->kategori->rujukanNama,
                            ],
                            [
                                'attribute' => 'jenis_id',
                                'value' => $model->jenis->rujukanNama,
                            ],
                            [
                                'attribute' => 'status_id',
                                'value' => $model->status->rujukanNama,
                            ],
                            'jangka_pelawa',
                            'jangka_sst',
                            'anggarankos',
                            [
                                'attribute' => 'peringkat_penilaian',
                                'value' => $model->peringkatPenilaian->rujukanNama,
                            ],
                            'catatan_subkukp',
                            'created_at:datetime',
                            'updated_at:datetime',
                        ],
                    ]) ?>

                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-lg-4 mb-4">
                        <?= $form->field($model, 'perakuan_subw')->dropDownList(
                            ArrayHelper::map(\app\models\KonfRujukan::getAllRujukanByFlag('perakuan_subw'), 'id', 'rujukanNama'),
                            ['prompt' => Yii::t('app', 'Pilih Satu ...'),
                                'required' => true,
                                'options' => [
                                    'validateOnSubmit' => true,
                                    'class' => 'form'
                                ],
                            ])
                        ?>
                        </div>
                        <div class="col-lg-8 mb-4">
                        <?= $form->field($model, 'catatan_subw')->textarea([
                            'rows' => 6,
                            'required' => true,
                            'options' => [
                                'validateOnSubmit' => true,
                                'class' => 'form'
                            ],
                        ])
                        ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
                </div>
            </div>
        </div>
    </div>
</div>