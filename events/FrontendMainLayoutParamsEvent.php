<?php

namespace denis909\frontend\events;

class FrontendMainLayoutParamsEvent extends \yii\base\Event
{

    public $params = [];

    public $view;

}