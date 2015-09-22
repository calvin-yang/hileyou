<?php
class Gcm
{
    /**
    * GCM发送执行
    * @param $r_regid 手机ID
    * @param $r_agent 信息内容
    * @return array   返回发送状态
    */
    function sendMsg($r_regid,$r_agent,$key)
    { 

        //registration ids
        if(!is_array($r_regid)){
            return false;
            exit;
        }

        //需要发送ID集合（数组类型）
        $_registrationIDs = $r_regid;
        $_agent = $r_agent;
       
        //payload data
        $data   = array('message' =>  $_agent );
        $fields = array('registration_ids' => $_registrationIDs, 'data' => $data);
        //http header 
        $headers = array('Authorization: key=' .$key, 'Content-Type: application/json');
        //curl connection
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, C('GOOGLE_URL'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);  
        return $result; 
       // echo $result;
    } 
   
}
?>