<?php

class RujukanPenunjangController extends MyAuthController
{
    public $instalasi_ruangan, $nama_pasien_panggilan, $cara_bayar_penjamin, $kasus_pelayanan;
    public function actionIndex()
    {
        $format = new MyFormatter;
        $model = new LBPasienKirimKeUnitLainV();
        $model->tgl_awal = date('Y-m-d');//, strtotime('-5 days')
        $model->tgl_akhir = date('Y-m-d');
        
        
        if(isset($_GET['LBPasienKirimKeUnitLainV'])){
            $model->attributes = $_GET['LBPasienKirimKeUnitLainV'];
            
            //$model->cbTglMasuk = $_GET['LBPasienKirimKeUnitLainV']['cbTglMasuk'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBPasienKirimKeUnitLainV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBPasienKirimKeUnitLainV']['tgl_akhir']);
            $model->prefix_pendaftaran = $_GET['LBPasienKirimKeUnitLainV']['prefix_pendaftaran'];
			$model->statusperiksa = isset($_GET['LBPasienKirimKeUnitLainV']['statusperiksa'])?$_GET['LBPasienKirimKeUnitLainV']['statusperiksa']:null;
			//$model->namaDokter = isset($_GET['LBPasienKirimKeUnitLainV']['namaDokter'])?$_GET['LBPasienKirimKeUnitLainV']['namaDokter']:null;
        }
        $model->cbTglMasuk = true;
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $this->render('index',array('model'=>$model,'format'=>$format));
    }
    
    /**
	 * Date		: 12 Juni 2015
	 *
	 */
	public function actionBatalRujuk()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $pendaftaran_id = $_POST['pendaftaran_id'];
                $idKirimUnit = $_POST['idKirimUnit'];
				//$keterangan_batal = isset($_POST['keterangan_batal'])?$_POST['keterangan_batal']:null;

                $transaction = Yii::app()->db->beginTransaction();
                $status = 'ok';
                $status_bayar = 'ok';

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
                $smspasien = 1;
                $nama_pasien = '';

                try {
                    $criteria = new CDbCriteria();
                    $criteria->select = "count(t.permintaankepenunjang_id) as permintaankepenunjang_id";
                    $criteria->join = "join tindakanpelayanan_t tp on tp.tindakanpelayanan_id = t.tindakanpelayanan_id ";
                    $criteria->addCondition("t.pasienkirimkeunitlain_id = ".$idKirimUnit." and tp.tindakansudahbayar_id is not null");
                    $permintaan = PermintaankepenunjangT::model()->find($criteria);
                    if ($permintaan->permintaankepenunjang_id > 0) {
                        $keterangan = "Pemeriksaan tidak bisa dibatalkan karena ada pemeriksaan yang sudah dibayarkan";
                    } else {
                        $ok = true;
                        $kirim = PasienkirimkeunitlainT::model()->findByPk($idKirimUnit);
                        $permintaan = PermintaankepenunjangT::model()->findAllByAttributes(array(
                            'pasienkirimkeunitlain_id'=>$idKirimUnit
                        ));
						
						/*$model = new PasienbatalperiksaR();
						$model->pendaftaran_id = $kirim->pendaftaran_id;
						$model->pasien_id = $kirim->pasien_id;
						//$model->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
						$model->pasienkirimkeunitlain_id = $idKirimUnit;
						$model->tglbatal = date('Y-m-d');
						$model->keterangan_batal = $keterangan_batal;
						$model->create_time = date('Y-m-d H:i:s');
						$model->update_time = null;
						$model->create_loginpemakai_id = Yii::app()->user->id;
						$model->create_ruangan = Yii::app()->user->getState('ruangan_id');*/

						//if ($model->validate()) {
						//	$ok = $ok && $model->save();
						//} else $ok = false;
						
						
                        foreach ($permintaan as $item) {
                            if (!empty($item->tindakanpelayanan_id)) {
                                $ok = $ok && TindakanpelayananT::model()->deleteByPk($item->tindakanpelayanan_id);
                            }
                        }
						//var_dump($idKirimUnit);
                        $ok = $ok && PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id'=>$idKirimUnit));
						//var_dump($ok);
                        $ok = $ok && PasienkirimkeunitlainT::model()->deleteByPk($idKirimUnit);
						//var_dump($ok);
                        $keterangan = "Pasien berhasil dibatalkan";
                        if($status == 'ok' && $ok) {
                                $this->notifBatalRujuk($kirim);
                                $transaction->commit();
                        } else {
								$keterangan = "Pasien gagal dibatalkan";
								$status = 'not';
                                $transaction->rollback();
                        }
                    }
                } catch (Exception $ex) {
                    print_r($ex);
                    $status = 'not';
                    $transaction->rollback();
                }
                $data = array(
                    'status'=>$status,
                    'keterangan'=>$keterangan,
                    //'smspasien'=>$smspasien,
                    //'nama_pasien'=>$nama_pasien,
                );
                echo json_encode($data);
                Yii::app()->end(); 
            }
	}
        
        protected function notifBatalRujuk($modKirimKeunitlain) {
            
            $modRuangan = RuanganM::model()->findByPk($modKirimKeunitlain->create_ruangan);
            $pasien_id = $modKirimKeunitlain->pasien_id;
            $modPasien = PasienM::model()->findByPk($pasien_id);
            $judul = 'Pasien Batal Rujuk Laboratorium';

            $isi = $modPasien->no_rekam_medik.' - '.$modPasien->nama_pasien
                    .'<br/>Tgl Rujuk : '.MyFormatter::formatDateTimeForUser($modKirimKeunitlain->tgl_kirimpasien);
            
            //var_dump($judul." , ".$isi);
            
            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id'=>$modRuangan->instalasi_id, 'ruangan_id'=>$modRuangan->ruangan_id, 'modul_id'=>$modRuangan->modul_id),
				array('instalasi_id'=> Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_KASIR, 'modul_id'=> Params::MODUL_ID_BILLINGKASIR),
            )); 
        }
        
    /**
     * @author Tantowy <tantowijaya@.com>
     * action ketika tombol panggil di klik
     */
    public function actionPanggil()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            $data['pesan']="";
            $data['status']="";
            $pasienkirimkeunitlain_id = ($_POST['pasienkirimkeunitlain_id']);
            $modKirimUnit = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);

            $nama_modul = Yii::app()->controller->module->id;
            $nama_controller = Yii::app()->controller->id;
            $nama_action = Yii::app()->controller->action->id;
            $modul_id = ModulK::model()->findByAttributes(array('url_modul'=>$nama_modul))->modul_id;
            $criteria = new CDbCriteria;
            $criteria->compare('modul_id', $modul_id);
            $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
            $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
            if (isset($_POST['tujuansms'])) {
                $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
            }
            $modSmsgateway = SmsgatewayM::model()->findAll($criteria);
            $data['smspasien'] = 1;
            $data['nama_pasien'] = '';
            
            $tatusPanggil = true;
            if(!empty($modKirimUnit->panggil_loginpemakai_id)){
                if($modKirimUnit->panggil_loginpemakai_id == Yii::app()->user->getState('loginpemakai_id')){
                    $tatusPanggil = true;
                }else{
                    $tatusPanggil = false;
                    $data['pesan'] = "Antrian sudah dipanggil loket lain";
                    $data['status'] = "gagal";
                }
            }

            if (isset($modKirimUnit) && $tatusPanggil) {
                if(empty($modKirimUnit->nourut)){
                    $modKirimUnit->jml_panggil = 1;
                    $modKirimUnit->jampanggil = date('Y-m-d H:i:s');
                    $modKirimUnit->panggil_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $modKirimUnit->update();
                    $data['pesan'] = "No. antrian ".$modKirimUnit->nourut." dipanggil !";
                }else{
                    $modKirimUnit->jml_panggil = ($modKirimUnit->jml_panggil+1);
                    $modKirimUnit->jampanggil = date('Y-m-d H:i:s');
                    $modKirimUnit->panggil_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $modKirimUnit->update();
                    $data['pesan'] = "No. antrian ".$modKirimUnit->nourut." dipanggil !";
                }
                $data['smspasien'] = 1;
            }
            $attributes = $modKirimUnit->attributeNames();
            foreach ($attributes as $i=>$attribute) {
                $data["$attribute"] = $modKirimUnit->$attribute;
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }
}