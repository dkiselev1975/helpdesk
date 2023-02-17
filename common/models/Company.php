<?php
namespace common\models;

use yii\db\ActiveRecord;

class Company extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    use DataRecord;

    public static function tableName()
    {
        return '{{%company}}';
    }
}