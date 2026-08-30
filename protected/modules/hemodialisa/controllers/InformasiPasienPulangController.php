<?php

class InformasiPasienPulangController extends MyAuthController
{
	public function actionIndex()
	{
            
            $modPasienYangPulang = new HDPasienpulangrddanriV;
            $format = new MyFormatter;
            $modPasienYangPulang->tgl_awal=date('d M Y');
            $modPasienYangPulang->tgl_akhir=date('d M Y');
            $modPasienYangPulang->ceklis = true;
            if(isset($_GET['HDPasienpulangrddanriV'])){
                $modPasienYangPulang->attributes=$_GET['HDPasienpulangrddanriV'];
                $modPasienYangPulang->tgl_awal = $format->formatDateTimeForDb($_GET['HDPasienpulangrddanriV']['tgl_awal']);
                $modPasienYangPulang->tgl_akhir = $format->formatDateTimeForDb($_GET['HDPasienpulangrddanriV']['tgl_akhir']);
                $modPasienYangPulang->ceklis = $_REQUEST['HDPasienpulangrddanriV']['ceklis'];
            }
			
			$this->render('index',array(
				'modPasienYangPulang'=>$modPasienYangPulang
			));
            
	}
        
//        public function actionBatalPulang()
//        {
//            if(Yii::app()->request->isAjaxRequest){
//            $idOtoritas = $_POST['idOtoritas'];
//            $namaOtoritas = $_POST['namaOtoritas'];
//            $idPasienPulang=$_POST['idPasienPulang'];
//            $pasienadmisi_id=$_POST['pasienadmisi_id'];
//            $alasanPembatalan=$_POST['Alasan'];
//            
//            
//            $modPasienBatalPulang = new RIPasienBatalPulangT;    
//            $modPasienBatalPulang->namauser_otorisasi=$namaOtoritas;
//            $modPasienBatalPulang->iduser_otorisasi=$idOtoritas;
//            $modPasienBatalPulang->pasienpulang_id=$idPasienPulang;
//            $modPasienBatalPulang->tglpembatalan=date('Y-m-d H:i:s');
//             $modPasienBatalPulang->alasanpembatalan=$alasanPembatalan;
//             $transaction = Yii::app()->db->beginTransaction();
//             try{
//                if($modPasienBatalPulang->save()){
//                    $pulang = RIPasienPulangT::model()->updateByPk($idPasienPulang,array('pasienbatalpulang_id'=>$modPasienBatalPulang->pasienbatalpulang_id));
//                    $admisi = RIPasienAdmisiT::model()->updateByPk($pasienadmisi_id, array('pasienpulang_id'=>null));  
//                    if ($pulang && $admisi){
//                        $data['status'] = 'success';
//                        $transaction->commit();
//                    }
//                    else{
//                        throw new Exception("Update Data Gagal");
//                    }
//                }
//                else{
//                    Throw new Exception("Pasien Batal Pulang Gagal Disimpan");
//                }
//             }catch(Exception $ex){
//                 $transaction->rollback();
//                 $data['status'] = $ex;
//             }
//
//            echo json_encode($data);
//            Yii::app()->end();
//            }
//        }
        public function actionBatalPulang($pendaftaran_id)
        {
            $this->layout='//layouts/iframe';
            
             $modPendaftaran    = HDPendaftaranT::model()->findByPk($pendaftaran_id); 
             $modPasien         = PasienM::model()->findByPk($modPendaftaran->pasien_id);

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
             
             //$modPasienAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id), array('order'=>'tgladmisi DESC', 'limit'=>1));
             
            // $modPasienPulang   = PasienpulangT::model()->findByAttributes(array('pasienadmisi_id'=>$modPasienAdmisi->pasienadmisi_id));  
             $modPasienPulang   = PasienpulangT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));  
             
             $modPasienBatalPulang  = new PasienbatalpulangT;
             $modPasienBatalPulang->create_time             = date('Y-m-d H:i:s');
             $modPasienBatalPulang->update_time             = date('Y-m-d H:i:s');
             $modPasienBatalPulang->namauser_otorisasi      = Yii::app()->user->name;;
             $modPasienBatalPulang->iduser_otorisasi        = Yii::app()->user->id;
             $modPasienBatalPulang->create_loginpemakai_id  = Yii::app()->user->id;    
             $modPasienBatalPulang->update_loginpemakai_id  = Yii::app()->user->id;
             $modPasienBatalPulang->create_ruangan          = Yii::app()->user->getState('ruangan_id');
             $modPasienBatalPulang->pasienpulang_id         = $modPasienPulang->pasienpulang_id;
             
             $jenisPenyakit         = JeniskasuspenyakitM::model()->findByPk($modPendaftaran->jeniskasuspenyakit_id);
             $modPendaftaran->jeniskasuspenyakit_nama   = $jenisPenyakit->jeniskasuspenyakit_nama;
//             digunakan untuk merefresh jika data berhasil di simpan
             $tersimpan='Tidak';
             
             if(!empty($_POST['PasienbatalpulangT'])){
                 $format = new MyFormatter();
                 $modPasienBatalPulang->attributes = $_POST['PasienbatalpulangT'];
                 $modPasienBatalPulang->tglpembatalan = $format->formatDateTimeForDb($modPasienBatalPulang->tglpembatalan);
                 
                 if($modPasienBatalPulang->validate()){
                     $transaction = Yii::app()->db->beginTransaction();
                     try {
                         if($modPasienBatalPulang->save()){
                             $idPasienPulang = $modPasienBatalPulang->pasienpulang_id;
                            $pendaftaran_id = $_POST['pendaftaran_id'];
                             $pasienPulang = PasienPulangT::model()->updateByPk($idPasienPulang,array('pasienbatalpulang_id'=>$modPasienBatalPulang->pasienbatalpulang_id));
                           //  $pasienAdmisi = RIPasienAdmisiT::model()->updateByPk($pasienadmisi_id, array('pasienpulang_id'=>null));  
                             $modPendaftaran1 = HDPendaftaranT::model()->updateByPk($pendaftaran_id, array('pasienpulang_id'=>null));  
                             if($pasienPulang && $modPendaftaran1){
                                $transaction->commit();
                                HDPendaftaranT::model()->updateByPk(
                                    $pendaftaran_id,
                                    array(
                                        'statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA,
                                    )
                                );
                                // SMS GATEWAY
                                $sms = new Sms();
                                
                                foreach ($modSmsgateway as $i => $smsgateway) {
                                    $isiPesan = $smsgateway->templatesms;

                                    $attributes = $modPasien->getAttributes();
                                    foreach($attributes as $attributes => $value){
                                        $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                    }
                                    $attributes = $modPasienBatalPulang->getAttributes();
                                    foreach($attributes as $attributes => $value){
                                        $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                    }
                                
                                    $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modPasienBatalPulang->tglpembatalan),$isiPesan);
                                    
                                    if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                        if(!empty($modPasien->no_mobile_pasien)){
                                            $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                                        }else{
                                            $smspasien = 0;
                                        }
                                    }
                                }
                                // END SMS GATEWAY
                                Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                                $tersimpan='Ya';
                             } else {
                                 $transaction->rollback();
                                 Yii::app()->user->setFlash('error',"Data gagal disimpan");
                             }
                         }
                         else{
                             $transaction->rollback();
                             Yii::app()->user->setFlash('error',"Data gagal disimpan");
                         }
                     } catch (Exception $ex){
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan", MyExceptionMessage::getMessage($exc,true));
                     }
                 }                 
                 
             }
             
             $this->render('_formBatalPulang', array('modPendaftaran'=>$modPendaftaran, 
                                                     'modPasien'=>$modPasien, 
                                                     'modPasienBatalPulang'=>$modPasienBatalPulang, 
                                                     'smspasien'=>$smspasien,
                                                     //'modPasienAdmisi'=>$modPasienAdmisi,
                                                     'tersimpan'=>$tersimpan));
        }
        
        /**
         * Mengatur dropdown kabupaten
         * @param type $encode jika = true maka return array jika false maka set Dropdown 
         * @param type $model_nama
         * @param type $attr
         */
        public function actionSetDropDownKondisiKeluar($encode=false,$model_nama='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $model = new HDPasienPulangT;
                if($model_nama !=='' && $attr == ''){
                    $carakeluar_id = $_POST["$model_nama"]['carakeluar_id'];
                }
                 elseif ($model_nama == '' && $attr !== '') {
                    $carakeluar_id = $_POST["$attr"];
                }
                 elseif ($model_nama !== '' && $attr !== '') {
                    $carakeluar_id = $_POST["$model_nama"]["$attr"];
                }
                $kondisikeluar = null;
                if($carakeluar_id){
                    $kondisikeluar = $model->getKondisikeluarItems($carakeluar_id);
                    $kondisikeluar = CHtml::listData($kondisikeluar,'kondisikeluar_id','kondisikeluar_nama');
                }
                if($encode){
                    echo CJSON::encode($kondisikeluar);
                } else {
                    if(empty($kondisikeluar)){
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    } else {
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                        foreach($kondisikeluar as $value=>$name) {
                            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                    }
                }
            }
            Yii::app()->end();
        }
}