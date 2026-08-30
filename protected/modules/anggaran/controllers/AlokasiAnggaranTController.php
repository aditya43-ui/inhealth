<?php

class AlokasiAnggaranTController extends MyAuthController{
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $alokasianggaransimpan = false;
	
	public function actionIndex($alokasianggaran_id = null){
		$format = new MyFormatter;
		$model = new AGAlokasianggaranT;
		$modDetails = array();
		$modProgramKerja = new AGInformasialokasianggaranV;
		$model->tglalokasianggaran = $format->formatDateTimeForUser(date("Y-m-d"));
		//		load untuk Unit kerja otomatis keluar berdasarkan login
		$ruangan_id = (isset(Yii::app()->user->ruangan_id)? Yii::app()->user->ruangan_id : null);
		$ruangan_nama = AGUnitkerjaruanganM::model()->findByAttributes(array('ruangan_id'=>$ruangan_id));
		if(!empty($ruangan_nama)){	
			$unitkerja_nama = AGUnitkerjaM::model()->findByPk($ruangan_nama->unitkerja_id);
			$model->unitkerja_id = $unitkerja_nama->unitkerja_id;
		}else{
			$model->unitkerja_id = "";
		}
		
		if(!empty($alokasianggaran_id)){
			$model = AGAlokasianggaranT::model()->findByPk($alokasianggaran_id);
			$model->sumberanggarannama = $model->sumberanggaran->sumberanggarannama;
			$model->subkegiatanprogram_nama = $model->subkegiatanprogram->subkegiatanprogram_nama;
			$model->pegawaimengetahui_nama = (isset($model->mengetahui->NamaLengkap) ? $model->mengetahui->NamaLengkap : "");
			$model->pegawaimenyetujui_nama = (isset($model->menyetujui->NamaLengkap) ? $model->menyetujui->NamaLengkap : "");
			$model->nilaiygdialokasikan = 0;
			$modDetails = AlokasianggaranT::model()->findAllByAttributes(array('no_alokasi'=>$model->no_alokasi));
		}
		if(isset($_POST['AGAlokasianggaranT'])){
            $transaction = Yii::app()->db->beginTransaction();
            try {
				// menambahkan digitnilaianggaran dari tabel konfiganggaran_k
				$modKonfig = AGKonfiganggaranK::model()->findByPk($model->konfiganggaran_id);
				$digitNilai = isset($modKonfig->digitnilaianggaran) ? $modKonfig->digitnilaianggaran : null;
				$model->no_alokasi = MyGenerator::noAlokasiAnggaran();
				if(count((array)$_POST['AlokasianggaranT']) > 0){
					foreach($_POST['AlokasianggaranT'] AS $i => $postAlokasiDet){
						$modDetails[$i] = $this->simpanAlokasiAnggaran($_POST['AGAlokasianggaranT'],$model,$postAlokasiDet);
					}
				}
				if($this->alokasianggaransimpan){
					$transaction->commit();
					$this->redirect(array('index','alokasianggaran_id'=>$modDetails[0]->alokasianggaran_id,'sukses'=>1));
				}else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data Alokasi Anggaran gagal disimpan !");
				}
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Alokasi Anggaran gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
		}
		
		$this->render('index',array(
			'format'=>$format,
			'model'=>$model,
			'modDetails'=>$modDetails,
			'modProgramKerja'=>$modProgramKerja
			));
	}
	
	/**
     * simpan AGAlokasianggaranT
     * @param type $postAlokasi
     * @param type $model
     * @param type $postAlokasiDet
     * @return \AGAlokasianggaranT
     */
    protected function simpanAlokasiAnggaran($postAlokasi,$dataAlokasi,$postAlokasiDet){
        $format = new MyFormatter;
        $model = new AGAlokasianggaranT;
		$model->attributes = $_POST['AGAlokasianggaranT'];
		$model->tglalokasianggaran = $format->formatDateTimeForDb($_POST['AGAlokasianggaranT']['tglalokasianggaran']);
		$model->no_alokasi = $dataAlokasi->no_alokasi;
		$model->tglmengetahui = date("Y-m-d H:i:s");
		$model->tglmenyetujui = date("Y-m-d H:i:s");
		$model->nilairencana = $postAlokasiDet['nilairencana'];
		$model->nilaiygdialokasikan = $postAlokasiDet['nilaiygdialokasikan'];
		$model->sisaanggaran = $model->nilairencana - $model->nilaiygdialokasikan;
		$model->apprrencanggaran_id = $postAlokasiDet['apprrencanggaran_id'];
		$model->realisasianggpenerimaan_id = $postAlokasiDet['realisasianggpenerimaan_id'];
		$model->subkegiatanprogram_id = $postAlokasiDet['subkegiatanprogram_id'];
		$model->sumberanggaran_id = $postAlokasiDet['sumberanggaran_id'];
		$model->create_time = date("Y-m-d H:i:s");
		$model->create_loginpemakai_id = Yii::app()->user->id;
		$model->create_ruangan = Yii::app()->user->ruangan_id;	

        if($model->validate()){
			$model->save();            
			$this->alokasianggaransimpan = true;
			$this->updateApprrencanaAnggaran($model);
        }else{
            $this->alokasianggaransimpan = false;
        }
        return $model;
    }
	
	
	/**
     * update AGApprrencanggaranT
     * @param type $model
     * @return \AGApprrencanggaranT
     */
    protected function updateApprrencanaAnggaran($model){
		
        $format = new MyFormatter;
		$modApprrencAnggaran = AGApprrencanggaranT::model()->findByPk($model->apprrencanggaran_id);
		
		$jumlahalokasi = $modApprrencAnggaran->nilaiygsudahalokasi + $model->nilaiygdialokasikan;
		if($modApprrencAnggaran->nilaiygdisetujui == $jumlahalokasi){
			$modApprrencAnggaran->nilaiygsudahalokasi = $modApprrencAnggaran->nilaiygsudahalokasi + $model->nilaiygdialokasikan;
			$modApprrencAnggaran->statusalokasi = TRUE;
		}else{
			$modApprrencAnggaran->nilaiygsudahalokasi = $modApprrencAnggaran->nilaiygsudahalokasi + $model->nilaiygdialokasikan;
			$modApprrencAnggaran->statusalokasi = FALSE;
		}
		
        if($modApprrencAnggaran->validate()){
			$modApprrencAnggaran->save();            
        }
		
        return $modApprrencAnggaran;
    }
	
	public function actionAutocompletePegawaiMengetahui()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = AGPegawaiV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai." ".$model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
	
    public function actionAutocompletePegawaiMenyetujui()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
            $criteria = new CDbCriteria();
			$criteria->group = 'nomorindukpegawai,nama_pegawai,gelardepan,gelarbelakang_nama,alamat_pegawai,pegawai_id';
			$criteria->select = $criteria->group;
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = AGPegawairuanganV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai." ".$model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
	
	public function actionCekDigit() {
		if(Yii::app()->request->isAjaxRequest) {
			$konfiganggaran_id=$_POST['konfig_id'];
			$modKonfig=AGKonfiganggaranK::model()->findByPk($konfiganggaran_id);
			if ($modKonfig->digitnilaianggaran === "0"){
				 $data['digit'] = null;
			}else {
				$data['digit'] = (isset($modKonfig->digitnilaianggaran) ? " / ".$modKonfig->digitnilaianggaran : null);
			}
			echo json_encode($data);
			Yii::app()->end();
		}
	}  
	
	/**
    * menampilkan alokasi anggaran detail
    * @return row table 
    */
    public function actionLoadFormTambahAlokasiAnggaran()
    {
        if(Yii::app()->request->isAjaxRequest) { 
			$pesan = '';
			$date = date("d");
            $apprrencanggaran_id	= isset($_POST['apprrencanggaran_id']) ? $_POST['apprrencanggaran_id'] : null;
            $programkerja_id		= isset($_POST['programkerja_id']) ? $_POST['programkerja_id'] : null;
            $subprogramkerja_id		= isset($_POST['subprogramkerja_id']) ? $_POST['subprogramkerja_id'] : null;
            $kegiatanprogram_id		= isset($_POST['kegiatanprogram_id']) ? $_POST['kegiatanprogram_id'] : null;
            $subkegiatanprogram_id	= isset($_POST['subkegiatanprogram_id']) ? $_POST['subkegiatanprogram_id'] : null;
            $nilaiygdialokasikan	= isset($_POST['nilaiygdialokasikan']) ? $_POST['nilaiygdialokasikan'] : null;
            $nilaipengeluaran		= isset($_POST['nilaipengeluaran']) ? $_POST['nilaipengeluaran'] : null;
            $sumberanggaran_id		= isset($_POST['sumberanggaran_id']) ? $_POST['sumberanggaran_id'] : null;
            $realisasianggpenerimaan_id		= isset($_POST['realisasianggpenerimaan_id']) ? $_POST['realisasianggpenerimaan_id'] : null;
			$modSumberanggaran = AGSumberanggaranM::model()->findByPk($sumberanggaran_id);
			
            $format = new MyFormatter();
            $modAlokasiAnggaran = new AlokasianggaranT;
			
			$criteria = new CDbCriteria();
			
			if(!empty($apprrencanggaran_id)){
				$criteria->addCondition('apprrencanggaran_id = '.$apprrencanggaran_id);
			}
			if(!empty($programkerja_id)){
				$criteria->addCondition('programkerja_id = '.$programkerja_id);
			}
			if(!empty($subprogramkerja_id)){
				$criteria->addCondition('subprogramkerja_id = '.$subprogramkerja_id);
			}
			if(!empty($kegiatanprogram_id)){
				$criteria->addCondition('kegiatanprogram_id = '.$kegiatanprogram_id);
			}
			if(!empty($subkegiatanprogram_id)){
				$criteria->addCondition('subkegiatanprogram_id = '.$subkegiatanprogram_id);
			}
            $modProgramKerja = AGInformasialokasianggaranV::model()->find($criteria);
			if(!empty($modProgramKerja)){
				$modAlokasiAnggaran->nilairencana = $nilaipengeluaran;
				$modAlokasiAnggaran->nilaiygdialokasikan = $nilaiygdialokasikan;
				$modAlokasiAnggaran->subkegiatanprogram_id = $modProgramKerja->subkegiatanprogram_id;
				$modAlokasiAnggaran->apprrencanggaran_id = $modProgramKerja->apprrencanggaran_id;
				$modAlokasiAnggaran->sumberanggaran_id = $sumberanggaran_id;
				$modAlokasiAnggaran->sumberanggarannama = $modSumberanggaran->sumberanggarannama;
				$modAlokasiAnggaran->realisasianggpenerimaan_id = $realisasianggpenerimaan_id;
			}else{
				$pesan = 'Data Program Kerja tidak ditemukan !';
			}
            
            echo CJSON::encode(array(
                'status'=>'create_form', 
				'pesan'=>$pesan,
                'form'=>$this->renderPartial('_rowAlokasiAnggaran', array(
                        'format'=>$format,
                        'modAlokasiAnggaran'=>$modAlokasiAnggaran,
                        'modProgramKerja'=>$modProgramKerja,
                    ), 
                true))
            );
            exit;  
        }
    }
	
	/**
     * untuk print alokasi anggaran
     */
    public function actionPrint($alokasianggaran_id,$caraPrint = null) 
    {
		$this->layout='//layouts/iframe';
        $format = new MyFormatter;    
        $mod = AGAlokasianggaranT::model()->findByAttributes(array('alokasianggaran_id'=>$alokasianggaran_id));     
		$model  = AGAlokasianggaranT::model()->findAllByAttributes(array(
			'no_alokasi'=>$mod->no_alokasi
		));
		$judulLaporan = 'Alokasi Anggaran';
		$deskripsi = $model[0]->konfiganggaran->deskripsiperiode;
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }else if($caraPrint=='GRAFIK') {
            $this->layout='//layouts/iframeNeon';
        }
        
        $this->render('Print', array(
                'format'=>$format,
                'judulLaporan'=>$judulLaporan,
                'deskripsi'=>$deskripsi,
                'model'=>$model,
                'caraPrint'=>$caraPrint
        ));
    }
	
    public function actionAutocompleteSumberAnggaran()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(sumberanggarannama)', strtolower($_GET['sumberanggaran_nama']), true);
            $criteria->order = 'sumberanggarannama';
            $criteria->limit = 5;
            $models = AGInformasialokasianggaranV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->sumberanggarannama;
                $returnVal[$i]['value'] = $model->sumberanggaran_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
}

