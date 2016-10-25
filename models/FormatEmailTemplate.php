<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\PasswordHelper;

/**
 * FormatEmailTemplate is the model behind formating email template
 *
 */
class FormatEmailTemplate extends Model
{
   
   
    /**
     * Function to format forgot password message.
     *
     * @param string $message 
     * @param object $user
     * @return string $message 
     */
    public static function forgotPassword($message, $user)
    {

        $formattedMessage = str_replace(['{name}', '{email}', '{password}', '{address}'], 
            [ $user->first_name.''.$user->last_name, $user->email, PasswordHelper::decode($user->password), $user->address], $message);
        return $formattedMessage;
    }

   
}
