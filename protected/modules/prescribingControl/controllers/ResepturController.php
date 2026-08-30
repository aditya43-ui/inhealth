<?php
class ResepturController extends MyAuthController
{       
	public $layout='//layouts/column1';
	protected $successSave = false;

	public function actionIndex($pendaftaran_id = null,$pasienadmisi_id = null)
	{
		$modInfoRI = new PCInfopasienmasukkamarV;
		
		$modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id)) : array();
		$modPendaftaran= new PCPendaftaranT;
		$modPasien = PCPasienM::model()->findByPk($modPendaftaran->pasien_id);

		$instalasi_id = Yii::app()->user->getState('instalasi_id');
		$modReseptur = new PCResepturT;
		$instalasi_id = Yii::app()->user->getState('instalasi_id');
		$modReseptur->noresep = MyGenerator::noResepReseptur($instalasi_id);
		$modReseptur->noresep_depan = $modReseptur->noresep.'/';
		$modReseptur->pegawai_id = $modPendaftaran->pegawai_id;
		$modReseptur->ruanganreseptur_id = Yii::app()->user->getState('ruangan_id');

			if(isset($_POST['PCResepturT'])){
				$transaction = Yii::app()->db->beginTransaction();
				try {
					$modPendaftaran = PCPendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
					$this->saveReseptur($_POST, $modPendaftaran);

					if($this->successSave){
						$transaction->commit();
						Yii::app()->user->setFlash('success',"Data Reseptur berhasil disimpan");
						$this->redirect(array('index', 'sukses'=>1));
					} else {
						$transaction->rollback();
						Yii::app()->user->setFlash('error',"Data gagal disimpan ");
					}
				} catch (Exception $exc) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
				}
			}
		$modRiwayatResep = PCResepturT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id,'ruanganreseptur_id'=>Yii::app()->user->getState('ruangan_id')),array('order'=>'t.create_time DESC'));

		$this->render('index',array('modPendaftaran'=>$modPendaftaran,
									'modPasien'=>$modPasien,
									'modReseptur'=>$modReseptur,
									'modAdmisi'=>$modAdmisi,
									'modRiwayatResep'=>$modRiwayatResep,
									'modInfoRI'=>$modInfoRI));
	}
        
	protected function saveReseptur($post,$modPendaftaran)
	{
		$reseptur = new PCResepturT;
		$reseptur->pendaftaran_id = $modPendaftaran->pendaftaran_id;
		$reseptur->tglreseptur = $post['PCResepturT']['tglreseptur'];
		$instalasi_id = Yii::app()->user->getState('instalasi_id');
	$reseptur->noresep_depan = MyGenerator::noResepReseptur($instalasi_id);
	$reseptur->noresep_depan = $reseptur->noresep_depan.'/';
		$reseptur->noresep = $reseptur->noresep_depan."".$post['PCResepturT']['noresep_belakang'];
		$reseptur->pegawai_id = $post['PCResepturT']['pegawai_id'];
		$reseptur->ruangan_id = $post['PCResepturT']['ruangan_id'];
		$reseptur->ruanganreseptur_id = Yii::app()->user->getState('ruangan_id');
		$reseptur->pasien_id = $modPendaftaran->pasien_id;
//		$reseptur->pasienadmisi_id = $_GET['pasienadmisi_id'];
		if($reseptur->validate()){
			$reseptur->save();                
			$this->saveDetailReseptur($post, $reseptur);
		} else {
			$this->successSave = false;
		}
	}
        
	protected function saveDetailReseptur($post,$reseptur)
	{
		$valid = true;
		for ($i = 0; $i < count((array)$post['obat']); $i++) {
			$detail = new PCResepturDetailT;
			$detail->reseptur_id = $reseptur->reseptur_id;
			$detail->obatalkes_id = $post['obat'][$i];
			$detail->sumberdana_id = $post['sumberdana'][$i];
			$detail->satuankecil_id = $post['satuankecil'][$i];
			$detail->racikan_id = ($post['isRacikan'][$i]) ? Params::RACIKAN_ID_NONRACIKAN : Params::RACIKAN_ID_RACIKAN;
			$detail->r = 'R/';
			$detail->rke = $post['Rke'][$i];
			$detail->qty_reseptur = $post['qty'][$i];
			$detail->signa_reseptur = $post['signa'][$i];
			$detail->etiket = $post['etiket'][$i];
			$detail->kekuatan_reseptur = $post['kekuatan'][$i];
			$detail->satuankekuatan = $post['satuankekuatan'][$i];
			$detail->hargasatuan_reseptur = $post['hargasatuan'][$i];
			$detail->harganetto_reseptur = $post['harganetto'][$i];
			$detail->hargajual_reseptur = $post['hargajual'][$i] * $post['qty'][$i];

			$detail->permintaan_reseptur = $post['jmlpermintaan'][$i];
			$detail->jmlkemasan_reseptur = $post['jmlkemasan'][$i];
			$valid = $detail->validate() && $valid;
			if($valid){
				$detail->save();
			}
		}

		$this->successSave = ($valid) ? true : false;
	}

	/**
	 * method to get obat reseptur
	 * used in :
	 * 1. rawatInap/resepturTRI
	 */
	public function actionObatReseptur()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$criteria = new CDbCriteria();
			$criteria2 = new CDbCriteria;
			$criteria2->compare('LOWER(obatalkes_nama)',strtolower($_GET['term']),true);
			$modObat = ObatalkesM::model()->find($criteria2);
			if(isset($modObat)){
				$generik_id = $modObat->generik_id;
				if(!empty($generik_id)){              
					$criteria->addCondition("LOWER(t.obatalkes_nama) ILIKE '%".$_GET['term']."%' OR t.generik_id = ".$generik_id);
				}
			}else{
				$criteria->compare('LOWER(obatalkes_nama)',strtolower($_GET['term']),true);
			}
			$criteria->addCondition('obatalkes_farmasi = TRUE');
			$criteria->addCondition('obatalkes_aktif = true');                
			$criteria->order = 'obatalkes_nama';
			$criteria->limit = 5;
			$models = ObatalkesM::model()->with('sumberdana','satuankecil')->findAll($criteria);
			$persenjual = $this->persenJualRuangan();
			$format = new MyFormatter();
			$returnVal = array();
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();

				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$qtyStok = StokobatalkesT::getJumlahStok($model->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
				$returnVal[$i]['label'] = $model->obatalkes_kode." - ".$model->obatalkes_nama;
				$returnVal[$i]['value'] = $model->obatalkes_nama;
				$returnVal[$i]['sumberdana_nama'] = $model->sumberdana->sumberdana_nama;
				$returnVal[$i]['qtyStok'] = $qtyStok;
				$returnVal[$i]['hargajual'] = floor(($persenjual + 100 ) / 100 * $model->hargajual);
				$returnVal[$i]['satuankecil'] = $model->satuankecil->satuankecil_nama;
				$returnVal[$i]['idsatuankecil'] = $model->satuankecil_id;
				$returnVal[$i]['diskonJual'] = empty($model->diskonJual) ? 0 : $model->diskonJual;
				$returnVal[$i]['kadaluarsa'] = ((strtotime($format->formatDateTimeForDb($model->tglkadaluarsa)) - strtotime(date('Y-m-d'))) > 0) ? 0 : 1 ;
			}
			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
        
	protected function persenJualRuangan()
	{
		switch(Yii::app()->user->getState('instalasi_id')){
			case Params::INSTALASI_ID_RI : $persen = Yii::app()->user->getState('ri_persjual');
											break;
			case Params::INSTALASI_ID_RJ : $persen = Yii::app()->user->getState('rj_persjual');
											break;
			case Params::INSTALASI_ID_RD : $persen = Yii::app()->user->getState('rd_persjual');
											break;
			default : $persen = 0; break;
		}

		return $persen;
	}
	
	public function actionPrint()
	{
		$pendaftaran_id = $_GET['id'];
		$criteria=new CDbCriteria;
		$criteria->addCondition("create_time=(select max(create_time) from reseptur_t)");
		$maxtime = PCResepturT::model()->find($criteria);
		$modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$maxtime->reseptur_id));
		$modPendaftaran = PCPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
		$judulLaporan='Reseptur';
		$caraPrint=$_REQUEST['caraPrint'];
		If(isset($_GET['idReseptur'])){
			$modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$_GET['idReseptur']));
			if($caraPrint=='PRINT') {
				$this->layout='//layouts/printWindows';
				$this->render('_viewDetailResep',array('modPendaftaran'=>$modPendaftaran,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint,'modDetailResep'=>$modDetailResep));
			}
		}else{
			if($caraPrint=='PRINT') {
				$this->layout='//layouts/printWindows';
				$this->render('Print',array('modPendaftaran'=>$modPendaftaran,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint,"modDetailResep"=>$modDetailResep));
			}
		}
	}
		
	public function actionAjaxDetailResep()
	{
		if(Yii::app()->request->isAjaxRequest) {
		$idReseptur = $_POST['idReseptur'];
		$pendaftaran_id = $_POST['pendaftaran_id'];
	$modPendaftaran=PCPendaftaranT::model()->findByPk($pendaftaran_id);
		$modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$idReseptur));

		$data['result'] = $this->renderPartial('_viewDetailResep', array('modDetailResep'=>$modDetailResep,'modPendaftaran'=>$modPendaftaran), true);

		echo json_encode($data);
		 Yii::app()->end();
		}
	}
	
	public function actionHapusRiwayatReseptur(){
		if(Yii::app()->request->isAjaxRequest) {
			$data['pesan'] = "";
			$data['sukses'] = 0;
			$transaction = Yii::app()->db->beginTransaction();
			try {
		$detailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$_POST['reseptur_id']));
		$resep = ResepturT::model()->findByPk($_POST['reseptur_id']);
		$deleteDetailResep = ResepturdetailT::model()->deleteAllByAttributes(array('reseptur_id'=>$_POST['reseptur_id']));
					if($deleteDetailResep){
			if($resep->delete()){
				$data['pesan'] = "Riwayat Resep Termasuk Detail Resep Berhasil Dihapus!";
				$data['sukses'] = 1;
				$transaction->commit();
			}else{
				$transaction->rollback();
				$data['pesan'] = "Gagal Menghapus Reseptur";
				$data['sukses'] = 0;
			}
					}else{
						$transaction->rollback();
						$data['pesan'] = "Gagal Menghapus Detail Reseptur";
						$data['sukses'] = 0;
					}
			}catch (Exception $exc) {
				$transaction->rollback();
				$data['pesan'] = "Transaksi Gagal :".MyExceptionMessage::getMessage($exc,true);
			}
			echo CJSON::encode($data);
		}
		Yii::app()->end();
	}	
	
    /**
     * Mengurai data pasien berdasarkan:
     * - instalasi_id
     * - pendaftaran_id
     * - pasienadmisi_id
     * - no_pendaftaran
     * - no_rekam_medik
     * @throws CHttpException
     */
    public function actionGetDataInfoPasien()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
            $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
            $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
            $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
            $returnVal = array();
            $criteria = new CDbCriteria();
			if(!empty($pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);						
			}
			if(!empty($pasienadmisi_id)){
				$criteria->addCondition("pasienadmisi_id = ".$pasienadmisi_id);						
			}
			if(!empty($instalasi_id)){
				$criteria->addCondition("instalasi_id = ".$instalasi_id);						
			}
            $criteria->compare('LOWER(no_pendaftaran)',strtolower(trim($no_pendaftaran)));
            $criteria->compare('LOWER(no_rekam_medik)',strtolower(trim($no_rekam_medik)));
            if($instalasi_id == Params::INSTALASI_ID_RD){
                $model = PCInfoKunjunganRDV::model()->find($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RJ){
                $model = PCInfoKunjunganRJV::model()->find($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RI){
                $model = PCInfopasienmasukkamarV::model()->find($criteria);
            }
            $attributes = $model->attributeNames();
            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
            $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
}