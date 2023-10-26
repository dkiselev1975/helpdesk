<?php

namespace common\models;
use Yii;

class AdminUser extends User
{
    /**
     * {@inheritdoc}
     */
    use DataRecord;
    public static function tableName()
    {
        return '{{%admin_user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //['status','required','message'=>Yii::$app->params['messages']['errors']['rules']['status']['required']],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],

            ['username', 'required', 'message' => Yii::$app->params['messages']['errors']['rules']['username']['required']."."],
            ['username','string', 'length' => [2, 45],
                'tooShort'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooShort']['2smb'],
                'tooLong'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooLong']['45smb']
            ],
            ['username','trim'],
            ['username', 'unique', 'targetClass' => '\common\models\AdminUser', 'message' => Yii::$app->params['messages']['errors']['login_is_already_used']."."],

            ['email', 'required', 'message' =>  Yii::$app->params['messages']['errors']['rules']['email']['required']."."],
            ['email', 'email', 'message' => Yii::$app->params['messages']['errors']['rules']['format']],
            ['email', 'string', 'max' => 255,'tooLong'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooLong']['255smb']],
            ['email', 'trim'],
            ['email', 'unique', 'targetClass' => '\common\models\AdminUser', 'message' => Yii::$app->params['messages']['errors']['email_is_already_used']."."],
        ];
    }
}
