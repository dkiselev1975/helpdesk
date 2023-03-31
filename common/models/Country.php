<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Country extends ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    /**
     * {@inheritdoc}
     */
    use DataRecord;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'required', 'message' => Yii::$app->params['messages']['errors']['rules']['name']['required']],
            ['name','string', 'length' => [2, 256],
                'tooLong'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooLong']['255smb'],
                'tooShort'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooShort']['2smb'],
                ],
            ['name','trim'],

            ['price_of_request','number'],
            ['price_of_request','match','pattern'=> Yii::$app->params['regexp']['price_of_request'], 'message' => Yii::$app->params['messages']['errors']['rules']['format']],
            ['price_of_request','trim'],

            ['status', 'required', 'message' => Yii::$app->params['messages']['errors']['rules']['status']['required']],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],

            ['note', 'string', 'length' => [0,65535],'tooLong'=>Yii::$app->params['messages']['errors']['rules']['sizes']['tooLong']['64kb']],
            ['note','trim'],

        ];
    }

    public static function tableName()
    {
        return '{{%country}}';
    }
}