<?php
/**
 * This file is part of the mio project.
 *
 * (c) Mio project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace backend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = ['css/site.css'];
    public $js = [];
    public $depends = [
        'mio\web\MioAsset',
        'mio\bootstrap\BootstrapAsset',
    ];
}
