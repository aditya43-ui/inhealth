<?php

class RencanaAnggaranPenerimaanTController extends MyAuthController{
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $rencanaAnggPen = false;
	public $rencanaAnggPenDet = true;
	
	public function actionIndex(){
		$format = new MyFormatter;
		$model = new AGRenanggpenerimaanT;
		$model->tglrenanggaranpen =  $format->formatDateTimeForUser(date("Y-m-d"));
		$model->noren_penerimaan = MyGenerator::noRencAnggPen();
		$modDetail = new AGRenanggaranpenerimaandetT;
		$modDetails = array();
		
		if(isset($_POST['AGRenanggpenerimaanT'])){
            $transaction = Yii::app()->db->beginTransaction();
            try {
				$model->attributes = $_POST['AGRenanggpenerimaanT'];
				$model->tglrenanggaranpen = $format->formatDateTimeForDb($_POST['AGRenanggpenerimaanT']['tglrenanggaranpen']);
				$model->ruangan_id = Yii::app()->user->ruangan_id;
				$model->create_time = date("Y-m-d H:i:s");
				$model->create_loginpemakai_id = Yii::app()->user->id;
				$model->create_ruangan = Yii::app()->user->ruangan_id;
				// menambahkan digitnilaianggaran dari tabel konfiganggaran_k
				$modKonfig = AGKonfiganggaranK::model()->findByPk($model->konfiganggaran_id);
				$digitNilai = null; isset($modKonfig->digitnilaianggaran) ? $modKonfig->digitnilaianggaran : null;
				$model->nilaipenerimaananggaran = $model->nilaipenerimaananggaran.$digitNilai;
				$model->total_renanggaranpen = $model->nilaipenerimaananggaran;  
						if($model->save()){
							$this->rencanaAnggPen = true;
								if(count((array)$_POST['AGRenanggaranpenerimaandetT']) > 0){
								   foreach($_POST['AGRenanggaranpenerimaandetT'] AS $i => $postRencanaDet){
									   $modDetails[$i] = $this->simpanRencanaAnggaranPenDet($model,$postRencanaDet);
								   }
								}
						}
					if($this->rencanaAnggPen && $this->rencanaAnggPenDet){
						$transaction->commit();
						$this->redirect(array('index','renanggpenerimaan_id'=>$model->renanggpenerimaan_id,'sukses'=>1));
					}else{
						$transaction->rollback();
						Yii::app()->user->setFlash('error',"Data Rencana Anggaran Penerimaan gagal disimpan !");
					}
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Rencana Anggaran Penerimaan gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
		}
		
		$this->render('index',array(
			'format'=>$format,
			'model'=>$model,
			'modDetail'=>$modDetail,
		));
	}
	
     /**
     * simpan AGRenanggaranpenerimaandetT
     * @param type $model
     * @param type $post
     * @return AGRenanggaranpenerimaandetT
     */
    public function simpanRencanaAnggaranPenDet($model ,$post){
        $format = new MyFormatter();
		$modKonfig = AGKonfiganggaranK::model()->findByPk($model->konfiganggaran_id);
		if ($modKonfig->digitnilaianggaran === "0"){
			$digitNilai = null;
		}else {
			$digitNilai = isset($modKonfig->digitnilaianggaran) ? $modKonfig->digitnilaianggaran : null;
		}
        $modDetail = new AGRenanggaranpenerimaandetT;
        $modDetail->attributes = $post;
		$modDetail->renanggpenerimaan_id = $model->renanggpenerimaan_id;
		$modDetail->renanggaran_ke = $post['termin'];
		$modDetail->nilaipenerimaan = $post['hasil'].$digitNilai;
		$modDetail->tglrenanggaranpen = $format->formatDateTimeForDb($post['tglrenanggaranpen']);
        if($modDetail->save()) {
			$this->rencanaAnggPenDet &= true;
        } else {
            $this->rencanaAnggPenDet &= false;
        }
        return $modDetail;
    }
    
	public function actionCekDigit() {
		if(Yii::app()->request->isAjaxRequest) {
				$konfiganggaran_id=$_POST['konfig_id'];
				//$modKonfig=AGKonfiganggaranK::model()->findByPk($konfiganggaran_id);
				//if ($modKonfig->digitnilaianggaran === "0"){
					 $data['digit'] = null;
				//}else {
				//	$data['digit'] = (isset($modKonfig->digitnilaianggaran) ? " / ".$modKonfig->digitnilaianggaran : null);
				//}
                echo json_encode($data);
                Yii::app()->end();
            }
	}    
	
    /**
    * menampilkan rencana anggaran penerimaan detail
    * @return row table 
    */
    public function actionLoadFormTambahRencana()
    {
        if(Yii::app()->request->isAjaxRequest) { 
			$format = new MyFormatter;
			$modDetail = new AGRenanggaranpenerimaandetT;
			$hasil = 0;
            $nilaipenerimaananggaran = $_POST['nilaipenerimaananggaran'];
            $berapaxpenerimaan = $_POST['berapaxpenerimaan'];
			$termin = $berapaxpenerimaan;
			$hasil = $nilaipenerimaananggaran / $berapaxpenerimaan;
			$modDetail->hasil = $format->formatNumberForPrint($hasil);
			echo CJSON::encode(array(
                'form'=>$this->renderPartial('_rowTermin', array(
                        'format'=>$format,
                        'termin'=>$termin,
                        'hasil'=>$hasil,
                        'modDetail'=>$modDetail
                    ), 
                true))
            );
            exit;  
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
	
}

