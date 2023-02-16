<?php
namespace common\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\ErrorException;

trait DataRecord
{
    public array $ids=[];

    /**
     * @param $item
     * @return mixed
     */
    public static function DateTimeConvertForValidation($item): mixed
    {
        return self::DateTimeConvert($item);
    }

    public static function DateTimeConvertForMySQL($item): mixed
    {
        return self::DateTimeConvert($item,Yii::$app->params['date_formats']['php']['MySQL_DATETIME_format']);
    }

    /**
     * Преобразует поля с датой в трубемый формат. Если формат не дадан, то переобразует в даты формат отображения в админке.
     * @param $item
     * @param null $format
     * @return mixed
     */
    public static function DateTimeConvert($item, $format=null): mixed
    {
        try{
            if(is_null($format)){$format=Yii::$app->params['date_formats']['php']['date_time_format'];}
            $formatter = Yii::$app->formatter;
            if(is_iterable($item))
            {
                foreach ($item as $key=>$field)
                {
                    if(preg_match('/^(date|updated)/',$key)){
                        if(!empty($field)){$item[$key]=$formatter->asDateTime($field,$format);}
                    }
                }
            }
            else
            {
                $item=$formatter->asDateTime($item,$format);
            }
        }
        catch (InvalidConfigException $error)
        {
            Yii::error($error->getMessage());
        }
        return $item;
    }

    /**
     * Форматирует поля c датой в соответствии с синтаксисом MySQL непосредственно перед записью в БД.
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert):bool
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->DateTimeConvertForMySQL($this);
        return true;
    }

    /**
     * @throws ErrorException
     */
    public function save($runValidation = true, $attributeNames = null):bool
    {
        Yii::warning('saving...');
        try
        {
            return parent::save($runValidation,$attributeNames);
        }
        catch(\yii\db\Exception $error)
        {
            if(str_contains($error->getMessage(), 'Duplicate entry'))
            {
                throw new ErrorException('Такая запись уже существует', 2);
            }
            else
            {
                throw new ErrorException('Ошибка записи в БД'.$error->getMessage(), 2);
            }
        }
    }

    /*Выводит активные и не удаленные записи*/
    public static function find(): \yii\db\ActiveQuery
    {
        return parent::find()->where(['and',['active'=>'1'],['or',['deleted'=>['0',null]]]]);
    }

    /*Пемечает запись как удаленную и проставляет время удаления*/
    public function MarkAsDeleted($item):void
    {
        $item['date_of_deletion']=$this::DateTimeConvert(time(),Yii::$app->params['date_formats']['php']['MySQL_DATETIME_format']);
        $item['deleted']=1;
        $item['active']=0;
        $item->save(false);
    }

    /*Выводит в админской части не удаленные записи*/
    public static function find_for_edit(): \yii\db\ActiveQuery
    {
        return parent::find()->where(['or',['deleted'=>['0',null]]]);
    }
}