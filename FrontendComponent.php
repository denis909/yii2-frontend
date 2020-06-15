<?php

namespace denis909\frontend;

use Yii;
use yii\helpers\ArrayHelper;

class FrontendComponent extends \yii\base\Component
{

    const EVENT_MAIN_LAYOUT_PARAMS = 'mainLayoutParams';

    public function mainLayoutParams(array $params = [], $view = null)
    {
        if (!$view)
        {
            $view = Yii::$app->view;
        }

        $params['enableCard'] = ArrayHelper::getValue($view->params, 'enableCard', true);

        $params['cardTitle'] = ArrayHelper::getValue($view->params, 'cardTitle', $view->title);

        $params['breadcrumbs'] = ArrayHelper::getValue($view->params, 'breadcrumbs', []);
        
        $params['actionMenu'] = ArrayHelper::getValue($view->params, 'actionMenu', []);
        
        $params['mainMenu'] = ArrayHelper::getValue(Yii::$app->params, 'mainMenu', []);
        
        $params['userMenu'] = ArrayHelper::getValue(Yii::$app->params, 'memberMenu', []);
        
        $params['footerMenu'] = ArrayHelper::getValue(Yii::$app->params, 'footerMenu', []);

        $event = new FrontendMainLayoutParamsEvent([
            'params' => $params,
            'view' => $view
        ]);

        $this->trigger(self::EVENT_MAIN_LAYOUT_PARAMS, $event);

        return $event->params;
    }

}
