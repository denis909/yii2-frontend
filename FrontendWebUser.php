<?php

namespace denis909\frontend;

class FrontendWebUser extends \yii\web\User
{

    public $returnUrlParam = '__frontendReturnUrl';

    public $absoluteAuthTimeoutParam = '__frontendAbsoluteExpire';

    public $authTimeoutParam = '__frontendExpire';

    public $idParam = '__frontendId';

    public $identityCookie = ['name' => '_identity-frontend', 'httpOnly' => true];

    public $loginUrl = ['site/login'];

    public $logoutUrl = ['site/logout'];

    public $enableAutoLogin = true;    

}