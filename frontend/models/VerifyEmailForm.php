<?php

namespace frontend\models;

use common\models\SiteUser;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Model;

class VerifyEmailForm extends Model
{
    /**
     * @var string
     */
    public $token;

    /**
     * @var SiteUser
     */
    private $_user;


    /**
     * Creates a form model with given token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token, array $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException(Yii::$app->params['messages']['VerifyEmailForm']['blank_token'].'.');
        }
        $this->_user = SiteUser::findByVerificationToken($token);
        if (!$this->_user) {
            throw new InvalidArgumentException(Yii::$app->params['messages']['VerifyEmailForm']['blank_token'].'.');
        }
        parent::__construct($config);
    }

    /**
     * Verify email
     *
     * @return SiteUser|null the saved model or null if saving fails
     */
    public function verifyEmail()
    {
        $user = $this->_user;
        $user->status = SiteUser::STATUS_ACTIVE;
        return $user->save(false) ? $user : null;
    }
}
