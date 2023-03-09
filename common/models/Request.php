<?php
namespace common\models;

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
            [['wagon_number','user_id','status'],'integer'],
            [['wagon_number','user_id','status','response'],'required'],
            [['response'],'string'],
            [['response'],'trim'],
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

    public function getUser()
    {
        return $this->hasOne(SiteUser::class,['id'=>'user_id']);
    }

    public static function tableName()
    {
        return '{{%request}}';
    }
}