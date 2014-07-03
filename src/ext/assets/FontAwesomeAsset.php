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
 * Font Awesome for mio project.
 *
 * @author Javier Perea <javier.perea@outlook.com>
 * @since 1.0
 */
class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@vendor/fortawesome/font-awesome';

    /**
     * TODO: what happen on windows '\'?
     */
    public function init() {
        
        $this->css = [
            YII_DEBUG ? 'css/font-awesome.css' : 'css/font-awesome.min.css',
        ];
        
        $this->publishOptions = [
            'beforeCopy' => function($from /*, $to*/) {
                if (preg_match('*(\/css)*', $from) || preg_match('*(\/fonts)*', $from)) {
                    return true;
                }
                return false;
            },
        ];
    }
}

