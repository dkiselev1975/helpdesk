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
            $saving_result=parent::save($runValidation,$attributeNames);
            if(!$saving_result){throw new ErrorException('Ошибка валидации при записи', 0);}
            return $saving_result;
        }
        catch(Exception $error)
        {
            if(str_contains($error->getMessage(), 'Duplicate entry'))
            {
                throw new ErrorException('Такая запись уже существует', -1);
            }
            else
            {
                throw new ErrorException('Ошибка записи в БД: '.$error->getMessage(), -2);
            }
        }
    }

    /*Пемечает запись как удаленную и проставляет время удаления*/
    /*$status_field - наименование поля статуса*/
    /*$deleted_status_value* - значение статуса для удаленного объекта*/
    public function MarkAsDeleted($item,string $status_field='status',int $deleted_status_value=0):void
    {
        $item['date_of_deletion']=$this::DateTimeConvert(time(),Yii::$app->params['date_formats']['php']['MySQL_DATETIME_format']);
        $item[$status_field]=$deleted_status_value;
        $item->save(false);
    }
}