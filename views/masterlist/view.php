<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\JenisProses;

/* @var $this yii\web\View */
/* @var $model app\models\MasterlistPero */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Masterlist Peros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header card-header-primary">
                <h2 class="card-title ">Maklumat Terperinci PPT</h2>
                <p class="card-category"> </p>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                <p>
                    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>

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
                        'catatan_subkukp:ntext',
                        'catatan_subw:ntext',
                        'created_at:datetime',
                        'updated_at:datetime',
                    ],
                ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header card-header-primary">
                <h2 class="card-title ">Proses Perolehan</h2>
                <p class="card-category"> </p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <?php
                $rows = (new \yii\db\Query())
                ->select(['jenis_id', 'date_proses'])
                ->from('proses_perolehan')
                ->where(['pero_id' => $model->id])
                ->orderBy('id')
                ->all();
                ?>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Bil</th>
                            <th>Proses</th>
                            <th>Tarikh</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $s = 1;?>
                        <?php foreach ($rows as $row): ?>
                        <?php $jenis = JenisProses::findOne($row['jenis_id'])?>
                        <tr>
                            <td><?php echo $s ?></td>
                            <td><?php echo $jenis->namaProses ?></td>
                            <td><?php echo $row['date_proses'] ?></td>
                        </tr>
                        <?php $s++ ?>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>