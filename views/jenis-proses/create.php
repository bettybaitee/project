<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\JenisProses */

$this->title = 'Create Jenis Proses';
$this->params['breadcrumbs'][] = ['label' => 'Jenis Proses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jenis-proses-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
