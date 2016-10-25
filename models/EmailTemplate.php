<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email_template".
 *
 * @property integer $id
 * @property string $subject
 * @property string $message
 * @property string $type
 */
class EmailTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject', 'message', 'type'], 'required'],
            [['message', 'type'], 'string'],
            [['subject'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Subject',
            'message' => 'Message',
            'type' => 'Type',
        ];
    }
}
