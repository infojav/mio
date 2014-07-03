<?php

/**
 * 
 *
 * @author Javier Perea <javier.perea@outlook.com>
 * @link 
 * @copyright Copyright &copy; 2013 Javier Perea
 * @license JPR
 */

namespace common\ext\widgets;

use \Yii;
use yii\base\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Actions:
 * New
 * Save
 * Switch view
 * Refresh / Reload.
 * Duplicate
 * Delete
 * Previous
 * Next
 * Search
 * View Logs
 * Go to Record ID
 * Close Tab
 * Attachment
 * Actions
 * Relate
 * Report
 * E-Mail
 * Print
 * Export Data
 * Import Data
 */
class ButtonsBar extends Widget
{
    /**
     * @var string the name of the buttonsBar container tag.
     */
    public $tag = 'div';
    /**
     * @var array the HTML attributes for the menubar container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [
        'class' => 'buttonsbar',
        ];
    /**
     * @var boolean whether to HTML-encode the link labels.
     */
    public $encodeLabels = true;
    /**
     * @var string list of buttons to render exclude, need be separated by comma ','.
     */
    public $exclude = '';
    /**
     *
     * @var type 
     */
    public $buttonProperties = [];
    /**
     * @var array list of links to appear in the menubars. If this property is empty,
     * the widget will not render anything. Each array element represents a single link in the menubars
     * with the following structure:
     *
     * ~~~
     * [
     *     'icon' => 'icon class'           // required
     *     'label' => 'label of the link',  // required
     *     'url' => 'url of the link',      // optional, will be processed by Url::to()
     * ]
     * ~~~
     *
     * If a link is active, you only need to specify its "label", and instead of writing `['label' => $label]`,
     * you should simply use `$label`.
     */
    protected $_buttonProperties = [
        'create' => [
            'buttonType' => 'icon',
            'icon' => 'plus',
            'label' => 'new',
        ],
        'refresh' => [
            'buttonType' => 'icon',
            'icon' => 'refresh',
            'label' => 'refresh'
        ],
        'duplicate' => [
            'buttonType' => 'icon',
            'icon' => 'copy',
            'label' => 'duplicate'
        ],
        'delete' => [
            'buttonType' => 'icon',
            'icon' => 'times',
            'label' => 'delete'
        ],
        'actions' => [
            'buttonType' => 'dropdown',
            'label' => 'actions to do...',
            'buttonText' => 'Actions'
        ],
        
        'search' => [
            'buttonType' => 'icon',
            'icon' => 'search',
            'label' => 'search'
        ],
        'log' => [
            'buttonType' => 'icon',
            'icon' => 'user',
            'label' => 'view logs'
        ],
        'filter' => [
            'buttonType' => 'icon',
            'icon' => 'filter',
            'label' => 'filter'
        ],
        'comment' => [
            'buttonType' => 'icon',
            'icon' => 'comments',
            'label' => 'comments'
        ],
        'link' => [
            'buttonType' => 'icon',
            'icon' => 'link',
            'label' => 'links'
        ],
        'tag' => [
            'buttonType' => 'icon',
            'icon' => 'tag',
            'label' => 'tags'
        ],
        /*'assignment' => [
            'buttonType' => 'icon',
            'icon' => 'flag',
            'label' => 'assignments'
        ],*/
        'attachment' => [
            'buttonType' => 'icon',
            'icon' => 'paperclip',
            'label' => 'attachments'
        ],
        'print' => [
            'buttonType' => 'dropdown',
            'icon' => 'print',
            'label' => 'print...',
        ],
        'email' => [
            'buttonType' => 'icon',
            'icon' => 'envelope',
            'label' => 'e-mail'
        ],
        'export' => [
            'buttonType' => 'icon',
            'icon' => 'sign-out',
            'label' => 'export'
        ],
        'import' => [
            'buttonType' => 'icon',
            'icon' => 'sign-in',
            'label' => 'import'
        ],
        'previous' => [
            'buttonType' => 'icon',
            'icon' => 'chevron-left',
            'label' => 'previous'
        ],
        'count' => [
            'buttonType' => 'text',
            'class' => 'btn btn-default little',
            'label' => 'count',
            'buttonText' => '2.345 of 2.335.667'
        ],
        'next' => [
            'buttonType' => 'icon',
            'icon' => 'chevron-right',
            'label' => 'next'
        ],
        'index' => [
            'buttonType' => 'icon',
            'icon' => 'table',
            'label' => 'grid'
        ],
        'list' => [
            'buttonType' => 'icon',
            'icon' => 'list',
            'label' => 'list'
        ],
    ];


    /**
     * @var string the template used to render each inactive item in the menubars. The token `{link}`
     * will be replaced with the actual HTML link for each inactive item.
     */
    public $buttonTemplate = '<a href="{url}" {tooltip} class="{buttonClass}" {disabled}>{icon}{buttonText}</a>';
    public $dropdownButtonTemplate = '<div class="btn-group"><a {tooltip} class="{buttonClass} dropdown-toggle" data-toggle="dropdown">{icon}{buttonText} <span class="caret"></span></a>{dropdown-menu}</div>';
    public $buttonClass = "btn btn-default";
    public $iconTemplate = '<i class="fa fa-{icon}"></i>';

    /**
     * if null dont show tooltip
     * @var type 
     */
    public $tooltipPlacement = 'top';
    
    public $leftButtonGroupOptions = ['class' => 'btn-group pull-left'];
    public $rightButtonGroupOptions = [ 'class' => 'btn-group pull-right'];
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        Yii::$app->controller->extractAllButtons();
        $this->registerClientScript();
    }
    /**
     * Renders the widget.
     */
    public function run()
    {
        $leftLinks = $this->renderButtonGroup(Yii::$app->controller->buttonsToRender['actions']);
        $rightLinks = $this->renderButtonGroup(Yii::$app->controller->buttonsToRender['views']);
      
        $leftButtonGroup = Html::tag($this->tag, implode('', $leftLinks), $this->leftButtonGroupOptions);
        $rightButtonGroup = Html::tag($this->tag, implode('', $rightLinks), $this->rightButtonGroupOptions);
        $this->options['id'] = $this->getId();
        echo Html::tag('div', $leftButtonGroup . $rightButtonGroup, $this->options);
    }
    
    protected function renderButtonGroup($buttons)
    {
        $links = [];
        foreach ($buttons as $actionId => $content) {
            if (strpos($this->exclude, $actionId) !== false) {
                continue;
            }
            if (isset($this->buttonProperties[$actionId])) {
                $buttons[$actionId] = ArrayHelper::merge($buttons[$actionId], $this->buttonProperties[$actionId]);
            }
            $link = ArrayHelper::merge($this->_buttonProperties[$actionId], $buttons[$actionId]);
            if ($link['buttonType'] === 'dropdown') {
                $template = $this->dropdownButtonTemplate;
            } else {
                $template = null;
            }
            $links[] = $this->renderItem($link, $template);
        }
        return $links;
    }
    /**
     * Renders a single buttonbar item.
     * @param array $link the link to be rendered. It must contain the "url" element. The "label" element is optional.
     * @param string $template the template to be used to rendered the link. The token "{link}" will be replaced by the link.
     * @return string the rendering result
     * @throws InvalidConfigException if `$link` does not have "label" element.
     */
    protected function renderItem($link, $template = null)
    {
        if ($template === null) {
            $template = $this->buttonTemplate;
        }
        if (isset($link['label'])) {
            $title = $this->encodeLabels ? Html::encode($link['label']) : $link['label'];
        } else {
            throw new InvalidConfigException('The "label" element is required for each link.');
        }

        return strtr($template, [
            '{icon}' => isset($link['icon']) ? strtr($this->iconTemplate, ['{icon}' => $link['icon']]) : '',
            '{buttonText}' => isset($link['buttonText']) ? $link['buttonText'] : '',
            '{buttonClass}' => isset($link['buttonClass']) ? $link['buttonClass'] : $this->buttonClass,
            '{url}' => isset($link['url']) ? $link['url'] : '',
            '{tooltip}' => $this->tooltipPlacement !== null ? "data-placement=\"$this->tooltipPlacement\" title=\"$title\"" : '',
            '{class}' => isset($link['class']) ? $link['class'] : $this->buttonClass,
            '{disabled}' => (isset($link['disabled']) && $link['disabled'] === true) ? 'disabled' : '',
            '{dropdown-menu}' => ($link['buttonType'] === 'dropdown' && isset($link['menu'])) ? $this->renderMenu($link['menu']) : '',
        ]);
    }
    
    protected function renderMenu($items)
    {
        $menu = '';
        $menu .= Html::beginTag('ul', ['class' => 'dropdown-menu', 'role' => 'menu']);
        foreach ($items as $item) {
            $text = isset($item['text']) ? Html::encode($item['text']) : '';
            $url = isset($item['url']) ? $item['url']: '#';
            $options = isset($item['options']) ? Html::enconde($item['options']): [];
            $options['class'] = 'disabled';
            $menu .= Html::tag('li', Html::a($text, $url, $options));
        }
        $menu .= Html::endTag('ul');
        
        return $menu;
    }
    
    /**
	 * Register CSS and Script.
	 */
	protected function registerClientScript()
	{
        if ($this->tooltipPlacement !== null) {
            $this->view->registerJs('jQuery(\'#' . $this->getId(). ' a\').tooltip({container: \'body\'});');
        }

        $view = $this->getView();
        ButtonsBarAsset::register($view);
        
	}
}

