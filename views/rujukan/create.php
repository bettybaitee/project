<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\KonfRujukan */

$this->title = 'Create Konf Rujukan';
$this->params['breadcrumbs'][] = ['label' => 'Konf Rujukans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="konf-rujukan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
