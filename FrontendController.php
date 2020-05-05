<?php

namespace denis909\frontend;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;
use yii\helpers\Url;

class FrontendController extends \yii\web\Controller
{

    public $userComponent = 'user';

    public $postActions = [];

    public $roles = [];

    public $permissions = [];

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $return = [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => []
            ]
        ];

        if ($this->permissions || $this->roles)
        {
            $return['access'] = [
                'class' => AccessControl::class,
                'user' => $this->userComponent,
                'rules' => []
            ];
        }

        if ($this->permissions)
        {
            $return['access']['rules'][] = [
                'allow' => true,
                'permissions' => $this->permissions
            ];
        }

        if ($this->roles)
        {
            $return['access']['rules'][] = [
                'allow' => true,
                'roles' => $this->roles
            ];
        }

        if ($this->postActions)
        {
            foreach($this->postActions as $action)
            {
                $return['verbs']['actions'][$action][] = 'POST';
            }
        }

        return $return;
    }

    protected function redirectBack($defaultUrl = null)
    {
        $returnUrl = Yii::$app->request->get('returnUrl');

        if (!$returnUrl || !Url::isRelative($returnUrl))
        {
            $returnUrl = $defaultUrl;
        }

        if ($returnUrl === null)
        {
            $returnUrl = [$this->defaultAction];
        }

        return $this->redirect($returnUrl);
    }

}