<?php
Yii::import('rawatInap.controllers.RehabMedisTRIController');
Yii::import('rawatInap.models.*');
class RehabMedisTPIController extends RehabMedisTRIController
{
}

/*
class RehabMedisTPIController extends MyAuthController
{
        protected $statusSaveKirimkeUnitLain = false;
        protected $statusSavePermintaanPenunjang = false;
    
	public function actionIndex($pendaftaran_id,$pasienadmisi_id)
	{
            $this->layout='//layouts/iframe';
            $modPasienMasukPenunjang = array();
            $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id)) : array();
            $modPendaftaran = PIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            $modPasien = PIPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modKirimKeUnitLain = new PIPasienKirimKeUnitLainT;
            $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
//            $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
            $modKirimKeUnitLain->pegawai_id = isset($modAdmisi->pegawai_id) ? $modAdmisi->pegawai_id : $modPendaftaran->pegawai_id;
            $modJenisTindakanRm = PIJenisTindakanRmM::model()->findAllByAttributes(array('jenistindakanrm_aktif'=>true),array('order'=>'jenistindakanrm_nama'));
            $modTindakanRm = PITindakanRmM::model()->findAllByAttributes(array('tindakanrm_aktif'=>true),array('order'=>'tindakanrm_nama'));
            
            $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id ='.$modAdmisi->penjamin_id);

            $nama_modul = Yii::app()->controller->module->id;
            $nama_controller = Yii::app()->controller->id;
            $nama_action = Yii::app()->controller->action->id;
            $modul_id = ModulK::model()->findByAttributes(array('url_modul'=>$nama_modul))->modul_id;
            $criteria = new CDbCriteria;
            $criteria->compare('modul_id',$modul_id);
            $criteria->compare('LOWER(modcontroller)',strtolower($nama_controller),true);
            $criteria->compare('LOWER(modaction)',strtolower($nama_action),true);
            if(isset($_POST['tujuansms'])){
                $criteria->addInCondition('tujuansms',$_POST['tujuansms']);
            }
            $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

            if(isset($_GET['idPasienKirimKeUnitLain'])){
                $modKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findByPk($_GET['idPasienKirimKeUnitLain']);
                $modPasien = $modKirimKeUnitLain->pasien;
            }

            if(isset($_POST['PIPasienKirimKeUnitLainT'])) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $modKirimKeUnitLain = $this->savePasienKirimKeUnitLain($modAdmisi);
                    if(isset($_POST['permintaanPenunjang'])){
                        $this->savePermintaanPenunjang($_POST['permintaanPenunjang'],$modKirimKeUnitLain);
                    } else {
                        $this->statusSavePermintaanPenunjang = true;
                    }
                    
                    if($this->statusSaveKirimkeUnitLain && $this->statusSavePermintaanPenunjang){
                        
                        // SMS GATEWAY
                        $modPegawai = $modPendaftaran->pegawai;
                        $sms = new Sms();
                        $smspasien = 1;
                        foreach ($modSmsgateway as $i => $smsgateway) {
                            $isiPesan = $smsgateway->templatesms;

                            $attributes = $modPasien->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $attributes = $modPendaftaran->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $attributes = $modPegawai->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $attributes = $modKirimKeUnitLain->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modKirimKeUnitLain->tgl_kirimpasien),$isiPesan);
                            
                            if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                if(!empty($modPasien->no_mobile_pasien)){
                                    $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                                }else{
                                    $smspasien = 0;
                                }
                            }
                        }
                        // END SMS GATEWAY
                        
                        $transaction->commit();
                        Yii::app()->user->setFlash('success',"Data Berhasil disimpan");
                        $this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id, 'pasienadmisi_id'=>$pasienadmisi_id, 'idPasienKirimKeUnitLain'=>$modKirimKeUnitLain->pasienkirimkeunitlain_id, 'smspasien'=>$smspasien));
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data tidak valid ");
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Gagal disimpan. ".MyExceptionMessage::getMessage($exc,true));
                }
            }
		
            $modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
                                                                                                      'ruangan_id'=>Params::RUANGAN_ID_FISIOTERAPI),
                                                                                                'pasienmasukpenunjang_id IS NULL');
            
			$modBayarUangMuka = PIBayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
			$total = 0;
			foreach ($modBayarUangMuka as $key => $value){
				$total += $modBayarUangMuka[$key]->jumlahuangmuka;
			}
			$modDeposit = (($modBayarUangMuka)?$total : null);
			
            $this->render('index',array('modPendaftaran'=>$modPendaftaran,
                                        'modPasien'=>$modPasien,
                                        'modKirimKeUnitLain'=>$modKirimKeUnitLain,
                                        'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,
                                        'modJenisTindakanRm'=>$modJenisTindakanRm,
                                        'modTindakanRm'=>$modTindakanRm,
                                        'modAdmisi'=>$modAdmisi,
                                        'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,
                                        'modJenisTarif'=>$modJenisTarif,
                                        'modDeposit'=>$modDeposit,
                ));
	}

        protected function savePasienKirimKeUnitLain($modAdmisi)
        {
            $modKirimKeUnitLain = new PIPasienKirimKeUnitLainT;
            $modKirimKeUnitLain->attributes = $_POST['PIPasienKirimKeUnitLainT'];
            $modKirimKeUnitLain->pasien_id = $modAdmisi->pasien_id;
            $modKirimKeUnitLain->pendaftaran_id = $modAdmisi->pendaftaran_id;
            //$modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
            $modKirimKeUnitLain->kelaspelayanan_id = $modAdmisi->kelaspelayanan_id;
            $modKirimKeUnitLain->instalasi_id = Params::INSTALASI_ID_REHAB;
            $modKirimKeUnitLain->ruangan_id = Params::RUANGAN_ID_FISIOTERAPI;
            $modKirimKeUnitLain->create_time = date("Y-m-d H:i:s");
            $modKirimKeUnitLain->update_time = date("Y-m-d H:i:s");
            $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
            $modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->id;
//            $modKirimKeUnitLain->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modKirimKeUnitLain->create_ruangan = $modAdmisi->ruangan_id;
			$modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
            $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modKirimKeUnitLain->ruangan_id);
            if($modKirimKeUnitLain->validate()){
                $modKirimKeUnitLain->save();
                $this->statusSaveKirimkeUnitLain = true;
            }
            
            return $modKirimKeUnitLain;
        }
        
        protected function savePermintaanPenunjang($permintaan,$modKirimKeUnitLain)
        {
            foreach ($permintaan['inputtindakanrm'] as $i => $value) {
                $modPermintaan = new PIPermintaanPenunjangT;
                $modPermintaan->tindakanrm_id = $permintaan['inputtindakanrm'][$i];
                $modPermintaan->daftartindakan_id = $permintaan['idDaftarTindakan'][$i];
                $modPermintaan->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
                $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('PM');
                $modPermintaan->qtypermintaan = $permintaan['inputqty'][$i];
                $modPermintaan->tglpermintaankepenunjang = $modKirimKeUnitLain->tgl_kirimpasien; //date('Y-m-d H:i:s');
                if($modPermintaan->validate()){
                    $modPermintaan->save();
                    $this->statusSavePermintaanPenunjang = true;
                }
            }
        }
        
		public function actionBatalRujukan($task='BatalPenunjang'){
			if(Yii::app()->request->isAjaxRequest)
			{ 
				$pesan = '';
				$status = '';
				
				$pasienkirimkeunitlain_id = isset($_POST['pasienkirimkeunitlain_id']) ? $_POST['pasienkirimkeunitlain_id'] : null;
				$pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;		
				$ruangan_id = Yii::app()->user->getState('ruangan_id');
				
				$modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
											'ruangan_id'=>Params::RUANGAN_ID_FISIOTERAPI),
											'pasienmasukpenunjang_id IS NULL');
				
				$transaction = Yii::app()->db->beginTransaction();
				try{
					$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

					$criteria = new CDbCriteria();
					$criteria->addCondition('t.pasienkirimkeunitlain_id = '.$pasienkirimkeunitlain_id);
					$criteria->addCondition('tindakanpelayanan_t.tindakansudahbayar_id is not null');
					$criteria->join = 'JOIN tindakanpelayanan_t ON tindakanpelayanan_t.tindakanpelayanan_id = t.tindakanpelayanan_id';
					$modPermintaanPenunjang = PermintaankepenunjangT::model()->findAll($criteria);

					if(count((array)$modPermintaanPenunjang) > 0){
						$pesan = "Pemeriksaan Rujukan tidak bisa dibatalkan karena ada tindakan yang sudah dibayarkan!";
					}else{
						$modPermintaanKePenunjang = PermintaankepenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$pasienkirimkeunitlain_id));
						if(count((array)$modPermintaanKePenunjang) > 0){
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

								$delete_tindakanpelayanan = TindakanpelayananT::model()->deleteByPk($detail->tindakanpelayanan_id);
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

				$data = array(
				  'pesan'=>$pesan,
				  'status'=>$status,
				  'result'=> $this->renderPartial('_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain), true)
				);
				echo json_encode($data);
				Yii::app()->end();
			}			
		}
		
//        public function actionAjaxBatalKirim()
//        {
//            if(Yii::app()->request->isAjaxRequest) {
//            $idPasienKirimKeUnitLain = $_POST['idPasienKirimKeUnitLain'];
//            $pendaftaran_id = $_POST['pendaftaran_id'];
//            
//            PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id'=>$idPasienKirimKeUnitLain));
//            PasienkirimkeunitlainT::model()->deleteByPk($idPasienKirimKeUnitLain);
//            $modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
//                                                                                                      'ruangan_id'=>Params::RUANGAN_ID_FISIOTERAPI),
//                                                                                                'pasienmasukpenunjang_id IS NULL');
//            
//            $data['result'] = $this->renderPartial('_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain), true);
//
//            echo json_encode($data);
//             Yii::app()->end();
//            }
//        }

        /**
         * action ajax untuk load form pemeriksaan rehab medis
         *//*
       public function actionLoadFormPermintaanRehabMedis()
        {
            if (Yii::app()->request->isAjaxRequest)
            {
                $tindakanrm_id = isset($_POST['tindakanrm_id']) ? $_POST['tindakanrm_id'] : null;
                $kelaspelayanan_id = isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null;
                $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
                $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);        
                
                $criteria = new CDbCriteria();
                $criteria->addCondition('tindakanrm_id = '.$tindakanrm_id);
                $criteria->addCondition('kelaspelayanan_id = '.$kelaspelayanan_id);
                $criteria->addCondition('penjamin_id = '.$modPendaftaran->penjamin_id);
                $modTarif = TarifpemeriksaanrmruanganV::model()->find($criteria);
                
                /**
                 * dicomment RND-3287
                 */
//                $jenistarif = JenistarifpenjaminM::model()->find('penjamin_id = '.$modPendaftaran->penjamin_id)->jenistarif_id;
//                $modTindakanRm = TindakanrmM::model()->with('jenistindakanrm')->findByPk($tindakanrm_id);
//                $modTarif = TariftindakanM::model()->findByAttributes(array('daftartindakan_id'=>$modTindakanRm->daftartindakan_id,
//                                                                            'kelaspelayanan_id'=>$kelaspelayanan_id,
//                                                                            'jenistarif_id'=>$jenistarif,
//             
//                                                                                                                                           'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
            /* if(!empty($modTarif)){
                echo CJSON::encode(array(
                    'status'=>'create_form', 
                    'form'=>$this->renderPartial('_formLoadPermintaanRehabMedis', array(
//                                                                                        'modTindakanRm'=>$modTindakanRm,
        //                                                                                'idKelasPelayanan'=>$idKelasPelayanan,
                                                                                           'modTarif'=>$modTarif), true)));

            }else{
                echo CJSON::encode(array(
                    'status'=>'create_form', 
                    'form'=>''));
            }
                exit;               
            }
        }

        public function actionPrint()
        {
             $pendaftaran_id = $_GET['id'];
             $idPasienKirimKeUnitLain = $_GET['idPasienKirimKeUnitLain'];
             $modPendaftaran= PendaftaranT::model()->findByPk($pendaftaran_id);
             $modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
                'pasienkirimkeunitlain_id'=>$idPasienKirimKeUnitLain),
                'pasienmasukpenunjang_id IS NULL');

            $judulLaporan='Permintaan Pemeriksaan Rehab Medis';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render('Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render('Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF60('',$ukuranKertasPDF); 
                $mpdf->mirrorMargins = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial('Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
        }

        public function actionPrintRiwayat()
        {
             $pendaftaran_id = $_GET['id'];
             $modPendaftaran= PendaftaranT::model()->findByPk($pendaftaran_id);
             $modKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAll('pendaftaran_id='.$pendaftaran_id);
            $modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
                                                                                                      'ruangan_id'=>Params::RUANGAN_ID_FISIOTERAPI),
                                                                                                'pasienmasukpenunjang_id IS NULL');
            
            $judulLaporan='Permintaan Pemeriksaan Rehabilitasi Medis';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render('printRiwayat',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render('printRiwayat',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF60('',$ukuranKertasPDF); 
                $mpdf->mirrorMargins = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial('printRiwayat',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
        }
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
// }