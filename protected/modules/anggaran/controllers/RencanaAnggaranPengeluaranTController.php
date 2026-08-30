<?php

class RencanaAnggaranPengeluaranTController extends MyAuthController{
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $rencanaAnggPeng = false;
	public $rencanaAnggPengDet = true;
	
	public function actionIndex(){
		$format = new MyFormatter;
		$modDetails = array();
		$model = new AGRencanggaranpengT;
		$model->rencanggaranpeng_tgl = $format->formatDateTimeForUser(date("Y-m-d"));
		$model->rencanggaranpeng_no = MyGenerator::noRencAnggPeng();
		$model->tglrencana = date("Y-m-d");
//		load untuk Unit kerja otomatis keluar berdasarkan login
			$ruangan_id = (isset(Yii::app()->user->ruangan_id)? Yii::app()->user->ruangan_id : null);
			$ruangan_nama = AGUnitkerjaruanganM::model()->findByAttributes(array('ruangan_id'=>$ruangan_id));
			if(!empty($ruangan_nama)){	
				$unitkerja_nama = AGUnitkerjaM::model()->findByPk($ruangan_nama->unitkerja_id);
				$model->namaunitkerja = $unitkerja_nama->namaunitkerja;
				$model->unitkerja_id = $unitkerja_nama->unitkerja_id;
			}else{
				$model->namaunitkerja = "";
				$model->unitkerja_id = "";
			}
		$modDetail = new AGRencanggaranpengdetailT;
		
		if(isset($_POST['AGRencanggaranpengT'])){
            $transaction = Yii::app()->db->beginTransaction();
            try {
				$model->attributes = $_POST['AGRencanggaranpengT'];
				$model->konfiganggaran_id = $_POST['konfiganggaran_id'];
				$model->rencanggaranpeng_tgl = $format->formatDateTimeForDb($_POST['AGRencanggaranpengT']['rencanggaranpeng_tgl']);
				$model->create_time = date("Y-m-d H:i:s");
				$model->create_loginpemakai_id = Yii::app()->user->id;
				$model->create_ruangan = Yii::app()->user->ruangan_id;
				// menambahkan digitnilaianggaran dari tabel konfiganggaran_k
				$modKonfig = AGKonfiganggaranK::model()->findByPk($model->konfiganggaran_id);
				$digitNilai = isset($modKonfig->digitnilaianggaran) ? $modKonfig->digitnilaianggaran : null;
				$model->total_nilairencpeng = $model->total_nilairencpeng.$digitNilai;
						if($model->save()){
							$this->rencanaAnggPeng = true;
								if(count((array)$_POST['AGRencanggaranpengdetailT']) > 0){
								   foreach($_POST['AGRencanggaranpengdetailT'] AS $i => $postRencanaDet){
									   $modDetails[$i] = $this->simpanRencanaAnggaranPengDet($model,$postRencanaDet);
								   }
								}
						}
					if($this->rencanaAnggPeng && $this->rencanaAnggPengDet){
						$transaction->commit();
						$this->redirect(array('index','rencanggaranpeng_id'=>$model->rencanggaranpeng_id,'sukses'=>1));
					}else{
						$transaction->rollback();
						Yii::app()->user->setFlash('error',"Data Rencana Anggaran Pengeluaran gagal disimpan !");
					}
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Rencana Anggaran Pengeluaran gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
		}	
		
		$this->render('index',array(
			'format'=>$format,
			'model'=>$model,
			'modDetail'=>$modDetail,
            ));
	}
	
     /**
     * simpan AGRencanggaranpengdetailT
     * @param type $model
     * @param type $post
     * @return AGRencanggaranpengdetailT
     */
    public function simpanRencanaAnggaranPengDet($model ,$post){
        $format = new MyFormatter();
		$modKonfig = AGKonfiganggaranK::model()->findByPk($model->konfiganggaran_id);
		if ($modKonfig->digitnilaianggaran === "0"){
			$digitNilai = null;
		}else {
			$digitNilai = isset($modKonfig->digitnilaianggaran) ? $modKonfig->digitnilaianggaran : null;
		}
        $modDetail = new AGRencanggaranpengdetailT;
        $modDetail->attributes = $post;
		$modDetail->rencanggaranpeng_id = $model->rencanggaranpeng_id;
		$modDetail->nilairencpengeluaran = $modDetail->nilairencpengeluaran.$digitNilai;
		
        if($modDetail->save()) {
			$this->rencanaAnggPengDet &= true;
        } else {
            $this->rencanaAnggPengDet &= false;
        }
        return $modDetail;
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
	
    public function actionAutocompleteProgramKerja()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(subkegiatanprogram_nama)', strtolower($_GET['term']), true);
            $criteria->order = 'subkegiatanprogram_nama';
            $criteria->limit = 5;
            $models = AGRekeninganggaranV::model()->findAll($criteria);
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
    * menampilkan rencana anggaran pengeluaran detail
    * @return row table 
    */
    public function actionLoadFormTambahRencana()
    {
        if(Yii::app()->request->isAjaxRequest) { 
			$date = date("d");
            $subkegiatanprogram_id = $_POST['subkegiatanprogram_id'];
            $nilairencpengeluaran = $_POST['nilairencpengeluaran'];
            $tglrencana = $_POST['tglrencana'];
			
            $format = new MyFormatter();
            $modRencanaDetail = new AGRencanggaranpengdetailT;
            $modProgramKerja = AGRekeninganggaranV::model()->findByAttributes(array('subkegiatanprogram_id'=>$subkegiatanprogram_id));
            $modRencanaDetail->nilairencpengeluaran = $nilairencpengeluaran;
			$modRencanaDetail->subkegiatanprogram_id = $modProgramKerja->subkegiatanprogram_id;
            $modRencanaDetail->tglrencanapengdet = $format->formatMonthForDb($tglrencana);
            $modRencanaDetail->tglrencanapengdet = $modRencanaDetail->tglrencanapengdet."-".$date;
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'form'=>$this->renderPartial('_rowRencanaAnggaranPengeluaran', array(
                        'format'=>$format,
                        'modRencanaDetail'=>$modRencanaDetail,
                        'modProgramKerja'=>$modProgramKerja,
                    ), 
                true))
            );
            exit;  
        }
    }
}

