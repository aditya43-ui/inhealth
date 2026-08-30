<?php

class GabungRekamMedisController extends Controller
{
        public $defaultAction = 'index';
        public $path_view = 'rekamMedis.views.gabungRekamMedis.';  
    
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionPrint()
	{
		$this->render('print');
	}
	
	public function actionAutocompleteNoRM($no_rm = "") {
		if(Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
			$criteria = new CDbCriteria();
			$criteria->compare('statusrekammedis', Params::STATUSREKAMMEDIS_AKTIF);
			$criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rm), true);
			$criteria->order = 'no_rekam_medik';
			$criteria->limit = 5;

			$models = PasienM::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				
				
				$returnVal[$i]['pasien_id'] = $model->pasien_id;
				$returnVal[$i]['no_rekam_medik'] = $model->no_rekam_medik;
				$returnVal[$i]['nama_pasien'] = $model->nama_pasien;
				$returnVal[$i]['nama_bin'] = $model->nama_bin;
				$returnVal[$i]['jeniskelamin'] = $model->jeniskelamin;
				$returnVal[$i]['alamat_pasien'] = $model->alamat_pasien;
				$returnVal[$i]['tanggal_lahir'] = MyFormatter::formatDateTimeForUser($model->tanggal_lahir);
				
				
				$returnVal[$i]['label'] = $model->no_rekam_medik." - ".$model->nama_pasien;
				$returnVal[$i]['value'] = $model->nama_pasien;
			}
			
			$returnVal = CHtml::encodeArray($returnVal);

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
	
	public function actionAjaxLoadKunjungan() {
		Yii::import('pendaftaranPenjadwalan.models.PPPendaftaranT');
		Yii::import('billingKasir.models.BKInformasipasiensudahbayarV');
		Yii::import('rawatJalan.models.RJPasienMasukPenunjangT');
		Yii::import('rawatJalan.models.RJHasilpemeriksaanlabT');
		Yii::import('rawatJalan.models.RJHasilpemeriksaanradT');
		
		if (!Yii::app()->request->isAjaxRequest) {
			Yii::app()->end();
		}
		// var_dump($_POST);die;
		$kunjungan = new PPPendaftaranT;
		$kunjungan->pasien_id = $_POST['id'];
		
		$pasien = PasienM::model()->findByPk($_POST['id']);
		$tagihan = new BKInformasipasiensudahbayarV;
		$tagihan->no_rekam_medik = $pasien->no_rekam_medik;
		
		$pendaftaran = PPPendaftaranT::model()->with('hasilpemeriksaanlab','anamnesa','pemeriksaanfisik','pasienmasukpenunjang','diagnosa')->
                    findAllByAttributes(array(
						'pasien_id' => $_POST['id']
					));
		
		$str = "";
		$str_medis = "";
		$str_tagihan = "";
		
		$tab_list = array();
		$jml_tabel = 0;
		
		foreach ($kunjungan->searchListKunjungan()->data as $item) {
			$str .= $this->renderPartial('_rowKunjungan', array('data'=>$item), true);
		}
		
		foreach ($tagihan->searchInformasi()->data as $item) {
			$str_tagihan .= $this->renderPartial('_rowTagihan', array('data'=>$item), true);
		}
		
		
		foreach ($pendaftaran as $item) {
			$str_medis .= $this->renderPartial('_rowRiwayat', array('data'=>$item), true);
		}
			
		
		
			
		
		
		// if ($_POST['tipe'] == 1) {
		// 	$sql = "select table_name from information_schema.columns where column_name =
		// 		'pasien_id' and 
		// 		(table_name not ilike '%_v') and
		// 		table_name <> 'pasien_m'";
		// 	$data = Yii::app()->db->createCommand($sql)->queryAll();
		
			
		// 	foreach ($data as $item) {
				
		// 		$sql = "select count(pasien_id) as total_data from ".$item['table_name']." where pasien_id = ".$kunjungan->pasien_id;
		// 		$res = Yii::app()->db->createCommand($sql)->queryRow();
		// 		var_dump($data);	die;
		// 		if ($res['total_data'] != 0) {
		// 			array_push($tab_list, $item['table_name']);
		// 			$jml_tabel++;
		// 		}
				
		// 		unset($res);
		// 	}
		
			
		// 	unset($data);
			
		// 	//var_dump($tab_list); die;
		// }
		
		echo CJSON::encode(array('html'=>$str, 'html_medis'=>$str_medis, 'html_tagihan'=>$str_tagihan,'jml_tabel'=>$jml_tabel, 'tab_list'=>$tab_list));
	}
	
	public function actionAjaxVerifikasi() {
		if (!Yii::app()->request->isAjaxRequest) {
			Yii::app()->end();
		}
		
		
		Yii::import('pendaftaranPenjadwalan.models.PPPendaftaranT');
		Yii::import('billingKasir.models.BKInformasipasiensudahbayarV');
		Yii::import('rawatJalan.models.RJPasienMasukPenunjangT');
		Yii::import('rawatJalan.models.RJHasilpemeriksaanlabT');
		Yii::import('rawatJalan.models.RJHasilpemeriksaanradT');
		
		$pasien1 = PasienM::model()->findByPk($_POST['pasien1_id']);
		$pasien2 = PasienM::model()->findByPk($_POST['pasien2_id']);
		
		$kunjungan = new PPPendaftaranT;
		$kunjungan->pasien_id = array($_POST['pasien1_id'], $_POST['pasien2_id']);
		
		$tagihan = new BKInformasipasiensudahbayarV;
		$tagihan->no_rekam_medik = array($pasien1->no_rekam_medik, $pasien2->no_rekam_medik);
		
		$pendaftaran = PPPendaftaranT::model()->with('hasilpemeriksaanlab','anamnesa','pemeriksaanfisik','pasienmasukpenunjang','diagnosa')->
                    findAllByAttributes(array(
						'pasien_id' => array($_POST['pasien1_id'], $_POST['pasien2_id'])
					));
		
		
		
		$rm_hasil = $pasien2->attributes;
		$rm_hasil['tanggal_lahir'] = MyFormatter::formatDateTimeForUser($pasien2->tanggal_lahir);
		
		$str = "";
		$str_medis = "";
		$str_tagihan = "";
		
		
		
		
		
		foreach ($kunjungan->searchListKunjungan()->data as $item) {
			$str .= $this->renderPartial('_rowKunjungan', array('data'=>$item), true);
		}
		
		foreach ($tagihan->searchInformasi()->data as $item) {
			$str_tagihan .= $this->renderPartial('_rowTagihan', array('data'=>$item), true);
		}
		
		
		foreach ($pendaftaran as $item) {
			$str_medis .= $this->renderPartial('_rowRiwayat', array('data'=>$item), true);
		}
			
		echo CJSON::encode(array('rm_hasil'=>$rm_hasil,'html'=>$str, 'html_medis'=>$str_medis, 'html_tagihan'=>$str_tagihan));
		
		
	}
	
	public function actionAjaxMergeNoRM() {
		if (!Yii::app()->request->isAjaxRequest) {
			Yii::app()->end();
		}
		
		$pasienlama_id = $_POST['pasienlama_id'];
		$pasienbaru_id = $_POST['pasienbaru_id'];
		
		
		$pasienLama = PasienM::model()->findByPk($pasienlama_id);
		$pasienBaru = PasienM::model()->findByPk($pasienbaru_id);
		
		$trans = Yii::app()->db->beginTransaction();
		
		$ok = true;
		$msg = "";
		
		// var_dump($_POST); die;
		
		try {
			
			# Load list tabel yang berhubungan dengan pasien_id
			$sql = "select table_name, table_schema from information_schema.columns where column_name =
					'pasien_id' and 
					(table_name not ilike '%_v') and
					table_name <> 'pasien_m'";
			$dataTabel = Yii::app()->db->createCommand($sql)->queryAll();

			$count = array();
			
			$record = new MergerekammedikR();
			$record->tglmerge = date('Y-m-d H:i:s');
			$record->pasienlama_id = $pasienlama_id;
			$record->pasienbaru_id = $pasienbaru_id;
			
			if ($record->validate() || $record->validate()) {
				$ok = $ok && $record->save();
			} else {
				$ok = false;
			}
			
			
			// var_dump($record->attributes); die;
			$rowTotal = 0;
			$resTabel = array();
			
			foreach ($dataTabel as $item) {
				$item['table_name'] = $item['table_schema'].".".$item['table_name'];
			 	$sql = "select count(pasien_id) as total_data from ".$item['table_name']." where pasien_id = ".$pasienlama_id;
			 	$res = Yii::app()->db->createCommand($sql)->queryRow();
				
			 	if ($res['total_data'] != 0) {
			 		$rowTotal++; 
			 		array_push($resTabel, array(
			 			'table_name'=>$item['table_name'],
			 			'total_data'=>$res['total_data'],
			 		));
			 	}
			}


			// var_dump($resTabel); die;
			
			foreach ($resTabel as $idx => $item) {
				
				$this->simpanDataProgress($pasienlama_id, $pasienbaru_id, $idx + 1, $rowTotal);
				
				$det = new MergerekammediktabelR;
				$det->mergerekammedik_id = $record->mergerekammedik_id;
				$det->nama_tabel = $item['table_name'];
				$det->jumlah_data = $item['total_data'];
					
				$ok = $ok && $det->save();
				// var_dump($ok); die;
				// var_dump($det->attributes);
					
				$ok = $ok && Yii::app()->db->createCommand()->update($item['table_name'], array(
					'pasien_id'=>$pasienbaru_id,
				), 'pasien_id = '.$pasienlama_id);				
				
				$ok = true;
			
				unset($res);
				
				// $sql = "update ".$item['table_name']." set pasien_id = ".$pasienbaru_id." where pasien_id = ".$pasienlama_id.";";
			}
		
			unset($item);
			// die;
			
			PasienM::model()->updateByPk($pasienlama_id, array(
				'statusrekammedis'=>Params::STATUSREKAMMEDIS_NON_AKTIF,
			));
         
			// var_dump($ok);
			if ($ok) {
				$trans->commit();
				$msg = "No. RM (".$pasienLama->no_rekam_medik.") berhasil dipindahkan ke No RM (".$pasienBaru->no_rekam_medik.")";
			} else {
				$trans->rollback();
				$ok = false;
				$msg = "No. RM (".$pasienLama->no_rekam_medik.") gagal dipindahkan ke No RM (".$pasienBaru->no_rekam_medik.")";
			}
			
		} catch (Exception $e) {
			$trans->rollback();
			
			$ok = false;
			$msg = "No RM. Lama gagal dipindahkan.<br/>".$e->getMessage();
		}
		
		echo CJSON::encode(array(
			'ok' => ($ok == true) ? 1 : 0,
			'msg'=>$msg,
		));
		
	}
	
	
	protected function simpanDataProgress($pasienlama_id, $pasienbaru_id, $progress, $total) {
		if (!file_exists(Yii::app()->basePath."/../assets/temp_rm")) {
			mkdir(Yii::app()->basePath."/../assets/temp_rm");
		}
		
		$fp = fopen(Yii::app()->basePath."/../assets/temp_rm/rm_".$pasienlama_id."_".$pasienbaru_id.".json", "w");
		
		fwrite($fp, utf8_decode(CJSON::encode(array(
			'progress'=>$progress,
			'total'=>$total,
		))));
		
		fclose($fp);
		
		
		// var_dump((file_exists(Yii::app()->basePath."/../assets/temp_rm"))); die;
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
        
    public function actionInformasi(){       
       $this->layout = '//layouts/mainNeonSidebar';
       
       $model  = new RKInfoGabungBerkasRMV();
       $model->tgl_awal = date('Y-m-d');
       $model->tgl_akhir = date('Y-m-d');
       
       if (isset($_GET['RKInfoGabungBerkasRMV'])){
           $model->attributes = $_GET['RKInfoGabungBerkasRMV'];
           $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['RKInfoGabungBerkasRMV']['tgl_awal']);
           $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['RKInfoGabungBerkasRMV']['tgl_akhir']);
           $model->no_rekam_medik_lama = $_GET['RKInfoGabungBerkasRMV']['no_rekam_medik_lama'];
           $model->no_rekam_medik_baru = $_GET['RKInfoGabungBerkasRMV']['no_rekam_medik_baru'];
           $model->nama_pasien_lama = $_GET['RKInfoGabungBerkasRMV']['nama_pasien_lama'];
           $model->nama_pasien_baru = $_GET['RKInfoGabungBerkasRMV']['nama_pasien_baru'];
       }
       
       $this->render($this->path_view.'informasi',array('model' => $model));
   }
}