<?php
namespace common\models;

use yii\db\ActiveRecord;

class Company extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    use DataRecord;

    public function getUser()
    {
        return $this->hasMany(SiteUser::class,['company_id'=>'id']);
    }

    public static function tableName()
    {
        return '{{%company}}';
    }
}