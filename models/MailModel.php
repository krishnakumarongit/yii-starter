<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * FormatEmailTemplate is the model behind formating email template
 *
 */
class MailModel extends Model
{
   
   
    /**
     * Function to send mail
     *
     * @param string $to 
     * @param object $subject
     * @return string $message 
     */
    public static function send($to, $subject, $message)
    {
        Yii::$app->mailer->compose()
        ->setFrom(Constants::ADMIN_EMAIL)
        ->setTo($to)
        ->setSubject($subject)
        ->setTextBody(strip_tags($message))
        ->setHtmlBody($message)
        ->send();
        return true;
    }

   
}
