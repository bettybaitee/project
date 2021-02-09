<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MaterialAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/../themes/material';
    public $basePath = '@webroot';
    public $baseUrl = '@app/themes/material';
    public $css = [
        '//fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons',
        '//maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css',
        'assets/css/material-dashboard.min.css',
    ];
    public $js = [
        'assets/js/core/jquery.min.js',
        'assets/js/core/popper.min.j',
        'assets/js/core/bootstrap-material-design.min.js',
        'assets/js/plugins/perfect-scrollbar.jquery.min.js',
        'assets/js/plugins/moment.min.js',
        'assets/js/plugins/sweetalert2.js',
        'assets/js/material-dashboard.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}