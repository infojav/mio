<?php
/**
 * @link http://angularjs.org/
 * @copyright Copyright &copy; 2014 Javier Perea
 * @license JPR
 */

namespace common\ext\widgets;

use yii\web\AssetBundle;

/**
 * Font Awesome for Yii2 Project.
 *
 * @author Javier Perea <javier.perea@outlook.com>
 * @since 1.0
 */
class ButtonsBarAsset extends AssetBundle
{
    public $sourcePath = '@common/ext/widgets/assets';
    public $baseUrl = '@web';
    public $publishOptions = [
        'forceCopy' => true
    ];
    public $css = [
        'css/buttonsbar.css'
    ];
    public $js = [];
    public $depends = [
		'common\ext\assets\FontAwesomeAsset',
	];
}
