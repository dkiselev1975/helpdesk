<?php
namespace common\components;

use Yii;
use yii\base\Behavior;
use common\models\User;

class UserRules extends Behavior
{
    /**
     * @var string
     */
    public string $test='';

    /**
     * @param false $get_password
     * @return array
     */
    public function myRules($get_password=false):array
    {
        $main_rules=[
            ['username', 'required', 'message' => Yii::$app->params['messages']['errors']['rules']['username']['required']."."],
            ['username', 'unique', 'targetClass' => '\common\models\SiteUser', 'message' => Yii::$app->params['messages']['errors']['login_is_already_used']."."],
            ['username', 'string', 'length' => [2, 45],
                'tooShort'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooShort']['2smb'],
                'tooLong'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooLong']['45smb'],
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

            ['email', 'required', 'message' => Yii::$app->params['messages']['errors']['rules']['email']['required']."."],
            ['email', 'email', 'message' => Yii::$app->params['messages']['errors']['rules']['format']],
            ['email', 'string', 'max' => 255,'tooLong'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooLong']['255smb']],
            ['email','trim'],
            ['email', 'unique', 'targetClass' => '\common\models\SiteUser', 'message' => Yii::$app->params['messages']['errors']['email_is_already_used']."."],

            ['phone_mobile','match','pattern'=> Yii::$app->params['regexp']['phone_mobile'], 'message' => Yii::$app->params['messages']['errors']['rules']['format']],
            ['phone_mobile','trim'],
            ['phone_office','match','pattern'=> Yii::$app->params['regexp']['phone_office'], 'message' => Yii::$app->params['messages']['errors']['rules']['format']],
            ['phone_office','trim'],

            ['company_id','required', 'message'=>Yii::$app->params['messages']['errors']['rules']['company_id']['required']],
            ['company_id','integer'],

            ['note', 'string', 'length' => [0,65535],'tooLong'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooLong']['64kb']],
            ['note','trim'],
        ];


        /*SiteUser*/
        $status_full=[
            //['status','required','message'=>Yii::$app->params['messages']['errors']['rules']['status']['required']],
            ['status', 'default', 'value' => User::STATUS_INACTIVE],
            ['status', 'in', 'range' => [User::STATUS_ACTIVE, User::STATUS_INACTIVE, User::STATUS_DELETED]],
        ];

        /*SignupForm form*/
        $status_short=[
            //['status','required','message'=>Yii::$app->params['messages']['errors']['rules']['status']['required']],
            ['status', 'default', 'value' => User::STATUS_ACTIVE],
            ['status', 'in', 'range' => [User::STATUS_ACTIVE, User::STATUS_INACTIVE],'message'=>Yii::$app->params['messages']['errors']['rules']['status']['value']],
        ];

        $password=[
            ['password', 'required', 'message' => Yii::$app->params['messages']['errors']['rules']['password']['required']."."],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
            ['password','trim'],
        ];

        if($get_password)
        {
            $result=array_merge($main_rules,$status_short,$password);
        }
        else
        {
            $result=array_merge($main_rules,$status_full);
        }
        Yii::Debug($result);
        return $result;
    }
}
