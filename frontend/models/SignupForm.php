<?php

namespace frontend\models;
use Codeception\Util\Debug;
use common\components\GoodException;
use ErrorException;
use Yii;
use common\models\SiteUser;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    public $username;
    /**/
    public $person_name;
    public $person_patronymic;
    public $person_surname;
    /**/
    public $email;
    public $password;
    public $phone_office;
    public $phone_mobile;
    public $company_id;
    public $status;
    public $note;
    /**
     * {@inheritdoc}
     */
    public function rules():array
    {
        return [
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

            ['password', 'required', 'message' => Yii::$app->params['messages']['errors']['rules']['password']['required']."."],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
            ['password','trim'],

            ['phone_mobile','match','pattern'=> Yii::$app->params['regexp']['phone_mobile'], 'message' => Yii::$app->params['messages']['errors']['rules']['format']],
            ['phone_mobile','trim'],
            ['phone_office','match','pattern'=> Yii::$app->params['regexp']['phone_office'], 'message' => Yii::$app->params['messages']['errors']['rules']['format']],
            ['phone_office','trim'],

            ['company_id','required', 'message'=>Yii::$app->params['messages']['errors']['rules']['company_id']['required']],
            ['company_id','integer'],

            //['status','required','message'=>Yii::$app->params['messages']['errors']['rules']['status']['required']],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE],'message'=>Yii::$app->params['messages']['errors']['rules']['status']['value']],

            ['note', 'string', 'length' => [0,65535],'tooLong'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooLong']['64kb']],
            ['note','trim'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool |null whether the creating new account was successful and email was sent
     * @throws GoodException
     */
    public function signup($send__verification_email=true): bool|null
    {
        if (!$this->validate()) {
            return null;
            }

        $user = new SiteUser();
        $user->username = $this->username;

        $user->person_name = $this->person_name;
        $user->person_patronymic = $this->person_patronymic;
        $user->person_surname = $this->person_surname;

        $user->email = $this->email;

        $user->phone_office = $this->phone_office;
        $user->phone_mobile = $this->phone_mobile;
        $user->company_id = (int)$this->company_id;
        $user->status = (int)$this->status;
        $user->note = $this->note;

        $user->setPassword($this->password);
        $user->generateAuthKey();

        if($send__verification_email){
            $user->generateEmailVerificationToken();
        }

        try {
            if(!$user->validate()){
                $errors=$user->getErrors();
                /*Yii::warning($errors);*/
                $errors_messages=array();
                array_walk_recursive($errors,function ($item) use (&$errors_messages){$errors_messages[]=trim($item,'.');});
                throw new GoodException(
                    name:Yii::$app->params['messages']['errors']['validation']['validation_error'],
                    message:implode(";\n",$errors_messages).".",
                    buttons: array(['href'=>Yii::$app->request->referrer,'title'=>Yii::$app->params['messages']['signup']['buttons']['back']]),
                    layout:'blank');
                }
            if(!$user->save()){throw new GoodException(Yii::$app->params['messages']['errors']['db']['saving_error'],layout:'blank');};

            if(($send__verification_email)&&(!$this->sendEmail($user,$this->password)))
                {
                throw new GoodException(Yii::$app->params['messages']['errors']['sending']['confirmation'],layout:'blank');
                }
            Yii::debug(Yii::$app->params['messages']['signup']['debug']['registered'].': '.$user->username);
            return true;
            }
        catch (ErrorException|GoodException $exception)
            {
                throw new GoodException($exception->getMessage());
            }
    }

    /**
     * Sends confirmation email to user
     * @param SiteUser $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail(SiteUser $user,$password=null):bool
    {
        $send_verification_link=($user->status===$this::STATUS_INACTIVE);
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify_SiteUser-html', 'text' => 'emailVerify_SiteUser-text'],
                compact(['user','password','send_verification_link'])
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' '.Yii::$app->params['messages']['emails']['robot']])
            ->setTo($this->email)
            ->setSubject(Yii::$app->params['messages']['ResendVerificationEmailForm']['account_registration_at'].' '. Yii::$app->name)
            ->send();
    }
}
