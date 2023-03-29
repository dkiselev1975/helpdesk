<?php
namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Request extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    use DataRecord;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['wagon_number','integer'],
            ['wagon_number','required'],

            ['user_id','integer'],
            ['user_id','required'],

            ['response_success','integer'],
            ['response_success','required'],

            ['response_answer','string'],
            ['response_answer','trim'],

            ['user_email', 'required', 'message' =>  Yii::$app->params['messages']['errors']['rules']['email']['required']."."],
            ['user_email', 'email', 'message' => Yii::$app->params['messages']['errors']['rules']['format']],
            ['user_email', 'string', 'max' => 255,'tooLong'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooLong']['255smb']],
            ['user_email','trim'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function getUpdatedAt()
    {
        return $this->DateTimeConvert($this['updated_at']);
    }

    public function getUser()
    {
        return $this->hasOne(SiteUser::class,['id'=>'user_id']);
    }

    public static function tableName()
    {
        return '{{%request}}';
    }
}