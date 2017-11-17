<?php

/**
 * Created by PhpStorm.
 * User: deepson
 * Date: 17.11.17
 * Time: 17:37
 */
abstract class Controller extends Base
{
    protected $actions = [];
    function __construct()
    {
        App::registerController($this->getRoute(), $this);
        $className = get_class($this);
        $publMethods = get_class_methods($className);
        foreach ($publMethods as $publMethod) {
            if(substr($publMethod, 0, 6) === 'action') {
                $this->actions[] = substr($publMethod, 6);
            }
        }
    }

    public abstract function getRoute();

    public abstract function actionIndex();

    public function tryAction($action, $params)
    {
        if($id = array_search($action, $this->actions)) {
            // Call variable by name.
            $this->${'action' . $this->actions}();
        } else {
            $this->actionIndex();
        }
    }

}