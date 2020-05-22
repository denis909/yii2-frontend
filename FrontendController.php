<?php

namespace denis909\frontend;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;
use yii\helpers\Url;

class FrontendController extends \yii\web\Controller
{

    public $access = [];

    public $userComponent = 'user';

    public $postActions = [];

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
            'access' => array_merge(
                [
                    'class' => AccessControl::class,
                    'user' => $this->userComponent,
                    'rules' => [],
                    'only' => []
                ],
                $this->access
            )
        ];

        foreach($this->postActions as $action)
        {
            $return['verbs']['actions'][$action][] = 'POST';
        }        

        if (count($return['access']['rules']) == 0)
        {
            unset($return['access']);
        }

        if (count($return['verbs']['actions']) == 0)
        {
            unset($return['verbs']);
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