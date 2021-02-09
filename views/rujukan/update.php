<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\KonfRujukan */

$this->title = 'Update Konf Rujukan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Konf Rujukans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="konf-rujukan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
