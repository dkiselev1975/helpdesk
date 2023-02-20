<?php
namespace common\models;

use yii\db\ActiveRecord;

class Company extends ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
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
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],

            ['name', 'required', 'message' => 'Пожалуйста, заполните поле «Название»'],
            ['name','string', 'length' => [2, 256],'tooLong'=>'Длина данного поля должна быть не более 256 символов','tooShort'=>'Длина данного поля должна быть не менее 2 символов'],
            ['note', 'string', 'length' => [0,65535],'tooLong'=>'Длина данного поля должно быть не более 64кБ'],

            [['name','note'],'trim'],
        ];
    }

    public function getUser()
    {
        return $this->hasMany(SiteUser::class,['company_id'=>'id']);
    }

    public static function tableName()
    {
        return '{{%company}}';
    }
}