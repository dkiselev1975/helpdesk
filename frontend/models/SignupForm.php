<?php

namespace frontend\models;
use common\components\GoodException;
use common\components\UserRules;
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

    public function behaviors()
    {
        return
            [
                'myBehavior2' => UserRules::class,
            ];
    }

    public function rules():array
    {
        return $this->getBehavior('myBehavior2')->myRules(true);
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
