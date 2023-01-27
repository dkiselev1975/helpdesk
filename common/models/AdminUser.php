<?php

namespace common\models;

class AdminUser extends User
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin_user}}';
    }

}
