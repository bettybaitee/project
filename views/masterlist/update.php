<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MasterlistPero */

$this->title = 'Update Masterlist Pero: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Masterlist Peros', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h2 class="card-title ">Permohonan Pindaan PPT</h2>
                <p class="card-category"> </p>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
