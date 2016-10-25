<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Model for constants 
 *
 */
class Constants extends Model
{
	const ADMIN_EMAIL = 'admin@gmail.com';
	const LOGGEDOUT_MESSAGE = "You have been logged out successfully";
    const INVALID_OPERATION = 'Invalid operation';
    const DATA_SUCCESS = "Requested action performed successfully";
    const NO_PAGE= 'The requested page does not exist';
    const LOGIN_ERROR = "Invalid email or password";
    const EMAIL_ERROR = "Invalid email";
    const EMAIL_SUCCESS = "Your password has been sent to you";
  
}
