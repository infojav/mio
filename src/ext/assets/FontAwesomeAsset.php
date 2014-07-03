<?php
/**
 * @link http://fontawesome.io/
 * @copyright Copyright &copy; 2014 Javier Perea
 * @license JPR
 */

namespace common\ext\assets;

use yii\web\AssetBundle;

/**
 * Font Awesome for Yii2 Project.
 *
 * @author Javier Perea <javier.perea@outlook.com>
 * @since 1.0
 */
class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@vendor/fortawesome/font-awesome';

    /**
     * TODO: what can happen on windows '\'?
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

