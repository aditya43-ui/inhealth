<?php

class PemberianObatPasienController extends MyAuthController
{
    public function actionIndex()
    {
		  $model = new PCObatalkesdetailM;
          $modPenjualan = new PenjualanresepT;
		  $modInfoRI = new PCInfopasienmasukkamarV;
		  $modDetails = array();
          $modObatAlkesPasien = PCObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id'=>$modPenjualan->penjualanresep_id));
		  
		  if (isset($_GET['pendaftaran_id'])){
		  $modInfoRI = PCInfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id'=>$_GET['pendaftaran_id'])); 
		  }
		  
		$this->render('index',array(
			'modInfoRI'=>$modInfoRI,
			'modPenjualan'=>$modPenjualan,
			'modDetails'=>$modDetails,
			'model'=>$model
		));
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
	
	/**
	 * Fungsi untuk
	 * isi tabel (detail pemberian obat)
	 */
	public function actionSetFormDetailPemesanan()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $obatalkes_id = $_POST['obatalkes_id'];
            $jumlah = $_POST['jumlah'];
            $form = "";
            $pesan = "";
            $format = new MyFormatter();
            $modObatAlkes = PCObatAlkesM::model()->findByPk($obatalkes_id);
            if(!empty($modObatAlkes)){
                $modDetailPesanOA = new PCPesanoadetailT;
                $modDetailPesanOA->obatalkes_id = $modObatAlkes->obatalkes_id;
                $modDetailPesanOA->jmlpesan = $jumlah;
                $modDetailPesanOA->satuankecil_id = $modObatAlkes->satuankecil_id;
                $modDetailPesanOA->sumberdana_id = $modObatAlkes->sumberdana_id;
                $form = $this->renderPartial('_rowDetailPemesanan', array('modDetail'=>$modDetailPesanOA), true);
            }else{
                $pesan = "Obat alkes tidak ada!";
            }
            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
            Yii::app()->end(); 
        }
    }
	
	/**
	 * Fungsi untuk
	 * Autocomplete Nama Obat
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
}