
<?php

class InvgedungTController extends MyAuthController {

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
	public $defaultAction = 'admin';
	public $penjurnalan = false;
	public $penjurnalanDetail = true;

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
		$model = new MAInvgedungT;
                $model->invgedung_tglguna = date('d M Y');
                $model->dalam_kontruksi = false;
		$modBarang = new MABarangM;

		// Uncomment the following line if AJAX validation is needed

                if(isset($_GET['id'])){
                    $model = MAInvgedungT::model()->findByPk($_GET['id']);
                }
                
		if (isset($_POST['MAInvgedungT'])) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model->attributes = $_POST['MAInvgedungT'];
				$model->invgedung_noregister=MyGenerator::Kodenoregister($_POST['MAInvgedungT']['barang_id']);
                                $model->invgedung_kode=MyGenerator::kodeGedung($_POST['MAInvgedungT']['barang_id']);
				$model->create_time = date('Y-m-d H:i:s');
				$model->update_time = null;
				$model->create_loginpemakai_id = Yii::app()->user->id;
				$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
				$model->invgedung_tgldokumen = !empty($_POST['MAInvgedungT']['invgedung_tgldokumen']) ? $_POST['MAInvgedungT']['invgedung_tgldokumen'] : null;
				$model->invgedung_tglguna = !empty($_POST['MAInvgedungT']['invgedung_tglguna']) ? $_POST['MAInvgedungT']['invgedung_tglguna'] : null;
				$model->invgedung_tglguna = !empty($_POST['MAInvgedungT']['invgedung_tglguna']) ? $_POST['MAInvgedungT']['invgedung_tglguna'] : null;

				if ($model->validate()) {
					if ($model->save()) {
						/*$modJurnalRekening = new MAJurnalrekeningT;
						$modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_INVENTARISASI_ASET;
						$modJurnalRekening->rekperiod_id = Yii::app()->user->getState('periode_ids');
						$modJurnalRekening->tglbuktijurnal = date('Y-m-d H:i:s');
						$modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek();
						$modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
						$modJurnalRekening->noreferensi = 0;
						$modJurnalRekening->tglreferensi = date('Y-m-d H:i:s');
						$modJurnalRekening->nobku = "";
						$modJurnalRekening->urianjurnal = "Inventarisasi Aset Jurnal";
						$modJurnalRekening->create_time = date('Y-m-d H:i:s');
						$modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
						$modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');

						if ($modJurnalRekening->save()) {
							$this->penjurnalan = true;
							if (isset($_POST['RekeningakuntansiV'])) {
								if (count($_POST['RekeningakuntansiV']) > 0) {
									foreach ($_POST['RekeningakuntansiV'] as $x => $jurnalDetail) {
										$modJurnalDet = new MAJurnaldetailT;
										$modJurnalDet->attributes = $jurnalDetail;
										$modJurnalDet->rekperiod_id = $modJurnalRekening->rekperiod_id;
										$modJurnalDet->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
										$modJurnalDet->uraiantransaksi = isset($jurnalDetail['nama_rekening']) ? $jurnalDetail['nama_rekening'] : "";
										$modJurnalDet->saldodebit = isset($jurnalDetail['saldodebit']) ? (int) $jurnalDetail['saldodebit'] : 0;
										$modJurnalDet->saldokredit = isset($jurnalDetail['saldokredit']) ? (int) $jurnalDetail['saldokredit'] : 0;
										$modJurnalDet->nourut = $x + 1;
										$modJurnalDet->rekening5_id = isset($jurnalDetail['rekening5_id']) ? $jurnalDetail['rekening5_id'] : null;
										$modJurnalDet->catatan = "";
									}
									if ($modJurnalDet->save()) {
										$this->penjurnalanDetail &= true;
									} else {
										$this->penjurnalanDetail &= false;
									}
								}
							}
						}*/
					}
					if ($this->penjurnalanDetail) {
						$transaction->commit();
						BarangM::model()->updateByPk($model->barang_id, array('barang_statusregister' => true));
						Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
						$modBarang=BarangM::model()->findByPk($model->barang_id);
                                                $this->redirect(array('create','id'=>$model->invgedung_id,'sukses'=>1));
					} else {
						$transaction->rollback();
						Yii::app()->user->setFlash('error', "Data gagal disimpan ");
					}
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
			}
		}

		$this->render('create', array(
			'model' => $model, 'modBarang' => $modBarang,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		$format = new MyFormatter();
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model = $this->loadModel($id);
		$modBarang = $this->loadModelBarang($model->barang_id);
		$data['pemilikbarang_nama'] = $model->pemilikbarang->pemilikbarang_nama;
		$dataAsalAset['asalaset_nama'] = (isset($model->asalaset->asalaset_nama) ? $model->asalaset->asalaset_nama : "");
		$dataLokasi['lokasiaset_namalokasi'] = (isset($model->lokasiaset_id) ? $model->lokasi->lokasiaset_namalokasi : "");

                if(!empty($model->terimapersdetail_id)){
                    $terimapersediaan_id = TerimapersdetailT::model()->findByPk($model->terimapersdetail_id)->terimapersediaan_id;
                    $model->nopenerimaan = TerimapersediaanT::model()->findByPk($terimapersediaan_id)->nopenerimaan;
                }
		// Uncomment the following line if AJAX validation is needed


		if (isset($_POST['MAInvgedungT'])) {
			$model->attributes = $_POST['MAInvgedungT'];
			$model->update_time = date('Y-m-d H:i:s');
			$model->update_loginpemakai_id = Yii::app()->user->id;
			$model->invgedung_tgldokumen = !empty($_POST['MAInvgedungT']['invgedung_tgldokumen']) ? $_POST['MAInvgedungT']['invgedung_tgldokumen'] : null;
			$model->invgedung_tglguna = !empty($_POST['MAInvgedungT']['invgedung_tglguna']) ? $_POST['MAInvgedungT']['invgedung_tglguna'] : null;
			$model->tglpenghapusan = !empty($_POST['MAInvgedungT']['tglpenghapusan']) ? $format->formatDateTimeForDb($_POST['MAInvgedungT']['tglpenghapusan']) : null;
			$model->tipepenghapusan = !empty($_POST['MAInvgedungT']['tipepenghapusan']) ? $_POST['MAInvgedungT']['tipepenghapusan'] : null;
			if ($model->save()) {
				BarangM::model()->updateByPk($model->barang_id, array('barang_statusregister' => true));
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				//$this->redirect(array('admin','id'=>$model->invgedung_id));
                                $this->redirect(array('update','id'=>$id,'sukses'=>1));
			}
		}

		$this->render('update', array(
			'model' => $model, 'modBarang' => $modBarang, 'data' => $data, 'dataAsalAset' => $dataAsalAset, 'dataLokasi' => $dataLokasi
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
		$dataProvider = new CActiveDataProvider('MAInvgedungT');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin() {

		$model = new MAInvgedungT('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['MAInvgedungT']))
			$model->attributes = $_GET['MAInvgedungT'];

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
		$model = MAInvgedungT::model()->findByPk($id);
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
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'guinvgedung-t-form') {
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
		$model = new MAInvgedungT;
		$model->attributes = $_REQUEST['MAInvgedungT'];
		$judulLaporan = 'Data Inventarisasi Gedung';
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
                                $modProfil = ProfilrumahsakitM::model()->findByPk(1);
                                $returnVal['kd_wilayah'] = $modProfil->kd_wilayah;
				
				echo CJSON::encode($returnVal);
			}
			Yii::app()->end();
		}
                
        /**
         * @author Tantowy <tantowijaya@.com>
         * 
         * Proses untuk cek banyak jumlah inv penerimaan agar mendapatkan selihsih banyaknya yg belum inventarisasi.
         * Load kode aset berdasarkan sub sub kelompok aset.
         */
        public function actionCekSelisihInv() {
            if (Yii::app()->request->isAjaxRequest) {
                
                $terimapersdetail_id = $_GET['terimapersdetail_id'];
                $barang_id = $_GET['barang_id'];
                $jml = $_GET['jml'];
                
                $barangM = BarangM::model()->findByPk($barang_id);
                $persediaanDet = TerimapersdetailT::model()->findByPk($terimapersdetail_id);
                $invgedung_kode = $barangM->subsubkelompok->subsubkelompok_kode;
                
                $criteria=new CDbCriteria;
                $criteria->select = "count (*) AS jmlterima";
                $criteria->addCondition("invgedung_kode ILIKE ('".$invgedung_kode.".%')");
                $modelDetail = InvgedungT::model()->find($criteria);
                if($modelDetail->jmlterima == 0){
                    $awal = (str_pad(1, strlen('001'), 0,STR_PAD_LEFT));
                    $jumlah = $jml;
                }else{
                    $jumlah = $jml; //($jml-$modelDetail->jmlterima);
                    $awal = (str_pad(($modelDetail->jmlterima+1), strlen('001'), 0,STR_PAD_LEFT));
                }
                
                $default = "00001";
                $prefix = $invgedung_kode.".";
                $sql = "SELECT CAST(MAX(SUBSTR(invgedung_kode,".(strlen($prefix)+1).",".(strlen($default)).")) AS integer) nomaksimal
                        FROM invgedung_t 
                        WHERE invgedung_kode ILIKE ('".$prefix."%')";
                $nourut = Yii::app()->db->createCommand($sql)->queryRow();
                $nourutBaru = (isset($nourut['nomaksimal']) ? ($nourut['nomaksimal']+1) : 1);
                $invgedung_kode = $invgedung_kode.'.'.(str_pad($nourutBaru, strlen($default), 0,STR_PAD_LEFT));
                
                echo CJSON::encode(
                    array(
                        'jumlah' => $jumlah,
                        'awal' => $awal,
                        'invgedung_kode' => $invgedung_kode,
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
                $criteria->addCondition("terimapersdetail_id NOT IN (SELECT terimapersdetail_id FROM invgedung_t WHERE terimapersdetail_id IS NOT NULL)"); //agar detail tidak muncul yg sudah di inventarisasi
                $criteria->order = 'barang_nama';
                $criteria->select = 't.*, bidang.bidang_nama as bidang_nama, subkelompok.subkelompok_nama as subkelompok_nama, kelompok.kelompok_nama as kelompok_nama, golongan_kode, golongan.golongan_nama as golongan_nama
                            ,subsubkelompok.subsubkelompok_nama,subsubkelompok.subsubkelompok_kode,terimaDet.terimapersdetail_id,terima.terimapersediaan_id,terima.nopenerimaan,terimaDet.jmlterima';
                $criteria->join = 'LEFT JOIN subsubkelompok_m As subsubkelompok ON subsubkelompok.subsubkelompok_id = t.subsubkelompok_id'
                        . ' LEFT JOIN subkelompok_m As subkelompok ON subkelompok.subkelompok_id = subsubkelompok.subkelompok_id'
                        . ' LEFT JOIN kelompok_m As kelompok ON kelompok.kelompok_id = subkelompok.kelompok_id'
                        . ' LEFT JOIN bidang_m As bidang ON bidang.bidang_id = kelompok.bidang_id'
                        . ' LEFT JOIN golongan_m As golongan ON golongan.golongan_id = bidang.golongan_id'
                        . ' JOIN terimapersdetail_t As terimaDet ON terimaDet.barang_id = t.barang_id'
                        . ' JOIN terimapersediaan_t As terima ON terima.terimapersediaan_id = terimaDet.terimapersediaan_id';
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
