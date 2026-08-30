
<?php

class BalanceCairanController extends MyAuthController
{
	public $layout = '//layouts/iframe';
	public $defaultAction = 'index';
	public $path_view = 'rawatInap.views.balanceCairan.';
	public $tersimpan = false;

	public function actionIndex($pendaftaran_id, $pasienadmisi_id = null, $balancecairan_id=null)
	{
			$format = new MyFormatter();
			$modPendaftaran= RIPendaftaranT::model()->findByPk($pendaftaran_id);
			if(empty($pasienadmisi_id)){
				$pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
			}
			$modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
			$modAdmisi = RIPasienAdmisiT::model()->findByPk($pasienadmisi_id);
			$modDetCairanmasuk = array();
			$modDetCairankeluar = array();
			$modDetOksigen = array();
			$modDetDiet = array();
			$modDetInfus = array();

			if(!empty($balancecairan_id)){
					$model = BalancecairanT::model()->findByPk($balancecairan_id);

					if(!empty($model)){
						$model->tanggal_pencatatan = MyFormatter::formatDateTimeForUser($model->tanggal_pencatatan);
						$model->petugas_pengisi_nama = $model->petugasPengisi->namaLengkap;
						$modDetCairanmasuk = BalancecairanmasukT::model()->findAllByAttributes(array('balancecairan_id'=>$model->balancecairan_id));
						$modDetCairankeluar = BalancecairankeluarT::model()->findAllByAttributes(array('balancecairan_id'=>$model->balancecairan_id));
						$modDetOksigen = BalancecairanoksigenT::model()->findAllByAttributes(array('balancecairan_id'=>$model->balancecairan_id));
						$modDetDiet = BalancecairandietT::model()->findAllByAttributes(array('balancecairan_id'=>$model->balancecairan_id));
						$modDetInfus = PrograminfusT::model()->findAllByAttributes(array('balancecairan_id'=>$model->balancecairan_id));
					}else{
						$model = new BalancecairanT();
						$model->tanggal_pencatatan = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
					}
			}else{
					$model = new BalancecairanT();
					$model->tanggal_pencatatan = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
			}

			$model->pasienadmisi_id = $modAdmisi->pasienadmisi_id;
			$model->pasien_id = $modPasien->pasien_id;

			if (isset($_POST['BalancecairanT'])) {
					$transaction = Yii::app()->db->beginTransaction();

					try {
						$model->attributes = $_POST['BalancecairanT'];
						$model->tanggal_pencatatan = (!empty($_POST['BalancecairanT']['tanggal_pencatatan'])?MyFormatter::formatDateTimeForDb($_POST['BalancecairanT']['tanggal_pencatatan']):null);

						if(!empty($model->balancecairan_id)){
								$model->update_time = date('Y-m-d H:i:s');
								$model->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
						}else{
								$model->create_time = date('Y-m-d H:i:s');
								$model->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
						}
						$model->create_ruangan_id = Yii::app()->user->getState("ruangan_id");

						$tersimpanmasuk = true;
						$tersimpankeluar = true;
						$tersimpanoksigen = true;
						$tersimpandiet = true;
						$tersimpaninfus = true;
						$tersimpaniwl = true;

						if($model->save()){
								$this->tersimpan = true;
								if(isset($_POST['BalancecairanmasukT']) && count($_POST['BalancecairanmasukT']) >0){
											BalancecairanmasukT::model()->deleteAllByAttributes(array('balancecairan_id'=>$model->balancecairan_id));

											foreach ($_POST['BalancecairanmasukT'] as $dataDet){
													$modDetail = new BalancecairanmasukT();
													$modDetail->attributes = $dataDet;
													$modDetail->balancecairan_id = $model->balancecairan_id;
													$modDetail->jam_pemberian = (!empty($dataDet['jam_pemberian'])? $dataDet['jam_pemberian']:null);
													$modDetail->waktu_pemasangan = (!empty($dataDet['waktu_pemasangan'])?MyFormatter::formatDateTimeForDb($dataDet['waktu_pemasangan']):null);
													$modDetail->jumlah = (!empty($dataDet['jumlah'])?MyFormatter::formatNumberForDb($dataDet['jumlah']):null);

													if(!empty($modDetail->balancecairanmasuk_id)){
																	$modDetail->update_time = date('Y-m-d H:i:s');
																	$modDetail->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
															}else{
																	$modDetail->create_time = date('Y-m-d H:i:s');
																	$modDetail->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
															}
															 $modDetail->create_ruangan_id = Yii::app()->user->getState("pegawai_id");

													 if(!$modDetail->save()){
															$tersimpanmasuk = false;
													}
											}
									}

									if(isset($_POST['BalancecairankeluarT']) && count($_POST['BalancecairankeluarT']) >0){
											BalancecairankeluarT::model()->deleteAllByAttributes(array('balancecairan_id'=>$model->balancecairan_id));

											foreach ($_POST['BalancecairankeluarT'] as $dataDet){
													$modDetail = new BalancecairankeluarT();
													$modDetail->attributes = $dataDet;
													$modDetail->balancecairan_id = $model->balancecairan_id;
													$modDetail->jam = (!empty($dataDet['jam'])? $dataDet['jam']:null);
													$modDetail->waktu_pemasangan = (!empty($dataDet['waktu_pemasangan'])?MyFormatter::formatDateTimeForDb($dataDet['waktu_pemasangan']):null);
													$modDetail->jumlah = (!empty($dataDet['jumlah'])?MyFormatter::formatNumberForDb($dataDet['jumlah']):null);

													if(!empty($modDetail->balancecairankeluar_id)){
																	$modDetail->update_time = date('Y-m-d H:i:s');
																	$modDetail->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
															}else{
																	$modDetail->create_time = date('Y-m-d H:i:s');
																	$modDetail->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
															}
															 $modDetail->create_ruangan_id = Yii::app()->user->getState("pegawai_id");

													 if(!$modDetail->save()){
															$tersimpankeluar = false;
													}
											}
									}

									if(isset($_POST['BalancecairanoksigenT']) && count($_POST['BalancecairanoksigenT']) >0){
											BalancecairanoksigenT::model()->deleteAllByAttributes(array('balancecairan_id'=>$model->balancecairan_id));

											foreach ($_POST['BalancecairanoksigenT'] as $dataDet){
													$modDetail = new BalancecairanoksigenT();
													$modDetail->attributes = $dataDet;
													$modDetail->balancecairan_id = $model->balancecairan_id;
													$modDetail->jam_pemberian = (!empty($dataDet['jam_pemberian'])? $dataDet['jam_pemberian']:null);
													$modDetail->jumlah = (!empty($dataDet['jumlah'])?MyFormatter::formatNumberForDb($dataDet['jumlah']):null);

													if(!empty($modDetail->balanceoksigen_id)){
																	$modDetail->update_time = date('Y-m-d H:i:s');
																	$modDetail->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
															}else{
																	$modDetail->create_time = date('Y-m-d H:i:s');
																	$modDetail->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
															}
															 $modDetail->create_ruangan_id = Yii::app()->user->getState("pegawai_id");

													 if(!$modDetail->save()){
															$tersimpanoksigen = false;
													}
											}
									}

									if(isset($_POST['BalancecairandietT']) && count($_POST['BalancecairandietT']) >0){
											BalancecairandietT::model()->deleteAllByAttributes(array('balancecairan_id'=>$model->balancecairan_id));

											foreach ($_POST['BalancecairandietT'] as $dataDet){
													$modDetail = new BalancecairandietT();
													$modDetail->attributes = $dataDet;
													$modDetail->balancecairan_id = $model->balancecairan_id;
													$modDetail->jam_pemberian = (!empty($dataDet['jam_pemberian'])? $dataDet['jam_pemberian']:null);
													$modDetail->jumlah = (!empty($dataDet['jumlah'])?MyFormatter::formatNumberForDb($dataDet['jumlah']):null);

													if(!empty($modDetail->balancecairandiet_id)){
																	$modDetail->update_time = date('Y-m-d H:i:s');
																	$modDetail->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
															}else{
																	$modDetail->create_time = date('Y-m-d H:i:s');
																	$modDetail->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
															}
															 $modDetail->create_ruangan_id = Yii::app()->user->getState("pegawai_id");

													 if(!$modDetail->save()){
															$tersimpandiet = false;
													}
											}
									}

									if(isset($_POST['PrograminfusT']) && count($_POST['PrograminfusT']) >0){
											PrograminfusT::model()->deleteAllByAttributes(array('balancecairan_id'=>$model->balancecairan_id));

											foreach ($_POST['PrograminfusT'] as $dataDet){
													$modDetail = new PrograminfusT();
													$modDetail->attributes = $dataDet;
													$modDetail->balancecairan_id = $model->balancecairan_id;
													$modDetail->waktu = (!empty($dataDet['waktu'])?MyFormatter::formatDateTimeForDb($dataDet['waktu']):null);
													$modDetail->jumlah = (!empty($dataDet['jumlah'])?MyFormatter::formatNumberForDb($dataDet['jumlah']):null);

													if(!empty($modDetail->programinfus_id)){
																	$modDetail->update_time = date('Y-m-d H:i:s');
																	$modDetail->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
															}else{
																	$modDetail->create_time = date('Y-m-d H:i:s');
																	$modDetail->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
															}
															 $modDetail->create_ruangan_id = Yii::app()->user->getState("pegawai_id");

													 if(!$modDetail->save()){
															$tersimpaninfus = false;
													}
											}
									}

									if(isset($_POST['PerhitunganiwlT']) && count($_POST['PerhitunganiwlT']) >0){
											PerhitunganiwlT::model()->deleteAllByAttributes(array('balancecairan_id'=>$model->balancecairan_id));
										
											foreach ($_POST['PerhitunganiwlT'] as $dataDet){
													$modDetail = new PerhitunganiwlT();
													$modDetail->attributes = $dataDet;
													$modDetail->balancecairan_id = $model->balancecairan_id;
													$modDetail->jam_pemeriksaan = (!empty($dataDet['jam_pemeriksaan'])? $dataDet['jam_pemeriksaan']:null);
													
													if(!empty($modDetail->perhitunganiwl_id)){
															$modDetail->update_time = date('Y-m-d H:i:s');
															$modDetail->update_loginpemakai_id = Yii::app()->user->getState("loginpemakai_id");
													}else{
															$modDetail->create_time = date('Y-m-d H:i:s');
															$modDetail->create_loginpemakai_id = Yii::app()->user->getState("loginpemakai_id");
													}
													 $modDetail->create_ruangan_id = Yii::app()->user->getState("pegawai_id");

													 if(!$modDetail->save()){
															$tersimpaniwl = false;
													}
											}
									}
						}else{
							 $this->tersimpan = false;
						}
						
						if($this->tersimpan == true && $tersimpanmasuk == true && $tersimpankeluar == true && $tersimpanoksigen == true && $tersimpandiet == true && $tersimpaninfus == true && $tersimpaniwl == true){
							$transaction->commit();
							 Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data berhasil disimpan');
							 $this->redirect(array('index','pendaftaran_id' => $pendaftaran_id,'pasienadmisi_id' => $pasienadmisi_id,'balancecairan_id'=>$model->balancecairan_id, 'sukses' => 1, 'type'=> $_GET['type'], 'frame'=> $_GET['frame']));
						}else{
							$transaction->rollback();
							Yii::app()->user->setFlash('error', "Data gagal disimpan!");
						}
					} catch (Exception $ex) {
							$transaction->rollback();
							Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
					}
			}

			$this->render($this->path_view.'index',
					array('modPendaftaran'=>$modPendaftaran,
							'modPasien'=>$modPasien,
							'model'=>$model,
							'modAdmisi'=>$modAdmisi,
							'modDetCairanmasuk'=>$modDetCairanmasuk,
							'modDetCairankeluar'=>$modDetCairankeluar,
							'modDetOksigen'=>$modDetOksigen,
							'modDetDiet'=>$modDetDiet,
							'modDetInfus'=>$modDetInfus

			));
	}

	public function actionPrint($pasienadmisi_id, $tgl_pencatatan)
	{
		$modAdmisi = RIPasienAdmisiT::model()->findByPk($pasienadmisi_id);
		$modPendaftaran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id'=>$modAdmisi->pendaftaran_id));
		$modPasien = PasienM::model()->findByAttributes(array('pasien_id'=>$modPendaftaran->pasien_id));
		$model = BalancecairanT::model()->findByAttributes(array('pasienadmisi_id'=>$pasienadmisi_id),array('condition'=>"tanggal_pencatatan::date = '".$tgl_pencatatan."'"));
		
		$this->layout = '//layouts/printWindows';
		$this->render($this->path_view.'Print',array(
			'modAdmisi'=>$modAdmisi,
			'model'=>$model,
			'modPasien'=>$modPasien,
			'modPendaftaran'=>$modPendaftaran
		));
	}

	public function actionAutocompletePetugasPengisi() {
			if (Yii::app()->request->isAjaxRequest) {
					$criteria = new CDbCriteria();

					$term = $_GET['term'];

					$cr = new CDbCriteria();
					$cr->compare('lower(nama_pegawai)', strtolower($term), true);
					$cr->compare('ruangan_id', Yii::app()->user->getState("ruangan_id"));
					$cr->order = "nama_pegawai";

					$peg = PegawairuanganV::model()->findAll($cr);

					$returnVal = array();

					foreach ($peg as $model) {
							$attributes = $model->attributeNames();
							foreach ($attributes as $i => $attribute) {
									$returnVal[$i]["$attribute"] = $model->$attribute;
							}
							$returnVal[$i]['label'] = $model->namaLengkap;
							$returnVal[$i]['value'] = $model->pegawai_id;
					}

					echo CJSON::encode($returnVal);
			}
			Yii::app()->end();
	}

	public function actionRiwayat($pasienadmisi_id, $balancecairan_id, $type)
	{
		$target = "";
		$this->layout = '//layouts/iframe';

		if($type == 'cairanmasuk'){
			$target = $this->path_view.'_riwayatCairanMasuk';
		}else if($type == 'cairankeluar'){
			$target = $this->path_view.'_riwayatCairanKeluar';
		}else if($type == 'oksigen'){
			$target = $this->path_view.'_riwayatOksigen';
		}else if($type == 'diet'){
			$target = $this->path_view.'_riwayatDiet';
		}else if($type == 'programinfus'){
			$target = $this->path_view.'_riwayatProgramInfus';
		}

			$this->render($target,array(
				'pasienadmisi_id'=>$pasienadmisi_id,
				'balancecairan_id'=>$balancecairan_id));
	}

	public function actionHapusRiwayat(){
			if(Yii::app()->request->isPostRequest)
			{
					$id = $_POST['id'];
					$message = "";
					$sukses = 0;

					$model = BalancecairanT::model()->findByAttributes(array('balancecairan_id'=>$id));

					if(!empty($model)){
						BalancecairanmasukT::model()->deleteAllByAttributes(array('balancecairan_id'=>$model->balancecairan_id));
						BalancecairankeluarT::model()->deleteAllByAttributes(array('balancecairan_id'=>$model->balancecairan_id));
						BalancecairanoksigenT::model()->deleteAllByAttributes(array('balancecairan_id'=>$model->balancecairan_id));
						BalancecairandietT::model()->deleteAllByAttributes(array('balancecairan_id'=>$model->balancecairan_id));
						PrograminfusT::model()->deleteAllByAttributes(array('balancecairan_id'=>$model->balancecairan_id));
						$deleteData = $model->delete();

						if($deleteData){
							$message = "Data Berhasil Dihapus!";
							$sukses = 1;
						}else{
							$message = "Data gagal Dihapus!";
							$sukses = 0;
						}
					}

					echo CJSON::encode(array(
									'sukses'=> $sukses,
									'msg'=>$message,
									));
					exit;
					// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
					if(!isset($_GET['ajax']))
													$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
			else
					throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionPerhitunganBalanceCairan($pasienadmisi_id, $tanggal_pencatatan)
	{
			$format = new MyFormatter();
			$modAdmisi = RIPasienAdmisiT::model()->findByPk($pasienadmisi_id);
			$findBalanceCairan = BalancecairanT::model()->findByAttributes(array('pasienadmisi_id'=>$pasienadmisi_id,'tanggal_pencatatan'=>$tanggal_pencatatan));
			$model = new PerhitunganbalancecairanT();
			$model->balancecairan_tanggal = MyFormatter::formatDateTimeForUser($tanggal_pencatatan);
			$model->pasienadmisi_id = $pasienadmisi_id;
			$model->waktu_perhitungan = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));

			if (isset($_POST['PerhitunganbalancecairanT'])) {
					$transaction = Yii::app()->db->beginTransaction();

					try {
						$model->attributes = $_POST['PerhitunganbalancecairanT'];
						$model->balancecairan_tanggal = (!empty($_POST['PerhitunganbalancecairanT']['balancecairan_tanggal'])?MyFormatter::formatDateTimeForDb($_POST['PerhitunganbalancecairanT']['balancecairan_tanggal']):null);
						$model->waktu_perhitungan = (!empty($_POST['PerhitunganbalancecairanT']['waktu_perhitungan'])?MyFormatter::formatDateTimeForDb($_POST['PerhitunganbalancecairanT']['waktu_perhitungan']):null);

						if(!empty($model->perhitunganbalancecairan_id)){
								$model->update_time = date('Y-m-d H:i:s');
								$model->update_loginpemakai_id = Yii::app()->user->getState("loginpemakai_id");
						}else{
								$model->create_time = date('Y-m-d H:i:s');
								$model->create_loginpemakai_id = Yii::app()->user->getState("loginpemakai_id");
						}
						$model->create_ruangan_id = Yii::app()->user->getState("ruangan_id");

						if($model->save()){
								$this->tersimpan = true;
						}else{
							 $this->tersimpan = false;
						}

						if($this->tersimpan == true){
							$transaction->commit();
							 Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data berhasil disimpan');
							 $this->redirect(array('perhitunganBalanceCairan','pasienadmisi_id' => $pasienadmisi_id,'tanggal_pencatatan'=>$tanggal_pencatatan, 'sukses' => 1, 'type'=> $_GET['type'], 'frame'=> $_GET['frame']));
						}else{
							$transaction->rollback();
							Yii::app()->user->setFlash('error', "Data gagal disimpan!");
						}
					} catch (Exception $ex) {
							$transaction->rollback();
							Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
					}
			}

			$this->render($this->path_view.'perhitunganBalanceCairan',
					array('model'=>$model,
							'modAdmisi'=>$modAdmisi

			));
	}

	public function actionDetailPerhitunganCairan($perhitunganbalancecairan_id)
	{
		$this->layout = '//layouts/iframe';
		$model = PerhitunganbalancecairanT::model()->findByPk($perhitunganbalancecairan_id);

		$this->render($this->path_view.'_detailPerhitunganCairan',array(
			'model'=>$model
		));
	}
}
