<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property integer $first_name
 * @property integer $last_name
 * @property integer $email
 * @property string $address
 * @property string $role
 * @property string $status
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'password', 'role', 'address', 'status'], 'required'],
            [['first_name', 'last_name', 'email', 'password'], 'string', 'max' => 100],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['first_name', 'last_name', 'email', 'address', 'role', 'status'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'address' => 'Address',
            'role' => 'Role',
            'status' => 'Status',
        ];
    }
}
