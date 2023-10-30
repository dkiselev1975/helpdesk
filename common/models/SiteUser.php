<?php

namespace common\models;
use common\components\UserRules;
use yii\db\ActiveQuery;

/**
 * SiteUser model
 * @mixin UserRules
 *
 * @property string $phone_office
 * @property string $phone_mobile
 * @property string $company_id
 * @property string $email
 * @property string $note
 */

class SiteUser extends User
{
    use DataRecord;

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompany(): ActiveQuery
    {
        return $this->hasOne(Company::class,['id'=>'company_id']);
    }

    public static function tableName(): string
    {
        return '{{%site_user}}';
    }

    public function behaviors():array
    {
    return
        [
            ...parent::behaviors(),
            UserRules::class,
        ];
    }

    public function rules():array
    {
    return $this->UserRules(false);
    }

}
