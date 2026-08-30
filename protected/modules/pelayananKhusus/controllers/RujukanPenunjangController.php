<?php

class RujukanPenunjangController extends MyAuthController
{
 
	public function actionIndex()
	{
            $this->pageTitle = Yii::app()->name." - Pasien Rujukan";
            $criteria = new CDbCriteria;
            if(isset($_GET['ajax']) && $_GET['ajax']=='pasienpenunjangrujukan-m-grid') {
                $format = new MyFormatter;
				if(isset($_GET['noPendaftaran'])){
					$criteria->compare('LOWER(no_pendaftaran)', strtolower($_GET['noPendaftaran']),true);
				}
				if(isset($_GET['namaPasien'])){
					$criteria->compare('LOWER(nama_pasien)', strtolower($_GET['namaPasien']),true);
				}
				if(isset($_GET['noRekamMedik'])){
					$criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['noRekamMedik']),true);
				}
                if(isset($_GET['cbTglMasuk'])){
                    $criteria->addBetweenCondition('DATE(tgl_kirimpasien)', $format->formatDateTimeForDb($_GET['tgl_awal']),$format->formatDateTimeForDb($_GET['tgl_akhir']));
				}
            } else {
                //$criteria->addBetweenCondition('tgl_pendaftaran', date('Y-m-d').' 00:00:00', date('Y-m-d').' 23:59:59');
                $criteria->addBetweenCondition('DATE(tgl_kirimpasien)', date('Y-m-d'), date('Y-m-d'));
            }
            
            $criteria->addCondition('instalasi_id ='.Yii::app()->user->getState('instalasi_id'));
            
            $dataProvider = new CActiveDataProvider(PasienkirimkeunitlainV::model(), array(
			'criteria'=>$criteria,
		));
            $this->render('index',array('dataProvider'=>$dataProvider));
	}
        /**
         * Fungsi untuk mengupadte hasil pemeriksaan rehab medis menset tindakanpelayanan id
         * @param type $modTindPelayanan model object
         */
        protected function upadateHasilTindakan($modTindPelayanan)
        {
            $modHasil = $this->loadById($modTindPelayanan->hasilpemeriksaanrm_id);
            $modHasil->tindakanpelayanan_id = $modTindPelayanan->tindakanpelayanan_id;
            $modHasil->save();
        }
        
        /**
         * Fungsi untuk mengembalikan object $model dengan method findByPk yang nanti digunakan untuk menyimpan data-data hasil pemeriksaan
         * @param type $id
         * @return type 
         */
        protected function loadById($id)
        {       $model= HasilpemeriksaanrmT::model()->findByPk($id);
		if($model===null)
                    throw new CHttpException(404,'The requested page does not exist.');
		return $model;
        }
        
        
        protected function updatePasienKirimKeUnitLain($modPasienPenunjang) {
            
            if(!empty($_POST['permintaanPenunjang'])){
                foreach($_POST['permintaanPenunjang'] as $i => $item) {
                    PasienkirimkeunitlainT::model()->updateByPk($item['idPasienKirimKeUnitLain'], 
                                                                array('pasienmasukpenunjang_id'=>$modPasienPenunjang->pasienmasukpenunjang_id));
                }
            }
        }
		
		public function actionLoadFormPemeriksaanRMPendRM()
		{
			if (Yii::app()->request->isAjaxRequest)
			{
				$idPemeriksaanRM = $_POST['idPemeriksaanRM'];
				$idKelasPelayanan = $_POST['kelasPelayan_id'];
				$modPeriksaRM = TindakanrmM::model()->with('jenistindakanrm')->findByPk($idPemeriksaanRM);
				$modTarif = TariftindakanM::model()->findByAttributes(array('daftartindakan_id'=>$modPeriksaRM->daftartindakan_id,
																			'kelaspelayanan_id'=>$idKelasPelayanan,
																			'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));

				echo CJSON::encode(array(
					'status'=>'create_form', 
					'form'=>$this->renderPartial('_formLoadPemeriksaanRMPendRM', array('modPeriksaRM'=>$modPeriksaRM,
																				  'modTarif'=>$modTarif,
																				  'idKelasPelayanan'=>$idKelasPelayanan  ), true)));
				exit;               
			}
		}
		
		public function actionLoadFormRehabMedisMasuk()
		{
			if (Yii::app()->request->isAjaxRequest)
			{
				$idPemeriksaanRM = $_POST['idPemeriksaanRM'];
				$idKelasPelayanan = $_POST['kelasPelayanan_id'];


				$modTindakan = TindakanrmM::model()->with('jenistindakanrm')->findByPk($idPemeriksaanRM);
				$modTarif = TariftindakanM::model()->findByAttributes(array('daftartindakan_id'=>$modTindakan->daftartindakan_id,
																			'kelaspelayanan_id'=>$idKelasPelayanan,
																			'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
				echo CJSON::encode(array(
					'status'=>'create_form', 
					'form'=>$this->renderPartial('_formLoadRehabMedisMasuk', array('modTindakan'=>$modTindakan,
																				  'modTarif'=>$modTarif,
																				  'idKelasPelayanan'=>$idKelasPelayanan), true)));
				exit;               
			}
		}
        
        public function actionBatalRujukan($task='BatalPenunjang'){
		if(Yii::app()->request->isAjaxRequest)
		{ 
			$pesan = '';
			$status = '';
			
			$pasienkirimkeunitlain_id = isset($_POST['pasienkirimkeunitlain_id']) ? $_POST['pasienkirimkeunitlain_id'] : null;
			$pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;

			$username = isset($_POST['nama_pemakai']) ? $_POST['nama_pemakai'] : null;
			$password = isset($_POST['kata_kunci']) ? $_POST['kata_kunci'] : null;
			$ruangan_id = Yii::app()->user->getState('ruangan_id');
			
			$user = LoginpemakaiK::model()->findByAttributes(array('nama_pemakai' => $username,
																   'loginpemakai_aktif' =>TRUE));
			if ($user === null) {
				$data['error'] = "Login Pemakai salah!";
				$data['cssError'] = 'username';
				$data['status'] = 'Gagal Login';
				$pesan = 'Gagal Login';
			} else {
				// cek password
				if (!$user->cekPassword3($password)) {
					$data['error'] = 'password salah!';
					$data['cssError'] = 'password';
					$data['status'] = 'Gagal Login';
					$pesan = 'Gagal Login';
				} else {
					$data['error'] = '';
					//$cek = $this->checkAccess(array('loginpemakai_id'=>$user->loginpemakai_id, 'action'=>$task)); //dari MyAuthController
					//if($cek){
						$data['status'] = 'success';
						$data['userid'] = $user->loginpemakai_id;
						$data['username'] = $user->nama_pemakai;
						
						$transaction = Yii::app()->db->beginTransaction();
						try{
							$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
							
							$criteria = new CDbCriteria();
							$criteria->addCondition('t.pasienkirimkeunitlain_id = '.$pasienkirimkeunitlain_id);
							$criteria->addCondition('tindakanpelayanan_t.tindakansudahbayar_id is not null');
							$criteria->join = 'JOIN tindakanpelayanan_t ON tindakanpelayanan_t.tindakanpelayanan_id = t.tindakanpelayanan_id';
							$modPermintaanPenunjang = PermintaankepenunjangT::model()->findAll($criteria);
							
							if(count($modPermintaanPenunjang) > 0){
								$pesan = "Pemeriksaan Rujukan tidak bisa dibatalkan karena ada tindakan yang sudah dibayarkan!";
							}else{
								$modPermintaanKePenunjang = PermintaankepenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$pasienkirimkeunitlain_id));
								if(count($modPermintaanKePenunjang) > 0){
									foreach($modPermintaanKePenunjang as $i=>$detail){
										$update_tindakanpelayanan = TindakanpelayananT::model()->updateByPk($detail->tindakanpelayanan_id,array('detailhasilpemeriksaanlab_id'=>null,
										'hasilpemeriksaanrm_id'=>null,
										'hasilpemeriksaanrad_id'=> null,
										'hasilpemeriksaanpa_id'=>null));

										if($update_tindakanpelayanan){
											$update_tindakan = true;
											$status = true;
										}else{
											$update_tindakan = false;
											$status = false;
										}

										$delete_tindakanpelayanan = TindakanpelayananT::model()->deleteAllByAttributes(array(
											'daftartindakan_id'=>$detail->daftartindakan_id,
											'pasienmasukpenunjang_id'=>null
										));
										
										if($delete_tindakanpelayanan){	
											$delete_tindakan = true;
											$status = true;
										}else{
											$delete_tindakan = false;
											$status = false;
										}										
									}
									if($status = true){
										$delete_permintaankepenunjang = PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id'=>$pasienkirimkeunitlain_id));
										if($delete_permintaankepenunjang){						
											$delete_penunjang = true;
											PasienkirimkeunitlainT::model()->deleteByPk($pasienkirimkeunitlain_id);
											$status = true;
										}else{
											$delete_penunjang = false;
											$status = false;
										}
									}
								}else{
									$delete_permintaankepenunjang = PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id'=>$pasienkirimkeunitlain_id));
									if($delete_permintaankepenunjang){						
										$delete_penunjang = true;
										PasienkirimkeunitlainT::model()->deleteByPk($pasienkirimkeunitlain_id);
										$status = true;
									}else{
										$delete_penunjang = false;
										$status = false;
									}									
								}

								if($status = true){		
									$pesan = 'Pasien Penunjang berhasil di batalkan';
									$transaction->commit();
								}else{
									$transaction->rollback();
								}
							}
						} catch (Exception $ex) {
							$status = false;
							$pesan = "exist";
							$transaction->rollback();
						}		  
					//} else {
					//	$data['status'] = 'Tidak memiliki akses untuk melakukan pembatalan!';
					//}
				}
			}
			
			$data = array(
			  'pesan'=>$pesan,
			  'status'=>$status,
			);
			echo json_encode($data);
			Yii::app()->end();
		}			
	}
}