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

    public $userActions = [];

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $return = [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => []
            ],
            'access' => [
                'class' => AccessControl::class,
                'user' => $this->userComponent,
                'rules' => []
            ]
        ];

        if ($this->userActions)
        {
            $return['access']['rules'][] = [
                'allow' => true,
                'roles' => ['@'],
                'actions' => $this->userActions
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

        if (count($return['access']['rules']) == 0)
        {
            unset($return['access']);
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