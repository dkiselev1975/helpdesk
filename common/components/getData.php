<?php
namespace common\components;
use Yii;

class getData
{
    /**
     * @throws GoodException
     */
    public static function getUsersData(int $start_index=1):array
    {
                $input_data=[
            "list_info"=>[
                "sort_field"=>"name",
                "start_index"=>$start_index,
                "sort_order"=>"asc",
                "row_count"=>100,
                "get_total_count"=>true,
            ],
            "fields_required"=>["id","name"]
        ];
        static $users_data=[];
        $connection_options = [
            'http'=>[
                "method"=>"GET",
                "header"=>"authtoken:E4661F58-E35B-48CA-BA1C-1C19C385AC69\r\n"."Content-Type:application/json; charset=UTF-8"
            ],
        ];
        $file=@file_get_contents(
            'https://hq-helpdesk:8080/api/v3/users?input_data='.urlencode(json_encode($input_data)),
            false,
            stream_context_create($connection_options));
        if($file===false)
        {
            throw new GoodException('Ошибка загрузки данных',error_get_last()['message']??null,buttons: [['title'=>'Вернуться','href'=> Yii::$app->request->referrer]]);
        }
        $loaded_user_ids = json_decode($file,true);
        foreach ($loaded_user_ids['users'] as $user_id_data)
        {
            $file=@file_get_contents(
                'https://hq-helpdesk:8080/api/v3/users/'.$user_id_data['id'],
                false,
                stream_context_create($connection_options));
            if($file===false)
            {
                throw new GoodException('Ошибка загрузки информации о пользователе',"user_id: ".$user_id_data['id']."\n".error_get_last()['message']??null,buttons: [['title'=>'Вернуться','href'=> Yii::$app->request->referrer]]);
            }
            Yii::debug(json_decode($file,true));
            $users_data[]=json_decode($file,true)['user'];
        }
        if($loaded_user_ids['list_info']['has_more_rows'])
        {
            $start_index=$loaded_user_ids['list_info']['page']*$loaded_user_ids['list_info']['row_count']+1;
            self::getUsersData($start_index);
        }
        return $users_data;
    }

    /**
     * Makes HTML code for api users data
     *
     * @throws GoodException
     */
    public static function ApiGetUsersData(yii\web\Controller $class):string
    {
        $page_title = implode(' ',['Пользователи системы',Yii::$app->params['api_system_name']]);
        try
        {
            //$users_data=[];
            $users_data=getData::getUsersData();
        }
        catch (GoodException $exception)
        {
            throw $exception;
        }
        if(Yii::$app->request->isAjax)
        {
            return $class->renderpartial('ApiGetUsersData',compact('users_data','page_title'));
        }
        else
        {
            return $class->render('ApiGetUsersData',compact('users_data','page_title'));
        }
    }
}

