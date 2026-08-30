<?php
/**
 * untuk menyimpan error di database
 * RND-5597
 */
class ReportBugsController extends Controller
{
	public $layout  = "//layouts/iframe";
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionIndex()
	{
		if(isset(Yii::app()->user->id)){
			$this->layout  = "//layouts/mainNeonSidebar";
		}
	    if($error=Yii::app()->errorHandler->error)
	    {
                echo '<pre>';
                var_dump($error);die;
			// echo "<pre>"; //show error 500
			// print_r($error); exit; //show error 500
			$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				$ip_client = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip_client = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip_client = $_SERVER['REMOTE_ADDR'];
			}
				
			$cekReport = ReportbugsR::model()->findByAttributes(array('link_bugs'=>$actual_link,'kodebugs'=>$error['code'],'type_bugs'=>$error['type']));
			if(!$cekReport){
				$model = new ReportbugsR;
				$model->kodebugs = $error['code'];
				$model->judul_bugs = $error['message'];
				$model->pesan_bugs = $error['message']."<br>".$error['trace'];
				$model->link_bugs = $actual_link;
				$model->type_bugs = $error['type'];
				$model->file_bugs = $error['file'];
				$model->line_bugs = $error['line'];
				$model->prioritas_bugs = (($model->kodebugs == '404') ? 1 : 2);
				$model->isajax_bugs = Yii::app()->request->isAjaxRequest;
				if(isset(Yii::app()->user->id)){
					$model->create_login_id = Yii::app()->user->id;
					$model->create_login_nama = Yii::app()->user->getState('nama_pemakai');
					$model->create_pegawai_id = Yii::app()->user->getState('pegawai_id');
					$model->create_instalasi_id = Yii::app()->user->getState('instalasi_id');
					$model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
					$model->create_modul_id = (isset(Yii::app()->session['modul_id']) ? Yii::app()->session['modul_id'] : null);
				}else{
					$model->create_login_nama = "mobile";
				}
				$model->create_hostname_pc = $ip_client;
				$model->create_browser_pc = $_SERVER['HTTP_USER_AGENT'];
				$model->create_datetime = date("Y-m-d H:i:s");
				if($model->save()){
					
				}else{
					echo CHtml::errorSummary($model);
					exit;
				}
			}
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else{
				if(YII_DEBUG == TRUE){
					$this->render('/site/errorForUserBaru', $error);
				}else{
					$this->render('/site/errorForUserBaru', $error);
				}
			}
	    }else{
			echo "Fungsi ini untuk mencatat report bugs";
		}
	}
}
