<?php

class AjaxController extends MyAuthController
{
    
        public function actionCountOfflineMessage() 
        {
            if(Yii::app()->request->isAjaxRequest) {
                $sql = "SELECT * FROM chat WHERE (chat_to = '".str_replace(' ', '', Yii::app()->user->name)."' AND chat_recd = 0) ORDER BY chat_sent ASC";
                $query = Yii::app()->db->createCommand($sql)->query();
                
                $count=0;
                foreach ($query as $chat){
                    $count++;
                    $data[$count]['from'] = $chat['chat_from'];
                    $data[$count]['message'] = $chat['chat_message'];
                    $data[$count]['sent'] = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($chat['chat_sent'], 'yyyy-MM-dd hh:mm:ss'));
                }
                
                $data['count'] = ($count>0) ? $count : 0;
                echo CJSON::encode($data);
            }
            Yii::app()->end();
        }
}