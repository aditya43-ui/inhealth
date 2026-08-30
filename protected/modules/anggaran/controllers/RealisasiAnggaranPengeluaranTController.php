<?php
class RealisasiAnggaranPengeluaranTController extends MyAuthController{
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $tandaBuktiKeluar = false;
	public $realisasiPengeluaran = false;
	
	public function actionIndex($realisasianggpeng_id = null){
		$format = new MyFormatter;
		$model = new AGRealisasianggpengT;
		$model->no_realisasi_peng = MyGenerator::noReaAnggPeng();
		$model->pegawaimengetahui_nama = isset($model->realisasimengetahui_id) ? AGPegawaiV::model()->findByAttributes(array('pegawai_id'=>$model->realisasimengetahui_id))->nama_pegawai : "";
		$model->pegawaimenyetujui_nama = isset($model->realisasimenyetujui_id) ? AGPegawaiV::model()->findByAttributes(array('pegawai_id'=>$model->realisasimenyetujui_id))->nama_pegawai : "";
		$modTandaBuktiKeluar = new AGTandabuktikeluarT;
		
		if (!empty($realisasianggpeng_id)) {
			$model = AGRealisasianggpengT::model()->findByPk($realisasianggpeng_id);
			$model->pegawaimengetahui_nama = isset($model->realisasimengetahui_id) ? AGPegawaiV::model()->findByAttributes(array('pegawai_id'=>$model->realisasimengetahui_id))->nama_pegawai : "";
			$model->pegawaimenyetujui_nama = isset($model->realisasimenyetujui_id) ? AGPegawaiV::model()->findByAttributes(array('pegawai_id'=>$model->realisasimenyetujui_id))->nama_pegawai : "";
		}
		
		if (isset($_POST['AGTandabuktikeluarT'])){
			$transaction = Yii::app()->db->beginTransaction();
            try{
				//var_dump($_POST); 
				$modTandaBuktiKeluar->attributes = $_POST['AGTandabuktikeluarT'];
				$modTandaBuktiKeluar->shift_id = 1;		
				$modTandaBuktiKeluar->ruangan_id = Yii::app()->user->ruangan_id;
				$modTandaBuktiKeluar->tahun = date("Y",strtotime($_POST['AGRealisasianggpengT']['bulanDb']));
				$modTandaBuktiKeluar->tglkaskeluar = $format->formatDateTimeForDb($modTandaBuktiKeluar->tglkaskeluar);
				$modTandaBuktiKeluar->nokaskeluar = MyGenerator::noBuktiKeluarAnggaran($modTandaBuktiKeluar->tglkaskeluar);
				$modTandaBuktiKeluar->jmlkaskeluar = $_POST['AGRealisasianggpengT']['nilaialokasi_pengeluaran'];
				$modTandaBuktiKeluar->biayaadministrasi = 0;
				$modTandaBuktiKeluar->namapenerima = $modTandaBuktiKeluar->namapenerima;
				$modTandaBuktiKeluar->create_time = date("Y-m-d H:i:s");
				$modTandaBuktiKeluar->create_loginpemakai_id = Yii::app()->user->id;
				$modTandaBuktiKeluar->create_ruangan = Yii::app()->user->ruangan_id;
				if ($modTandaBuktiKeluar->save()){
					$this->tandaBuktiKeluar = true;
						$model->attributes = $_POST['AGRealisasianggpengT'];
						$model->tandabuktikeluar_id = $modTandaBuktiKeluar->tandabuktikeluar_id;
						$model->tglrealisasianggaran = $format->formatDateTimeForDb($model->tglrealisasianggaran);
						$model->create_time = date("Y-m-d H:i:s");
						$model->create_loginpemakai_id = Yii::app()->user->id;
						$model->create_ruangan = Yii::app()->user->ruangan_id;
						$model->persentase_realisasi = str_replace(",", ".", $model->persentase_realisasi);
						//var_dump($model->attributes); die;
						if ($model->save()){
							$this->realisasiPengeluaran = true;
						}
				}
				
					if($this->tandaBuktiKeluar && $this->realisasiPengeluaran){
						$transaction->commit();
							$this->redirect(array('index','realisasianggpeng_id'=>$model->realisasianggpeng_id,'frame'=>1,'sukses'=>1));
					}else{
						$transaction->rollback();
						Yii::app()->user->setFlash('error',"Data Realisasi Anggaran Pengeluaran gagal disimpan !");
					}
			} catch (Exception $ex) {
				$transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Realisasi Anggaran Pengeluaran gagal disimpan ! ".MyExceptionMessage::getMessage($ex,true));
			}
		}
		
		$this->render('index',array('format'=>$format,'model'=>$model,'modTandaBuktiKeluar'=>$modTandaBuktiKeluar));
	}
	
    public function actionPrintRealisasi($realisasianggpeng_id)
    {
		$format = new MyFormatter();
		$model = AGRealisasianggpengT::model()->findByPk($realisasianggpeng_id); 
//		$model->nilaipenerimaan = $format->formatNumberForUser($model->nilaipenerimaan);
//		$model->realisasipenerimaan = $format->formatNumberForUser($model->realisasipenerimaan);
//		$modPenerimaan = AGRenanggpenerimaanT::model()->findByAttributes(array('renanggpenerimaan_id'=>$model->renanggpenerimaan_id));
		$modTandaBukti = AGTandabuktikeluarT::model()->findByAttributes(array('tandabuktikeluar_id'=>$model->tandabuktikeluar_id));
		$modKonfig = AGKonfiganggaranK::model()->findByPk($model->konfiganggaran_id);
		$deskripsi = $model->konfiganggaran->deskripsiperiode;
        $jenisPrint = (isset($_REQUEST['jenisPrint']) ? $_REQUEST['jenisPrint'] : null);
		if($jenisPrint=='REALISASI') {
			$judulLaporan = 'Realisasi Anggaran Pengeluaran';
			$this->layout='//layouts/printWindows';
			$this->render('printRealisasi',array('format'=>$format,'model'=>$model,'modTandaBukti'=>$modTandaBukti,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'jenisPrint'=>$jenisPrint));
		}
		else if($jenisPrint=='TANDABUKTIKELUAR') {
			$judulLaporan = 'KUITANSI';
			$this->layout='//layouts/printWindows';
			$this->render('printTandaBuktiKeluar',array('format'=>$format,'model'=>$model,'modKonfig'=>$modKonfig,'modTandaBukti'=>$modTandaBukti,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'jenisPrint'=>$jenisPrint));
		}
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
		
    public function actionAutocompleteNamaPenerima()
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
	
    public function actionAutocompleteProgramKerja()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(subkegiatanprogram_nama)', strtolower($_GET['term']), true);
            $criteria->order = 'subkegiatanprogram_nama';
            $criteria->limit = 5;
            $models = AGInformasialokasianggaranV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->subkegiatanprogram_nama;
                $returnVal[$i]['value'] = $model->subkegiatanprogram_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
	
	public function actionFormatBulan()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$bulanDb=$_POST['bulanDb'];
			$data['bulanUser'] = MyFormatter::formatMonthForUser($bulanDb);
			echo json_encode($data);
			Yii::app()->end();
		}
	}
}