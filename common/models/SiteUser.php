<?php

namespace common\models;

class SiteUser extends User
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%site_user}}';
    }

}
