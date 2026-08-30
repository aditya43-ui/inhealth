<?php
/**
 * menyimpan log untuk error / warning ke database
 * 
 */
class MyReportBugsLog extends CFileLogRoute
{
	public $levels = "error, warning";
	private $is_adakoneksidb = false;
	private $connection;
	/**
	 * Initializes the route.
	 * This method is invoked after the route is created by the route manager.
	 */
	public function init()
	{
		parent::init();
		$errormsg = "";
		try{
			$this->connection=new CDbConnection();
			$this->connection=Yii::app()->db;
			$this->connection->active=true;
		}catch(CDbException $e){
			$errormsg = $e->getMessage(); // Or do something else
		}
		if(empty($errormsg)){
			$this->is_adakoneksidb = true;
		}
		
	}

	/**
	 * Saves log messages in files.
	 * @param array $logs list of log messages
	 */
	protected function processLogs($logs)
	{
		if($this->is_adakoneksidb == true){
//			$logFile=$this->getLogPath().DIRECTORY_SEPARATOR.$this->getLogFile();
//			if(@filesize($logFile)>$this->getMaxFileSize()*1024)
//				$this->rotateFiles();
//			$fp=@fopen($logFile,'a');
//			@flock($fp,LOCK_EX);
//			foreach($logs as $log)
//				@fwrite($fp,$this->formatLogMessage($log[0],$log[1],$log[2],$log[3]));
//			@flock($fp,LOCK_UN);
//			@fclose($fp);
			
			if(count($logs) > 0){
				foreach ($logs AS $i => $log){
					if(strtolower($log[1]) == 'error' && strtolower($log[2]) == 'php'){
		//				$cekReport = ReportbugsR::model()->findByAttributes(array('link_bugs'=>$actual_link,'kodebugs'=>$error['code'],'type_bugs'=>$error['type']));
						$judul_bugs = strstr($log[0], 'Stack', TRUE);
//						echo $judul_bugs;
						$file_bugs = explode("(", $judul_bugs);
						$file_bugs = explode(":",$file_bugs[1]);
						$line_bugs = explode(")",$file_bugs[1]);
						$line_bugs = $line_bugs[0];
						$file_bugs = $file_bugs[0];
//						print_r($file_bugs);
//						exit;
						$sql = "SELECT reportbugs_id 
								FROM reportbugs_r
								WHERE LOWER(judul_bugs) LIKE '%".strtolower(substr($judul_bugs,0,150))."%'
								LIMIT 1 ";
						$cekReport = Yii::app()->db->createCommand($sql)->queryRow();
						
						if(!isset($cekReport['reportbugs_id'])){
							$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
							if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
								$ip_client = $_SERVER['HTTP_CLIENT_IP'];
							} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
								$ip_client = $_SERVER['HTTP_X_FORWARDED_FOR'];
							} else {
								$ip_client = $_SERVER['REMOTE_ADDR'];
							}
							$transaction = Yii::app()->db->beginTransaction();
							try
							{
								$model = new ReportbugsR;
								$model->kodebugs = "LOG ".$log[1];
								$model->judul_bugs = $judul_bugs;
								$model->pesan_bugs = $log[0];
								$model->link_bugs = $actual_link;
								$model->type_bugs = $log[2];
								$model->file_bugs = $file_bugs;
								$model->line_bugs = $line_bugs;
								$model->prioritas_bugs = 1;
								$model->isajax_bugs = (isset(Yii::app()->request->isAjaxRequest) ? Yii::app()->request->isAjaxRequest : false);
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
									$transaction->commit();
								}else{
									echo CHtml::errorSummary($model);
									exit;
								}
							}
							catch(Exception $e) // an exception is raised if a query fails
							{
								$transaction->rollback();
								echo ($e);
								exit;
							}
						}
					}
				}
			}
			
		}else{
			parent::processLogs($logs);
		}
	}

}