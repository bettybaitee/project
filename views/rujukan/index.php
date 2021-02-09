<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Konf Rujukans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h2 class="card-title ">Senarai Rujukan</h2>
                <p class="card-category"> </p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <p>
                    <?= Html::a('Create Konf Rujukan', ['create'], ['class' => 'btn btn-success']) ?>
                </p>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'id',
                        'rujukanAgensi',
                        'rujukanFlag',
                        'rujukanNama',
                        'rujukanDefault',
                        //'rujukanSusunan',
                        //'rujukanSso',
                        //'rujukanCode',
                        //'rujukanCreated',
                        //'rujukanModified',
                        //'rujukanDeleted',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
