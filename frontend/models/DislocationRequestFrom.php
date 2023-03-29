<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

class DislocationRequestFrom extends Model
{
    public $WagonNumber;

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            ['WagonNumber','required', 'message' => Yii::$app->params['messages']['DislocationRequestFrom']['rules']['WagonNumber']['required']],
            ['WagonNumber','integer','message' => Yii::$app->params['messages']['DislocationRequestFrom']['rules']['WagonNumber']['integer']],
            ['WagonNumber','match','pattern'=>'/^\d{8,8}$/','message' =>Yii::$app->params['messages']['DislocationRequestFrom']['rules']['WagonNumber']['format']],
            ['WagonNumber','trim'],
        ];
    }

    public static function RequestFormDraw($model)
    {
        ?>
        <?php $form = ActiveForm::begin(['id' => 'request-form']); ?>
        <?= $form->field($model, 'WagonNumber')->textInput(['class'=>'col-12 col-sm-6 col-md-4 ms-sm-2'])->label(Yii::$app->params['messages']['DislocationRequestFrom']['fields']['WagonNumber'].":") ?>
        <?= Html::submitButton(Yii::$app->params['messages']['DislocationRequestFrom']['buttons']['submit'], ['class' => 'btn btn-primary px-4']) ?>
        <?php ActiveForm::end(); ?>
        <?php
    }
}