<?php

namespace common\models;

use Yii;

/**
 * SiteUser model
 *
 * @property string $phone_office
 * @property string $phone_mobile
 * @property string $company_id
 * @property string $email
 * @property string $note
 */

class SiteUser extends User
{
    use DataRecord;

    /**
     * @var mixed|null
     */
    public function getCompany(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Company::class,['id'=>'company_id']);
    }

    public function getRequest(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Request::class,['user_id'=>'id']);
    }

    public static function tableName(): string
    {
        return '{{%site_user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'required', 'message' => Yii::$app->params['messages']['errors']['rules']['username']['required']."."],
            ['username', 'unique', 'targetClass' => '\common\models\SiteUser', 'message' => Yii::$app->params['messages']['errors']['login_is_already_used']."."],
            ['username','string', 'length' => [2, 45],
                'tooShort'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooShort']['2smb'],
                'tooLong'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooLong']['45smb']
            ],
            ['username','trim'],

            ['person_name', 'required', 'message' => Yii::$app->params['messages']['errors']['rules']['person_name']['required']."."],
            ['person_name','string', 'length' => [2, 45],
                'tooShort'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooShort']['2smb'],
                'tooLong'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooLong']['45smb']
            ],
            ['person_name','trim'],

            ['person_patronymic','string', 'length' => [2, 45],
                'tooShort'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooShort']['2smb'],
                'tooLong'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooLong']['45smb']
            ],
            ['person_patronymic','trim'],

            ['person_surname', 'required', 'message' => Yii::$app->params['messages']['errors']['rules']['person_surname']['required']."."],
            ['person_surname','string', 'length' => [2, 45],
                'tooShort'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooShort']['2smb'],
                'tooLong'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooLong']['45smb']
            ],
            ['person_surname','trim'],

            ['email', 'required', 'message' =>  Yii::$app->params['messages']['errors']['rules']['email']['required']."."],
            ['email', 'email', 'message' => Yii::$app->params['messages']['errors']['rules']['format']],
            ['email', 'string', 'max' => 255,'tooLong'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooLong']['255smb']],
            ['email','trim'],
            ['email', 'unique', 'targetClass' => '\common\models\SiteUser', 'message' => Yii::$app->params['messages']['errors']['email_is_already_used']."."],

            ['phone_mobile','match','pattern'=> Yii::$app->params['regexp']['phone_mobile'], 'message' => Yii::$app->params['messages']['errors']['rules']['format']],
            ['phone_mobile','trim'],
            ['phone_office','match','pattern'=> Yii::$app->params['regexp']['phone_office'], 'message' => Yii::$app->params['messages']['errors']['rules']['format']],
            ['phone_office','trim'],

            ['company_id','required','message'=>Yii::$app->params['messages']['errors']['rules']['company_id']['required']],
            ['company_id','integer'],

            //['status','required','message'=>Yii::$app->params['messages']['errors']['rules']['status']['required']],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],

            ['note', 'string', 'length' => [0,65535],'tooLong'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooLong']['64kb']],
            ['note','trim'],
        ];
    }
}
