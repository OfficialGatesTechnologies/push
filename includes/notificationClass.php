<?php
require_once 'class.upload.php'; 
class NotificationClass extends upload{
	public function __construct() {
		$this->processNotification();
	}
	
	function getUserList()
	{        
			$arrUsers = array();
			$selQry = 'SELECT * FROM `fcm_users` WHERE 1 ';
			$selQry.=' AND `status` = "0"';
			$selQry .= ' LIMIT 500';
  			$qryRes = mysqli_query($GLOBALS['DBC'],$selQry);	
			if(mysqli_num_rows($qryRes))	 {
				while($qryRow = mysqli_fetch_assoc($qryRes)) {				
					$arrUsers[$qryRow['userId']] = $qryRow['userFcmToken'];								
				}
				return $arrUsers;
			}else {
				return false;
			}
	 }
	 function processNotification(){
		extract($_POST);
		extract($_GET);
		ini_set('memory_limit', '10000M');
		ini_set('max_execution_time', '-1'); 
	
		$img_data = '';
		if(is_array($_FILES['fileImage']) && $_FILES['fileImage']['tmp_name'] != ''){
			$uploadName = $this->imageUpload($_FILES['fileImage']);
			$img_data = SITE_URL.'images/'.$uploadName;
		}
		do_next:  
		$arrUsers  = 	$this->getUserList();
		if(!empty($arrUsers)){
			$deviceToken = (array_values($arrUsers));
			$userIds = implode(',',array_keys($arrUsers));
			$data = array('body' => $description, 'title' => $title,
				'img_data'=>$img_data, 
			);
			$actionQry =' UPDATE `fcm_users` ';
			$actionQry.= '  SET  `status` = "1"';
			$actionQry.= ' WHERE `fcm_users`.`userId` IN  ('.$userIds.')';
			$qryExe = mysqli_query($GLOBALS['DBC'],$actionQry);
			$res = $this->triggerNotification(($deviceToken), $msg, $data,$img_data);
			goto do_next;
		}
 
		echo 'done';exit;
	 
		
	}
	function triggerNotification($registrationIds, $msg, $data = array(),$img_data = false)
    {
        
        $GCM_API_KEY = GCM_API_KEY;
        $url = 'https://fcm.googleapis.com/fcm/send';
		$msg = array(
			'body' => $data['body'],
			'title' => $data['title'],
			'tag' => $data['title'],
			'sound' => 'mySound'
		);
		if ($img_data) {
            $msg['image'] = $img_data;
        }
		$fields = array
		(
			'registration_ids' => ($registrationIds),
			'data' => $msg
		);
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$GCM_API_KEY
        );
        // echo json_encode( $headers );exit;
       
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        // //echo curl_error($ch);exit;
        // curl_close($ch);
        // ob_start();
        // print_r($result);exit;
        // print_r($fields);
        // $content = ob_get_contents();
        // ob_end_clean();
        // @mail();
        return $result;
    }
	function imageUpload($files){
		$objUpload = new Upload($files);
		if ($objUpload->uploaded) {
			$dir_pics = 'images/';
			$file_new_name_body = 'banner_'.date('d-m-Y-H-i-s');
			$objUpload->file_new_name_body = $file_new_name_body;
			$objUpload->file_safe_name = true;
			$objUpload->Process($dir_pics);
			if ($objUpload->processed) {
				$uploadFile3Name = $objUpload->file_dst_name;
			} else {
				$uploadFile3Name = false;
			}
			return $uploadFile3Name;
		}
	}
 	
 
}
?>