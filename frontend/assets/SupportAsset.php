<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace yuncms\support\frontend\assets;

use yii\web\AssetBundle;

/**
 * Class SupportAsset
 * @package yuncms\support\frontend\assets
 */
class SupportAsset extends AssetBundle
{
    public $sourcePath = '@yuncms/support/frontend/views/assets';

    public $js = [
        'js/support.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}