<?php
namespace kilyakus\modules\assets;

class EmptyAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@kilyakus/modules/media';
    public $css = [
        'css/empty.css',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}
