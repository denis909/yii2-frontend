<?php

namespace denis909\frontend;

use Yii;
use yii\helpers\ArrayHelper;
use denis909\frontend\events\FrontendMainLayoutParamsEvent;

class FrontendComponent extends \yii\base\Component
{

    const EVENT_MAIN_LAYOUT_PARAMS = FrontendMainLayoutParamsEvent::class;

    public function mainLayoutParams(array $params = [], $view = null)
    {
        if (!$view)
        {
            $view = Yii::$app->view;
        }

        $event = new FrontendMainLayoutParamsEvent([
            'view' => $view,
            'params' => array_merge([
                'mainMenu' => ArrayHelper::getValue(Yii::$app->params, 'mainMenu', []),
                'enableCard' => ArrayHelper::getValue($view->params, 'enableCard', true),
                'cardTitle' => ArrayHelper::getValue($view->params, 'cardTitle', $view->title),
                'breadcrumbs' => ArrayHelper::getValue($view->params, 'breadcrumbs', []),
                'actionMenu' => ArrayHelper::getValue($view->params, 'actionMenu', []),
                'userMenu' => ArrayHelper::getValue(Yii::$app->params, 'memberMenu', []),
                'footerMenu' => ArrayHelper::getValue(Yii::$app->params, 'footerMenu', []),
                'successMessages' => (array) Yii::$app->session->getFlash('success'),
                'errorMessages' => (array) Yii::$app->session->getFlash('error'),
                'infoMessages' => (array) Yii::$app->session->getFlash('info')
            ], $params)
        ]);

        $this->trigger(self::EVENT_MAIN_LAYOUT_PARAMS, $event);

        return $event->params;
    }

}
