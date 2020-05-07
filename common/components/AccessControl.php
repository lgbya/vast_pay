<?php
namespace common\components;

use Yii;
use yii\base\Module;
use yii\web\User;
use yii\di\Instance;

class AccessControl extends \yii\base\ActionFilter
{
    private $_user = 'user';

    public $allowActions = [];

    public function getUser()
    {
        if (!$this->_user instanceof User) {
            $this->_user = Instance::ensure($this->_user, User::className());
        }
        return $this->_user;
    }

    public function setUser($user)
    {
        $this->_user = $user;
    }

    public function beforeAction($action)
    {
        $user = $this->getUser();
        return $this->denyAccess($user);
    }

    protected function denyAccess($user)
    {
        if ($user->getIsGuest()) {
            $user->loginRequired();
        }
        return true;
    }

    protected function isActive($action)
    {
        $uniqueId = $action->getUniqueId();
        if ($uniqueId === Yii::$app->getErrorHandler()->errorAction) {
            return false;
        }
        $user = $this->getUser();
        if ($this->owner instanceof Module) {
            // convert action uniqueId into an ID relative to the module
            $mid = $this->owner->getUniqueId();
            $id = $uniqueId;
            if ($mid !== '' && strpos($id, $mid . '/') === 0) {
                $id = substr($id, strlen($mid) + 1);
            }
        } else {
            $id = $action->id;
        }

        if($user->isGuest){
            foreach ($this->allowActions as $route) {
                if (substr($route, -1) === '*') {
                    $route = rtrim($route, "*");
                    if ($route === '' || strpos($id, $route) === 0) {
                        return false;
                    }
                } else {
                    if ($id === $route) {
                        return false;
                    }
                }
            }
        }
        if ($user->isGuest && is_array($user->loginUrl) && isset($user->loginUrl[0]) && $uniqueId === trim($user->loginUrl[0], '/')) {
            return false;
        }
        return true;
    }
}