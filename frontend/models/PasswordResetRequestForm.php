<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\SiteUser;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\SiteUser',
                'filter' => ['status' => SiteUser::STATUS_ACTIVE],
                'message' => Yii::$app->params['messages']['errors']['rules']['email']['no_user'].'.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user SiteUser */
        $user = SiteUser::findOne([
            'status' => SiteUser::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!SiteUser::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' '.Yii::$app->params['messages']['emails']['robot']])
            ->setTo($this->email)
            ->setSubject(Yii::$app->params['messages']['PasswordResetRequestForm']['password_reset_for'].' '.'"'.Yii::$app->name.'"')
            ->send();
    }
}
