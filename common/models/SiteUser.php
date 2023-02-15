<?php

namespace common\models;

class SiteUser extends User
{
    /**
     * {@inheritdoc}
     */
    use DataRecord;

    public static function tableName()
    {
        return '{{%site_user}}';
    }

}
