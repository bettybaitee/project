<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jenis Proses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jenis-proses-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Jenis Proses', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'namaProses',
            'mailSubjek',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
