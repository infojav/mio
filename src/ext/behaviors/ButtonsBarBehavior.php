<?php

/**
 * ButtonsBar behavior
 *
 * @author Javier Perea <javier.perea@outlook.com>
 * @link 
 * @copyright Copyright &copy; 2013 Javier Perea
 * @license JPR
 */

namespace common\ext\behaviors;

use Yii;
use yii\base\Behavior;
use yii\helpers\Url;

class ButtonsBarBehavior extends Behavior
{    
    public $excludeButtons = [];
    public $excludeOnOwnAction = true;
    public $actionButtons = [
        'refresh',
        'create',
        'duplicate',
        'delete',
        'search',
        'actions' => [
            'function' => 'actionsButton'
        ],
        'filter',
        'attachment',
        'comment',
        'link',
        'tag',
        //'assignment',
        'log',
        'email',
        'import',
        'export',
        'count',
        'previous',
        
        'next',
        /*'index', // grid
        'list'*/
    ];
    
    public $viewButtons = [
        'print' => [
            'function' => 'printButton'
        ],
        'index',
        'list'
    ];
    
    public $buttonsToRender = [];
    
    public function extractAllButtons()
    {
        $this->extractActions($this->actionButtons, 'actions');
        $this->extractActions($this->viewButtons, 'views');
    }
        
    /**
     * Check if action exist on controller
     * @param string $id controller action ID, without 'action' prefix.
     * @return boolean
     */
    public function actionExist($id)
    {
        $actionMap = Yii::$app->controller->actions();
        if (isset($actionMap) && isset($actionMap[$id])) {
            return true;
        }
        if (preg_match('/^[a-z0-9\\-_]+$/', $id) && strpos($id, '--') === false && trim($id, '-') === $id) {
            $methodName = 'action' . str_replace(' ', '', ucwords(implode(' ', explode('-', $id))));
            return Yii::$app->controller->hasMethod($methodName) ? true : false;
        }       
        return false;
    }
    
    private function extractActions($actions, $type) {
        foreach ($actions as $key => $content) {
            if (is_string($key)) {
                $actionId = $key;
            } else {
                $actionId = $content;
            }
            if ($actionId === $this->owner->action->id && $this->excludeOnOwnAction && !isset($this->excludeButtons[$actionId])) {
                continue;
            }
           
            $button = $this->extractButton($actionId);
            
            if ($button === false) {
                continue;
            }          
            if ($button === true) {
                $this->buttonsToRender[$type][$actionId] = [
                    'url' => Url::toRoute($actionId),
                ];
            } elseif (is_array($button)) {
                $this->buttonsToRender[$type][$actionId] = $button;
            }           
        }
    }
    
    private function extractButton($id)
    {
        if (isset($this->actionButtons[$id]['function'])) {
            return call_user_method($this->actionButtons[$id]['function'], $this->owner);
        } elseif (isset($this->viewButtons[$id]['function'])) {
            return call_user_method($this->viewButtons[$id]['function'], $this->owner);
        } 
        return $this->actionExist($id);
    }
}