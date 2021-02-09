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
                    <p>
                        <?= Html::a('Permohonan Baharu', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
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
                            /*[
                                'attribute' => 'staff_id',
                                'value' => 'staff.rujukanNama'
                            ],
                            [
                                'attribute' => 'bahagian_id',
                                'value' => 'bahagian.rujukanNama'
                            ],
                            'no_fail',
                            'no_pero',*/
                            //'',
                            [
                                'attribute' => 'status_id',
                                'value' => 'status.rujukanNama'
                            ],
                            //'peringkat_penilaian',
                            //'catatan:ntext',
                            //'created_at',
                            //'updated_at',

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view} {update} {subkukp} {subw} {ksu}',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                            'title' => Yii::t('app', 'Paparan'),
                                        ]);
                                    },

                                    'update' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                            'title' => Yii::t('app', 'Kemaskini'),
                                        ]);
                                    },
                                    'subkukp' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-tasks"></span>', $url, [
                                            'title' => Yii::t('app', 'Perakuan-SUBKUKP'),
                                        ]);
                                    },
                                    'subw' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-th"></span>', $url, [
                                            'title' => Yii::t('app', 'Perakuan-SUBW'),
                                        ]);
                                    },
                                    'ksu' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, [
                                            'title' => Yii::t('app', 'Perakuan-KSU'),
                                        ]);
                                    }

                                ],
                                'urlCreator' => function( $action, $model, $key, $index ){

                                    if ($action == "view") {

                                        return Url::to(['view', 'id' => $key]);

                                    }
                                    if ($action == "update") {

                                        return Url::to(['update', 'id' => $key]);

                                    }
                                    if ($action == "subkukp") {

                                        return Url::to(['subkukp', 'id' => $key]);

                                    }
                                    if ($action == "subw") {

                                        return Url::to(['subw', 'id' => $key]);

                                    }
                                    if ($action == "ksu") {

                                        return Url::to(['ksu', 'id' => $key]);

                                    }


                                }

                            ],


                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>