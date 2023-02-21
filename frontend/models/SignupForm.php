<?php

namespace frontend\models;
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
            ['username', 'string', 'length' => [2, 45],'tooLong'=>'Длина данного поля должна быть не более 45 символов','tooShort'=>'Длина данного поля должна быть не менее 2 символов'],

            ['email', 'required', 'message' => Yii::$app->params['messages']['errors']['rules']['email']['required']."."],
            ['email', 'email', 'message' => 'Неверный формат e-mail'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\SiteUser', 'message' => Yii::$app->params['messages']['errors']['email_is_already_used']."."],

            ['password', 'required', 'message' => Yii::$app->params['messages']['errors']['rules']['password']['required']."."],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['phone_mobile','match','pattern'=> Yii::$app->params['regexp']['phone_mobile'], 'message' => 'Неверный формат номера телефона'],
            ['phone_office','match','pattern'=> Yii::$app->params['regexp']['phone_office'], 'message' => 'Неверный формат номера телефона'],
            
            ['company_id','required'],
            ['company_id','integer'],

            [['username','email','password','phone_office','phone_mobile'],'trim'],

        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
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

        return $user->save() && $this->sendEmail($user);
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
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
