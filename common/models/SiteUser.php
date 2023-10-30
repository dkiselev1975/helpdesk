<?php

namespace common\models;
use common\components\UserRules;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * SiteUser model
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
     * @var mixed|null
     */
    public function getCompany(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Company::class,['id'=>'company_id']);
    }

    public static function tableName(): string
    {
        return '{{%site_user}}';
    }

    public function behaviors()
    {
    return
        [
            TimestampBehavior::class,
            'myBehavior2' => UserRules::class,
        ];
    }

    public function rules():array
    {
    return $this->getBehavior('myBehavior2')->myRules(false);
    }

}
