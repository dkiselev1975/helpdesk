<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/**
 * Login form
 */
abstract class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    /*private $_user;*/

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            /*[['username', 'password'], 'required'],*/
            ['username', 'required', 'message' => Yii::$app->params['messages']['errors']['rules']['username']['required']."."],
            ['password', 'required', 'message' => Yii::$app->params['messages']['errors']['rules']['password']['required']."."],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::$app->params['messages']['errors']['validate_password']);
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    /*protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }*/

    public static function LoginFormDraw($title,$model,bool $password_resend_reset=false)
    {
    ?>
    <div class="site-login align-items-center d-flex pb-5">
        <div class="d-flex flex-grow-1 justify-content-center">
            <div class="col-12 col-lg-6">
                <h1><?= Html::encode($title) ?></h1>
                <p><?=Yii::$app->params['messages']['login']['sub_title'];?>:</p>
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label(Yii::$app->params['messages']['login']['fields']['username'].":") ?>
                <?= $form->field($model, 'password')->passwordInput()->label(Yii::$app->params['messages']['login']['fields']['password'].":") ?>
                <?= $form->field($model, 'rememberMe')->checkbox(['label'=>Yii::$app->params['messages']['login']['fields']['rememberMe']]) ?>
                <?php
                if($password_resend_reset)
                    {?>
                    <div class="my-1 mx-0" style="color:#999;">
                        <?= Yii::$app->params['messages']['login']['texts']['forgot_password'][0] ?> <?= Html::a(Yii::$app->params['messages']['login']['texts']['forgot_password'][1], ['site/request-password-reset']) ?>.
                        <br>
                        <?= Yii::$app->params['messages']['login']['texts']['resend'][0] ?> <?= Html::a(Yii::$app->params['messages']['login']['texts']['resend'][1], ['site/resend-verification-email']) ?>
                    </div>
                    <?php
                    }
                ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::$app->params['messages']['login']['buttons']['login'], ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <?php
    }

}
