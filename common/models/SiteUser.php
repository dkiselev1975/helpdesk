<?php
namespace common\models;

class SiteUser extends User
{
    public static function tableName()
    {
        return '{{%site_user}}';
    }
}
