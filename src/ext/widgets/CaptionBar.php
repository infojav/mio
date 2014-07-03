<?php

/**
 * CaptionBar class overloaded.
 *
 * @author Javier Perea <javier.perea@outlook.com>
 * @link 
 * @copyright Copyright &copy; 2013 Javier Perea
 * @license JPR
 */

namespace common\ext\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
/**
 * 
 */
class CaptionBar extends \yii\base\Widget
{
    /**
     * @var string the name of the breadcrumb container tag.
     */
    public $tag = 'div';
    /**
     * @var array the HTML attributes for the breadcrumb container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'captionbar'];
    public $textDirection = 'ltr';
    /**
    * @var array the module hyperlink in the breadcrumbs (called module link).
    * Please refer to [[links]] on the format of the link.
    * If this property is not set, it will default to a link pointing to [[module::homeUrl]]
    * with the module icon label. If this property is false, the module link will not be rendered.
    */
    public $moduleButton = null;
    public $breadcrumbs = [];
    /**
     * 
     */
    public $buttonTemplate = '<form action="{url}" method="get" class="{position}"><button class="btn btn-default"><i class="fa fa-{icon}"></i></button></form>';
    public $helpButtonPositionClass = 'pull-right';
    public $moduleButtonPositionClass = 'pull-left';
    public $helpButton = null;
    public $helpButtonIcon = 'question-circle';
    /*public $config = null;*/
    /**
     * @overladed
     */
    public function init()
    {
        parent::init();
        
        if ($this->textDirection === 'rtl') {
            $temp = $this->moduleButtonPositionClass;
            $this->moduleButtonPositionClass = $this->helpButtonPositionClass;
            $this->helpButtonPositionClass = $temp;
            $this->options['class'] .= ' rtl';
        }

        if ($this->moduleButton !== false) {
            $this->setModuleButton();
        }
        if ($this->helpButton !== false) {
            $this->setHelpButton();
        }
                
        $this->registerClientScript();
    }
    /**
     * 
     */
    public function run()
    {
        //$content = '';
        $moduleButton = '';
        $helpButton = '';
        if ($this->moduleButton != false) {
            $moduleButton = $this->renderButtonIcon($this->moduleButton, '', $this->buttonTemplate);
        }
        if ($this->helpButton != false) {
            $helpButton = $this->renderButtonIcon($this->helpButton, '', $this->buttonTemplate);
        }
        $content = $moduleButton . Breadcrumbs::widget($this->breadcrumbs) . $helpButton;
        
        if ($content !== '') {
            echo Html::tag($this->tag, $content, $this->options);
        }
    }
    /**
     * 
     */
    protected function setModuleButton()
    {
        $module = Yii::$app->controller->module;
        if ($this->moduleButton === null) {
            $this->moduleButton = [
                'type' => 'module',
                'label' => $module->hasMethod('getName') ? $module->getName() : '' ,
                'icon' => $module->hasMethod('getIcon') ? $module->getIcon() : '',
                'url' => $module->hasMethod('getUrl') ? $module->getUrl() : '',
            ];
        } elseif (is_array($this->moduleButton)) {
            $this->moduleButton['type'] = 'module';
            if (!isset($this->moduleButton['label'])) {
                $this->moduleButton['label'] = '';
            }
            if (!isset($this->moduleButton['icon'])) {
                $this->moduleButton['icon'] = null;
            }
            if (!isset($this->moduleButton['url'])) {
                $this->moduleButton['url'] = null;
            }
        } else {
            throw new InvalidConfigException('"moduleButton" is necessary be array or false on CaptionBar widget.');
        }
        $this->moduleButton['positionClass'] = $this->moduleButtonPositionClass;
    }
    /**
     * 
     */
    protected function setHelpButton()
    {
        $controller = Yii::$app->controller;
        if ($this->helpButton === null) {
            $this->helpButton['positionClass'] = $this->helpButtonPositionClass;
            $this->helpButton['icon'] = $this->helpButtonIcon;
            $this->helpButton['url'] = $controller->hasMethod('getHelpUrl') ? $controller->getHelpUrl() : null;
            $this->helpButton['label'] = Yii::t('app', 'help');
        }
    }
    /**
     * 
     * @param type $link
     * @param type $label
     * @param type $buttonTemplate
     * @return type
     */
    protected function renderButtonIcon($link, $label, $buttonTemplate)
    {
        if ($link['icon'] !== null && $link['url'] !== null) {
            return strtr($buttonTemplate, [
                    '{position}' => $link['positionClass'],
                    '{icon}' => $link['icon'],
                    '{url}' => $link['url'],
                    '{label}' => $label
                ]);
        }
        return '';
    }
    /**
	 * Register CSS.
	 */
	protected function registerClientScript()
	{
        $view = $this->getView();
        CaptionBarAsset::register($view);
        
	}
}

