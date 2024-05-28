<?php
namespace modules\contactform;

use Craft;
use yii\base\Module as BaseModule;

class contactform extends BaseModule
{
    public function init()
    {
        parent::init();
        Craft::$app->getUrlManager()->addRules([
            'contact-form/send-email' => 'contactform/contact-form/send-email',
        ], false);
    }
}