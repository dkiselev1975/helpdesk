<?php

namespace frontend\models;

use Yii;
use common\models\SiteUser;
use yii\base\Model;

class ResendVerificationEmailForm extends Model
{
    /**
     * @var string
     */
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
                'filter' => ['status' => SiteUser::STATUS_INACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * Sends confirmation email to user
     *
     * @return bool whether the email was sent
     */
    public function sendEmail()
    {
        $user = SiteUser::findOne([
            'email' => $this->email,
            'status' => SiteUser::STATUS_INACTIVE
        ]);

        if ($user === null) {
            return false;
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' '.Yii::$app->params['messages']['emails']['robot']])
            ->setTo($this->email)
            ->setSubject(Yii::$app->params['messages']['ResendVerificationEmailForm']['password_reset_for'].' '. Yii::$app->name)
            ->send();
    }
}
