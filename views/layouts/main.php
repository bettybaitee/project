<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Norb@it33_arsH@D">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


    <?php
    /*NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/masterlist/index']],
            ['label' => 'Permohonan Baru', 'url' => ['/masterlist/create']],
            ['label' => 'Kemaskini Status', 'url' => ['/masterlist/urusetia']],
            ['label' => 'Penyelenggaraan', 'url' => ['/rujukan/index']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();*/
    ?>

<!-- Page Wrapper -->
<div id="wrapper">
    <?= $this->render('sidebar') ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
        <?= $this->render('navbar') ?>
        <?php /* Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) */?>
        <?= Alert::widget() ?>
            <!-- Begin Page Content -->
            <div class="container-fluid">
            <?= $content ?>
            </div>
        </div>
        <!-- End of Main Content -->
        <?= $this->render('footer') ?>

    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
