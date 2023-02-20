<?php

namespace common\models;

class SiteUser extends User
{
    /**
     * {@inheritdoc}
     */
    use DataRecord;

    public function getCompany()
        {
            return $this->hasOne(Company::class,['id'=>'company_id']);
        }

    public static function tableName()
    {
        return '{{%site_user}}';
    }

}
