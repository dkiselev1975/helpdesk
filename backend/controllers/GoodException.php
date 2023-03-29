<?php
namespace backend\controllers;
use Exception;
use Yii;
use yii\base\ExitException;

class GoodException extends ExitException
{
    const view='@app/../backend/views/admin/GoodException.php';
    /**
     * Конструктор
     * @param string $name Название (выведем в качестве названия страницы)
     * @param null $message Подробное сообщение об ошибке
     * @param int $code Код ошибки
     * @param int $status Статус ответа
     * @param Exception|null $previous Предыдущее исключение
     */

    public function __construct($name, $message = null, $code = 0, $status = 500, Exception $previous = null, array $buttons=array(),string $layout=null)
    {
        # Генерируем ответ
        $view = yii::$app->getView();
        $response = yii::$app->getResponse();
        $response->data = $view->renderFile(self::view, [
            'name' => $name,
            'message' => $message,
            'buttons' => $buttons,
            'layout' => $layout,
        ]);

        # Возвратим нужный статус (по-умолчанию отдадим 500-й)
        $response->setStatusCode($status);

        parent::__construct($status, $message, $code, $previous);
    }
}