<?php
/*
 * This file is part of the mio project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace mio\ext\assets;

use yii\web\AssetBundle;

/**
 * Angular route asset for mio Project.
 *
 * @author Javier Perea <javier.perea@outlook.com>
 * @since 1.0
 */
class AngularRouteAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower_components/angular-route';
    public $baseUrl = '@web';
    /**
     * @override
     */
    public function init() {
        
        $this->js = [
            YII_DEBUG ? 'angular-route.js' : 'angular-route.min.js'
        ];
    }
}
