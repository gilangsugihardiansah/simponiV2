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
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/map.css',
        'css/site-mobile.css',
        'css/ds.css',
        'css/my.css'
    ];
    public $js = [
        'js/main.js',
        'js/modalmap.js',
        'js/calendar.js',
        'js/sweetalert.min.js',
        'https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js',
        'https://cdn.jsdelivr.net/npm/pdfjs-dist@2.12.313/build/pdf.min.js',
        'https://unpkg.com/konva@8/konva.min.js',
        'https://kit.fontawesome.com/a076d05399.js',
        'https://code.iconify.design/2/2.2.1/iconify.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        '\rmrevin\yii\fontawesome\AssetBundle',
        // 'yii\bootstrap4\BootstrapAsset',
        // 'yidas\yii\jquery\JqueryAsset'
        // "https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
    ];
}
