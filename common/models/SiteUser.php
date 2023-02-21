<?php

namespace common\models;

/**
 * SiteUser model
 *
 * @property string $phone_office
 * @property string $phone_mobile
 * @property string $company_id
 * @property string $email
 */

class SiteUser extends User
{


    use DataRecord;

    /**
     * @var mixed|null
     */

    public function getCompany()
        {
            return $this->hasOne(Company::class,['id'=>'company_id']);
        }

    public static function tableName()
    {
        return '{{%site_user}}';
    }

}
