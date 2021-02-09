<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\KonfRujukan;
use app\models\MasterlistPero;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Masterlist Perolehan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h2 class="card-title ">Masterlist Perancangan Perolehan Tahunan</h2>
                <p class="card-category"> </p>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'id',
                            'tajuk_pero',
                            'perihal_pero',
                            [
                                'attribute' => 'kaedah_id',
                                'value' => 'kaedah.rujukanNama'
                            ],
                            [
                                'attribute' => 'kategori_id',
                                'value' => 'kategori.rujukanNama'
                            ],
                            [
                                'attribute' => 'jenis_id',
                                'value' => 'jenis.rujukanNama'
                            ],
                            'anggarankos',
                            'jangka_pelawa',
                            'jangka_sst',
                            [
                                'attribute' => 'status_id',
                                'value' => 'status.rujukanNama'
                            ],
                        ],
                    ]); ?>
                    <p>
                        <?= Html::a('Hantar', ['pukal'], ['class' => 'btn btn-success']) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>