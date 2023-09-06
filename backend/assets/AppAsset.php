<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/default.css',
        'css/site.css',
    ];
    public $js = [
        //js переопределяющий yii.confirm
        //'js/yii.confirm.overrides.js',
        'js/usersDataLoading.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'yii\bootstrap5\BootstrapPluginAsset',/*нужен для BootboxAsset*/
        'rmrevin\yii\fontawesome\NpmFreeAssetBundle',
        'app\assets\BootboxAsset',/*alert, confirm, prompt, and flexible dialogs for the Bootstrap framework */
    ];
}
