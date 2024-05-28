<?php
namespace modules\contactform\controllers;

use Craft;
use craft\web\Controller;
use craft\mail\Message;
use yii\web\Response;

class ContactFormController extends Controller
{
    protected $allowAnonymous = true;

    public function actionSendEmail(): Response
    {
        $this->requirePostRequest();
        $request = Craft::$app->getRequest();

        $name = $request->getBodyParam('name');
        $email = $request->getBodyParam('email');
        $messageContent = $request->getBodyParam('message');

        // E-mail naar admin
        $adminEmail = new Message();
        $adminEmail->setTo('esatesitmez@gmail.com');
        $adminEmail->setFrom($email);
        $adminEmail->setSubject('Nieuw contactformulier inzending');
        $adminEmail->setTextBody("Naam: $name\nEmail: $email\nBericht: $messageContent");

        Craft::$app->getMailer()->send($adminEmail);

        // Bevestigingsmail naar gebruiker
        $userEmail = new Message();
        $userEmail->setTo($email);
        $userEmail->setFrom('esatesitmez@gmail.com');
        $userEmail->setSubject('Bevestiging van je inzending');
        $userEmail->setTextBody("Bedankt voor je bericht, $name. We hebben je bericht ontvangen en zullen zo spoedig mogelijk reageren.\n\nBericht: $messageContent");

        Craft::$app->getMailer()->send($userEmail);

        // Succesbericht in sessie
        Craft::$app->getSession()->setNotice('Uw bericht is met succes verzonden.');

        return $this->redirectToPostedUrl();
    }
}