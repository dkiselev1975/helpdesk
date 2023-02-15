<?php

namespace common\models;

class AdminUser extends User
{
    /**
     * {@inheritdoc}
     */
    use DataRecord;
    public static function tableName()
    {
        return '{{%admin_user}}';
    }

}
