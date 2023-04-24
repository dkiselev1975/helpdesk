<?php
namespace common\models;
use Yii;
use yii\base\Model;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;

class RequestForm extends Model
{
    public $WagonNumber;
    public $country_id;
    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            ['WagonNumber','required', 'message' => Yii::$app->params['messages']['RequestForm']['rules']['WagonNumber']['required']],
            ['WagonNumber','integer','message' => Yii::$app->params['messages']['RequestForm']['rules']['WagonNumber']['integer']],
            ['WagonNumber','match','pattern'=>'/^\d{8,8}$/','message' =>Yii::$app->params['messages']['RequestForm']['rules']['WagonNumber']['format']],
            ['WagonNumber','trim'],

            ['country_id','required','message'=>Yii::$app->params['messages']['errors']['rules']['country_id']['required']],
            ['country_id','integer'],
        ];
    }

    public static function RequestFormDraw($model)
    {
        ?>
        <?php $form = ActiveForm::begin(['id' => 'request-form']); ?>
        <?= $form->field($model, 'WagonNumber',['options'=>['class'=>'col-12 col-md-5 col-lg-4 mb-2 fw-bold']])->textInput()->label(Yii::$app->params['messages']['RequestForm']['fields']['WagonNumber'].":") ?>
        <?= $form->field($model, 'country_id',['options'=>['class'=>'col-12 col-md-5 col-lg-4 mb-4 fw-bold']])->dropDownList(arrayHelper::map(Country::find()->where(['status'=>Country::STATUS_ACTIVE])->orderBy(['sorting'=>SORT_ASC,'name'=>SORT_ASC])->all(),'id','name'),['prompt'=>Yii::$app->params['messages']['RequestForm']['fields']['country_id']['prompt'].'…'])->label(Yii::$app->params['messages']['RequestForm']['fields']['country_id']['label'].':',['class'=>'mb-1']); ?>
        <?= Html::submitButton(Yii::$app->params['messages']['RequestForm']['buttons']['submit'], ['class' => 'btn btn-primary col-12 col-sm-auto mx-auto mx-md-0 d-block px-4']) ?>
        <?php ActiveForm::end(); ?>
        <?php
    }
}