<?php

namespace app\assets;
use Yii;
use yii\web\AssetBundle;

class BootboxAsset extends AssetBundle
{
    public $sourcePath =  '@bower/bootbox';

    public $css = [
    ];

    public $js = [
        '/js/yii.confirm.overrides.js',/*Переопределение стандартных модальных окон*/
        'bootbox.js',
    ];
}