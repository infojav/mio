<?php
/**
 * Yii bootstrap file.
 *
 * Based on yii2 framework.
 * @link http://www.yiiframework.com/
 */

require(__DIR__ . '/../../vendor/yiisoft/yii2/BaseYii.php');

/**
 * Yii class Modified for mio project.
 */
class Yii extends \yii\BaseYii
{
}

spl_autoload_register(['Yii', 'autoload'], true, true);
Yii::$classMap = include(__DIR__ . '/../../vendor/yiisoft/yii2/classes.php');
Yii::$container = new yii\di\Container;
