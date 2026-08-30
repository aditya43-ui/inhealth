
<?php

class InvperalatanTController extends MyAuthController {

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
	public $defaultAction = 'admin';
	public $penjurnalan = false;
	public $penjurnalanDetail = true;
	public $simpanAset = true;

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model = new MAInvperalatanT;
		$modelDetail = new InvperalatanT;
		$model->invperalatan_tglguna = date('d M Y');
		$modBarang = new MABarangM;

		// Uncomment the following line if AJAX validation is needed


		if (isset($_POST['MAInvperalatanT'])) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model = new MAInvperalatanT();
				$modelDetail = new InvperalatanT;

				$model->attributes = $_POST['MAInvperalatanT'];                                                                                                
				$model->invperalatan_noregister=MyGenerator::Kodenoregister($_POST['MAInvperalatanT']['barang_id']);
				$model->create_time = date('Y-m-d H:i:s');
				$model->update_time = null;
				$model->create_loginpemakai_id = Yii::app()->user->id;
				$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
				$model->invperalatan_tglguna = !empty($_POST['MAInvperalatanT']['invperalatan_tglguna']) ? $_POST['MAInvperalatanT']['invperalatan_tglguna'] : null;
				$model->tglpenghapusan = !empty($_POST['MAInvperalatanT']['tglpenghapusan']) ? MyFormatter::formatDateTimeForDb($_POST['MAInvperalatanT']['tglpenghapusan']) : null;
				$model->invperalatan_tglguna = !empty($_POST['MAInvperalatanT']['invperalatan_tglguna']) ? MyFormatter::formatDateTimeForDb($_POST['MAInvperalatanT']['invperalatan_tglguna']) : null;
                                $model->peralatan_garansihabis = !empty($_POST['MAInvperalatanT']['peralatan_garansihabis']) ? MyFormatter::formatDateTimeForDb($_POST['MAInvperalatanT']['peralatan_garansihabis']) : null;

                                foreach ($_POST['InvperalatanT'] as $key => $value) {
                                    $modelDetail = new InvperalatanT;
                                    $modelDetail->attributes = $model->attributes;
                                    $modelDetail->attributes = $value;
                                    $modelDetail->umurekonomis = $value['invperalatan_umurekonomis'];                                    
                                    $modelDetail->invperalatan_kode=MyGenerator::kodePeralatanMesin($modelDetail->barang_id);                                    
                                    $terimadet = TerimapersdetailT::model()->findByPk($modelDetail->terimapersdetail_id);
                                    $terima = TerimapersediaanT::model()->findByPk($terimadet->terimapersediaan_id);
                                    
                                    $modelDetail->ruangan_id = $terima->ruanganpenerima_id;
                                    $modelDetail->nomor_kontrak = $terima->no_dokumen;
                                    $modelDetail->tanggal_perolehan = $terima->tglterima;
                                    $modelDetail->cara_perolehan = $terima->cara_perolehan;
                                    $modelDetail->sumberdana = !empty($terima->sumberdana->sumberdana_nama)?$terima->sumberdana->sumberdana_nama:null;
                                    $modelDetail->ruangan_id = !empty($model->lokasi->ruangan_id)?$model->lokasi->ruangan_id:null;                                                                        

                                    
                                    if($modelDetail->validate()){
                                        $modelDetail->save();
                                        BarangM::model()->updateByPk($modelDetail->barang_id, array('barang_statusregister' => true));
                                        $this->simpanAset &= true;
                                    }else{
                                        $this->simpanAset &= false;
                                    }
                                }
                                
                                if ($this->simpanAset) {
                                    $transaction->commit();
                                    $this->redirect(array('create','sukses'=>1));
                                } else {
                                    $transaction->rollback();
                                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                                }
                    
			} catch (Exception $exc) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
			}
		}

		$this->render('create', array(
                    'model' => $model, 
                    'modelDetail' => $modelDetail, 
                    'modBarang' => $modBarang
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model = $this->loadModel($id);
                $modelDetail = InvperalatanT::model()->findByPk($id);
                if(!empty($modelDetail->terimapersdetail_id)){
                    $terimapersediaan_id = TerimapersdetailT::model()->findByPk($modelDetail->terimapersdetail_id)->terimapersediaan_id;
                    $modelDetail->nopenerimaan = TerimapersediaanT::model()->findByPk($terimapersediaan_id)->nopenerimaan;
                }
		$modBarang = $this->loadModelBarang($model->barang_id);
		$data['pemilikbarang_nama'] = !empty($model->pemilikbarang_id) ? $model->pemilik->pemilikbarang_nama : '';
		$dataAsalAset['asalaset_nama'] = !empty($model->asalaset_id) ? $model->asal->asalaset_nama : '';
		$dataLokasi['lokasiaset_namalokasi'] = !empty($model->lokasi_id) ? $model->lokasi->lokasiaset_namalokasi : '';

		// Uncomment the following line if AJAX validation is needed


		if (isset($_POST['MAInvperalatanT'])) {
			$model->attributes = $_POST['MAInvperalatanT'];
			if ($model->save()) {
				BarangM::model()->updateByPk($model->barang_id, array('barang_statusregister' => true));
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				//$this->redirect(array('admin','id'=>$model->invperalatan_id));
                                $this->redirect(array('update','id'=>$id,'sukses'=>1));
			}
		}

		$this->render('update', array(
			'model' => $model, 'modBarang' => $modBarang, 'data' => $data, 'dataAsalAset' => $dataAsalAset, 'dataLokasi' => $dataLokasi, 'modelDetail' => $modelDetail, 
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) {
		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			//if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
			$model = $this->loadModel($id);
			BarangM::model()->updateByPk($model->barang_id, array('barang_statusregister' => false));
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('MAInvperalatanT');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin() {

		$model = new MAInvperalatanT('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['MAInvperalatanT']))
			$model->attributes = $_GET['MAInvperalatanT'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) {
		$model = MAInvperalatanT::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	public function loadModelBarang($id) {
		$model = BarangM::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'guinvperalatan-t-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Mengubah status aktif
	 * @param type $id 
	 */
	public function actionRemoveTemporary($id) {
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		//$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionPrint() {
		$model = new InvperalatanT;
		$model->attributes = $_REQUEST['InvperalatanT'];
		$judulLaporan = 'Data InvperalatanT';
		$caraPrint = $_REQUEST['caraPrint'];
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');	  //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');		 //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('', $ukuranKertasPDF);
			$mpdf->mirrorMargins = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output();
		}
	}
	
	/* Digunakan di Modul Akuntansi
	 * 
	 */

	public function actionRekeningAkuntansi() {
		if (Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
//                $criteria->compare('LOWER(nmrincianobyek)', strtolower($_GET['term']), true);
			$term = strtolower(trim($_GET['term']));

			$condition = "LOWER(nmrekening5) LIKE '%" . $term . "%' OR LOWER(nmrekening4) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%'";
			if (isset($_GET['id_jenis_rek'])) {
				$condition = "(LOWER(nmrekening5) LIKE '%" . $term . "%' OR LOWER(nmrekening4) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%') AND (rekening5_nb = 'D' OR rekening4_nb = 'D' OR rekening3_nb = 'D')";
				if ($_GET['id_jenis_rek'] == 'Kredit') {
					$condition = "(LOWER(nmrekening5) LIKE '%" . $term . "%' OR LOWER(nmrekening4) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%') AND (rekening5_nb = 'K' OR rekening4_nb = 'K' OR rekening3_nb = 'K')";
				}
			}

			$criteria->addCondition($condition);
			$criteria->order = 'nmrekening5';
			$models = RekeningakuntansiV::model()->findAll($criteria);
			$returnVal = array();
			foreach ($models as $i => $model) {
				$attributes = $model->attributeNames();
				foreach ($attributes as $j => $attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				if (isset($model->rincianobyek_id)) {
					$kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3 . "-" . $model->kdrekening4 . "-" . $model->kdrekening5;
					$nama_rekening = $model->nmrekening5;
				} else {
					if (isset($model->obyek_id)) {
						$kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3 . "-" . $model->kdrekening4;
						$nama_rekening = $model->nmrekening4;
					} else {
						$kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3;
						$nama_rekening = $model->nmrekening3;
					}
				}
				$returnVal[$i]['label'] = $kode_rekening . '-' . $nama_rekening;
				$returnVal[$i]['value'] = $nama_rekening;
			}
			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}

	// fungsi untuk penjurnalan di transaksi penyusutan aset
	public function actionAmbilDataRekening() {
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			$rekening1_id = isset($_POST['rekening1_id']) ? $_POST['rekening1_id'] : null;
			$rekening2_id = isset($_POST['rekening2_id']) ? $_POST['rekening2_id'] : null;
			$rekening3_id = isset($_POST['rekening3_id']) ? $_POST['rekening3_id'] : null;
			$rekening4_id = isset($_POST['rekening4_id']) ? $_POST['rekening4_id'] : null;
			$rekening5_id = isset($_POST['rekening5_id']) ? $_POST['rekening5_id'] : null;
			$status = isset($_POST['status']) ? $_POST['status'] : null;

			$criteria = new CDbCriteria;
			if (!empty($rekening5_id)) {
				$criteria->addCondition("rekening5_id = " . $rekening5_id);
			}
			if (!empty($rekening4_id)) {
				$criteria->addCondition("rekening4_id = " . $rekening4_id);
			}
			if (!empty($rekening3_id)) {
				$criteria->addCondition("rekening3_id = " . $rekening3_id);
			}
			if (!empty($rekening2_id)) {
				$criteria->addCondition("rekening2_id = " . $rekening2_id);
			}
			if (!empty($rekening1_id)) {
				$criteria->addCondition("rekening1_id = " . $rekening1_id);
			}

			$model = MARekeningakuntansiV::model()->findAll($criteria);
			if ($model) {
				echo CJSON::encode(
						$this->renderPartial('__formKodeRekening', array('model' => $model, 'status' => $status), true)
				);
			}
			Yii::app()->end();
		}
	}
	
	public function actionGetkodeRegister(){
            if(Yii::app()->request->isAjaxRequest) {
                $barang_id = isset($_POST['barang_id']) ? $_POST['barang_id'] : null;

                $returnVal = array();
                $kode_register = MyGenerator::Kodenoregister($barang_id);
                $returnVal['value'] = isset($kode_register) ? $kode_register : "";

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
                
        /**
         * @author Tantowy <tantowijaya@.com>
         * 
         * Proses untuk load data barang berdasarkan jumlah penerimaan
         */
        public function actionLoadDetailInvAlat() {
            if (Yii::app()->request->isAjaxRequest) {
                
                $modelDetail = new InvperalatanT;
                $jumlah = $_GET['jumlah'];
                $barang_id = $_GET['barang_id'];
                $terimapersdetail_id = $_GET['terimapersdetail_id'];
                
                $barangM = BarangM::model()->findByPk($barang_id);
                $persediaanDet = TerimapersdetailT::model()->findByPk($terimapersdetail_id);
                
                $modelDetail->invperalatan_namabrg = $barangM->barang_nama;
                $modelDetail->invperalatan_keadaan = $persediaanDet->kondisibarang;
                $modelDetail->invperalatan_kode = $barangM->subsubkelompok->subsubkelompok_kode;
                
                $default = "00001";
                $prefix = $barangM->subsubkelompok->subsubkelompok_kode;
                $sql = "SELECT CAST(MAX(SUBSTR(invperalatan_kode,".(strlen($prefix)+2).",".(strlen($default)).")) AS integer) nomaksimal
                        FROM invperalatan_t 
                        WHERE invperalatan_kode LIKE ('".$prefix."%')";
		$nourut = Yii::app()->db->createCommand($sql)->queryRow();
                $nourutBaru = (isset($nourut['nomaksimal']) ? $nourut['nomaksimal']+1 : 1);
                
                $rows = "";
                for($i=0;$i<$jumlah;$i++){
                    $kode = (str_pad($nourutBaru, strlen($default), 0,STR_PAD_LEFT));
                    $modelDetail->invperalatan_kode = $barangM->subsubkelompok->subsubkelompok_kode.'.'.$kode;
                    $rows .= $this->renderPartial('_invDetailAset', array('form'=>'','modelDetail' => $modelDetail,'i'=>$i), true);
                    $nourutBaru++;
                }
                
                echo CJSON::encode(array('rows' => $rows));
            }
            Yii::app()->end();
	}
        
        /**
         * @author Tantowy <tantowijaya@.com>
         * 
         * Proses untuk cek duplikasi kode aset
         */
        public function actionCekKodeAset() {
            if (Yii::app()->request->isAjaxRequest) {
                
                $barang_id = $_GET['barang_id'];
                $noregister = $_GET['noregister'];
                $kode = $_GET['kode'];
                
                $modelDetail = InvperalatanT::model()->findByAttributes(array('barang_id'=>$barang_id,'invperalatan_noregister'=>$noregister,'invperalatan_kode'=>$kode));
                if(!empty($modelDetail->invperalatan_id)){
                    $status = 'GAGAL';
                }else{
                    $status = 'OK';
                }
                
                echo CJSON::encode(array('status' => $status));
            }
            Yii::app()->end();
	}
        
        /**
         * @author Tantowy <tantowijaya@.com>
         * 
         * Proses untuk cek banyak jumlah inv peerimaan agar mendapatkan selihsih banyaknya yg belum inventarisasi
         */
        public function actionCekSelisihInv() {
            if (Yii::app()->request->isAjaxRequest) {
                
                $terimapersdetail_id = $_GET['terimapersdetail_id'];
                $barang_id = $_GET['barang_id'];
                $jml = $_GET['jml'];
                $modBarang = BarangM::model()->findByPk($_GET['barang_id']);
                $subsubkelompok = SubsubkelompokM::model()->findByPk($modBarang->subsubkelompok_id);
                
                $criteria=new CDbCriteria;
                $criteria->select = "count (*) AS jmlterima";
                $criteria->addCondition("terimapersdetail_id = ".$terimapersdetail_id);
                $criteria->addCondition("barang_id = ".$barang_id);
                $modelDetail = InvperalatanT::model()->find($criteria);
                
                /* kondisi select count invperalatan_kode, karena di pake untuk no.urut berdasarkan subsubkelompok_kode*/
                $default = '00001';
                $prefix = $subsubkelompok->subsubkelompok_kode;
                $criteriaNoUrut=new CDbCriteria;
                $criteriaNoUrut->select = "CAST(MAX(SUBSTR(invperalatan_kode,".(strlen($prefix)+2).",".(strlen($default)).")) AS integer) kode_urut";
                $criteriaNoUrut->addCondition("invperalatan_kode ILIKE ('".$subsubkelompok->subsubkelompok_kode."%')");
                $modelNoUrut = InvperalatanT::model()->find($criteriaNoUrut);
                /* end */
                if($modelDetail->jmlterima==0){
                    $jumlah_noUrut = ($modelNoUrut->kode_urut != 0) ? $modelNoUrut->kode_urut+1 : 1;
                    $awal = (str_pad($jumlah_noUrut, strlen($default), 0,STR_PAD_LEFT));
                    $jumlah = $jml;
                    $akhir = ($jumlah_noUrut == 1) ? (str_pad($jumlah, strlen($default), 0,STR_PAD_LEFT)) : (str_pad($modelNoUrut->kode_urut + $jml, strlen($default), 0,STR_PAD_LEFT));
                }else{
                    $jumlah = ($jml-$modelDetail->jmlterima);
                    $jumlah_noUrut = ($modelNoUrut->kode_urut != 0) ? $modelNoUrut->kode_urut+1 : 1;
                    $awal = (str_pad($jumlah_noUrut, strlen($default), 0,STR_PAD_LEFT));
                    $akhir = ($jumlah_noUrut==1)? (str_pad($jml, strlen($default), 0,STR_PAD_LEFT)) : (str_pad(($modelNoUrut->kode_urut + $jml), strlen($default), 0,STR_PAD_LEFT));
                }
                
                echo CJSON::encode(
                    array(
                        'jumlah' => $jumlah,
                        'awal' => $awal,
                        'akhir' => $akhir,
                    )
                );
            }
            Yii::app()->end();
	}
        
        /**
         * @author tantowy <tantowijaya@.com>
         * Autocomplete barang aset sesuai dengan golongan aset dan penerimaan aset/barang
         */
        public function actionGetBarangAset()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $golongan_kode = isset($_GET['golongan_kode'])? $_GET['golongan_kode'] : null;
                $nopenerimaan = isset($_GET['nopenerimaan'])? $_GET['nopenerimaan'] : null;
                $term = isset($_GET['term'])? $_GET['term'] : null;
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(barang_nama)', strtolower($term), true);
                $criteria->compare('LOWER(nopenerimaan)', strtolower($nopenerimaan), true);
                $criteria->compare('LOWER(golongan.golongan_kode)',strtolower($golongan_kode),true);
                $criteria->addCondition("terimapersdetail_id NOT IN (SELECT terimapersdetail_id FROM invperalatan_t WHERE terimapersdetail_id IS NOT NULL)"); //agar detail tidak muncul yg sudah di inventarisasi
                $criteria->addCondition("t.barang_type = '".Params::TYPE_BARANG_ASET."'");
                $criteria->order = 'barang_nama';
                $criteria->select = 't.*, bidang.bidang_nama as bidang_nama, subkelompok.subkelompok_nama as subkelompok_nama, kelompok.kelompok_nama as kelompok_nama, golongan_kode, golongan.golongan_nama as golongan_nama
                            ,subsubkelompok.subsubkelompok_nama,subsubkelompok.subsubkelompok_kode,terimaDet.terimapersdetail_id,terima.terimapersediaan_id,terima.nopenerimaan,terimaDet.jmlterima';
                $criteria->join = 'LEFT JOIN subsubkelompok_m As subsubkelompok ON subsubkelompok.subsubkelompok_id = t.subsubkelompok_id'
                        . ' LEFT JOIN subkelompok_m As subkelompok ON subkelompok.subkelompok_id = subsubkelompok.subkelompok_id'
                        . ' LEFT JOIN kelompok_m As kelompok ON kelompok.kelompok_id = subkelompok.kelompok_id'
                        . ' LEFT JOIN bidang_m As bidang ON bidang.bidang_id = kelompok.bidang_id'
                        . ' LEFT JOIN golongan_m As golongan ON golongan.golongan_id = bidang.golongan_id'
                        . ' JOIN terimapersdetail_t As terimaDet ON terimaDet.barang_id = t.barang_id'
                        . ' JOIN $terima As terima ON terima.terimapersediaan_id = terimaDet.terimapersediaan_id';
                $models = BarangM::model()->findAll($criteria);
                $returnVal = array();
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->nopenerimaan.' - '.$model->barang_nama;
                    $returnVal[$i]['nopenerimaan'] = $model->nopenerimaan;
                    $returnVal[$i]['barang_nama'] = $model->barang_nama;
                    $returnVal[$i]['subsubkelompok_nama'] = $model->subsubkelompok_nama;
                    $returnVal[$i]['subsubkelompok_kode'] = $model->subsubkelompok_kode;
                    $returnVal[$i]['jmlterima'] = $model->jmlterima;
                    $returnVal[$i]['value'] = $model->barang_id;
                    $returnVal[$i]['terimapersdetail_id'] = $model->terimapersdetail_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}

}
