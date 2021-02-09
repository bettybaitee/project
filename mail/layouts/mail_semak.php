<?php
use yii\helpers\Html;
use app\models\MasterlistPero;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $model app\models\MasterlistPero */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php
$masterlist = MasterlistPero::findOne($model);
?>

<?php $this->beginBody() ?>

<p>Salam Sejahtera,</p>
<p><bold><?= Yii::t('app', $message); ?></bold></p>
<p>2. Maklumat Perancangan Perolehan Tahunan yang telah dikunci masuk seperti berikut:-</p>
    <table>
    <tr>
        <td>
            Nama Penyedia
        </td>
        <td>
            : <?= Yii::t('app', $masterlist->staff->rujukanNama) ?>
        </td>
    </tr>
    <tr>
        <td>
            Bahagian
        </td>
        <td>
            : <?= Yii::t('app', $masterlist->bahagian->rujukanNama) ?>
        </td>
    </tr>
    <tr>
        <td>
            Tajuk Perolehan
        </td>
        <td>
            : <?= Yii::t('app', $masterlist->tajuk_pero) ?>
        </td>
    </tr>
    <tr>
        <td>
            Perihal Perolehan
        </td>
        <td>
            : <?= Yii::t('app', $masterlist->perihal_pero) ?>
        </td>
    </tr>
</table>

<p>3. Permohonan boleh disemak di dalam sistem PROcurement Monitoring & Alert System (PROMAS).</p>
<p>Sekian, terima kasih</p>
<p>Ini ada janaan komputer</p>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
