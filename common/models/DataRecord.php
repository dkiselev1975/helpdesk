<?php
namespace common\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\ErrorException;
use yii\db\ActiveQuery;
use yii\db\Exception;

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
     * Преобразует поля с датой в трубемый формат. Если формат не дадан, то переобразует даты в формат отображения в админке.
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
                foreach ($item as $field=>$value)
                    {
                    if(!empty($value))
                        {
                        switch ($item->getTableSchema()->columns[$field]->type):
                            case 'integer':
                                if(($field=='updated_at')||($field=='created_at'))
                                    {
                                    if($format==Yii::$app->params['date_formats']['php']['MySQL_DATETIME_format'])
                                        {
                                        $item[$field]=$formatter->asTimestamp($value);
                                        //Yii::warning("RECORD:".$format.":".$field.":".$value.":".$item[$field].":".$item->getTableSchema()->columns[$field]->type);
                                        }
                                    else
                                        {
                                        $item[$field]=$formatter->asDateTime($value,$format);
                                        //Yii::warning("READ:".$format.":".$field.":".$value.":".$item[$field].":".$item->getTableSchema()->columns[$field]->type);
                                        }
                                    }
                                break;
                            case 'datetime':
                            case 'timestamp':
                                $item[$field]=$formatter->asDateTime($value,$format);
                                break;
                        endswitch;
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
        try
        {
            return parent::save($runValidation,$attributeNames);
        }
        catch(Exception $error)
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
    /*$active_field - наименование поля статуса*/
    public static function find_active(string $active_field='active',int $active_status_value=1,string $deleted_field='deleted',int $deleted_status_value=0): ActiveQuery
    {
        return parent::find()->where(['and',[$active_field=>$active_status_value],['or',[$deleted_field=>[$deleted_status_value,null]]]]);
    }

    /*Пемечает запись как удаленную и проставляет время удаления*/
    /*$active_field - наименование поля статуса*/
    public function MarkAsDeleted($item,string $active_field='active',int $inactive_status_value=0,string $deleted_field='deleted',int $deleted_status_value=0):void
    {
        $item['date_of_deletion']=$this::DateTimeConvert(time(),Yii::$app->params['date_formats']['php']['MySQL_DATETIME_format']);
        $item[$deleted_field]=$deleted_status_value;
        $item[$active_field]=$inactive_status_value;
        $item->save(false);
    }

    /*Выводит в админской части не удаленные записи*/
    public static function find_for_edit(string $deleted_field='deleted',int $deleted_status_value=0): ActiveQuery
    {
        return parent::find()->where(['or',[$deleted_field=>[$deleted_status_value,null]]]);
    }
}