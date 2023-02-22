<?php

namespace frontend\models;
use frontend\controllers\GoodException;
use ErrorException;
use Yii;
use common\models\SiteUser;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $phone_office;
    public $phone_mobile;
    public $company_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'required', 'message' => Yii::$app->params['messages']['errors']['rules']['username']['required']."."],
            ['username', 'unique', 'targetClass' => '\common\models\SiteUser', 'message' => Yii::$app->params['messages']['errors']['login_is_already_used']."."],
            ['username', 'string', 'length' => [2, 45],
                'tooShort'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooShort']['2smb'],
                'tooLong'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooLong']['45smb'],
            ],

            ['email', 'required', 'message' => Yii::$app->params['messages']['errors']['rules']['email']['required']."."],
            ['email', 'email', 'message' => Yii::$app->params['messages']['errors']['rules']['format']],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\SiteUser', 'message' => Yii::$app->params['messages']['errors']['email_is_already_used']."."],

            ['password', 'required', 'message' => Yii::$app->params['messages']['errors']['rules']['password']['required']."."],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['phone_mobile','match','pattern'=> Yii::$app->params['regexp']['phone_mobile'], 'message' => Yii::$app->params['messages']['errors']['rules']['format']],
            ['phone_office','match','pattern'=> Yii::$app->params['regexp']['phone_office'], 'message' => Yii::$app->params['messages']['errors']['rules']['format']],

            ['company_id','required', 'message'=>''],
            ['company_id','integer'],

            [['username','email','password','phone_office','phone_mobile'],'trim'],

        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     * @throws GoodException
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new SiteUser();
        $user->username = $this->username;
        $user->email = $this->email;

        $user->phone_office = $this->phone_office;
        $user->phone_mobile = $this->phone_mobile;
        $user->company_id = $this->company_id;

        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        try {
            if(!$user->validate()){
                $errors=$user->getErrors();
                $errors=
                    [
                        'f1' => [0 => 'Пожалуйста, заполните поле "Статус f1"'],
                        'f2' => [
                            0 => 'Пожалуйста, заполните поле "Статус f2"',
                            1 => 'Пожалуйста, заполните поле "Статус f2"'
                        ]
                    ];
                $m=[];
                foreach ($errors as $field_errors){$m[]=implode("\n",$field_errors);}
                Yii::debug($errors);
                Yii::debug($m);
                throw new GoodException('Ошибка валидации',implode("\n",$m));
                }
            if(!$user->save()){throw new GoodException('Ошибка сохранения в БД');};
            if(!$this->sendEmail($user)){throw new GoodException('Ошибка отправки письма для подтверждения');};
            return true;
            }
        catch (ErrorException $exception)
            {
                throw new GoodException($exception->getMessage());
            }
    }

    /**
     * Sends confirmation email to user
     * @param SiteUser $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' '.Yii::$app->params['messages']['emails']['robot']])
            ->setTo($this->email)
            ->setSubject(Yii::$app->params['messages']['ResendVerificationEmailForm']['account_registration_at'].' '. Yii::$app->name)
            ->send();
    }
}
