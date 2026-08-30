<?php

class PrescriptionTHDController extends MyAuthController{
    
    public $layout = '//layouts/column1';
    public $path_view = 'hemodialisa.views.prescriptionTHD.';
    
    public function actionIndex($pendaftaran_id, $prescription_id=null, $salin_id=null){
        $this->layout = '//layouts/iframe';
        $modPendaftaran = HDPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = HDPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $aksesvaskular = AksesVaskularT::model()->findAll("pendaftaran_id = ".$pendaftaran_id);
        
        $new_pres = false;
        if (!empty($prescription_id)){
            $model = HDPrescriptionHdT::model()->findByPk($prescription_id);            
        }elseif (!empty($salin_id)){
            $model = HDPrescriptionHdT::model()->findByPk($salin_id);            
        }else{            
            $new_pres = true;
            $model = HDPrescriptionHdT::model()->find("pasien_id = ".$modPendaftaran->pasien_id.' ORDER BY pendaftaran_id DESC, create_time DESC, prescription_hd_id DESC');               
        }
        
        if(!empty($model->prescription_hd_id)){            
            if($model->prescription_dokter_akut == true){
                $pres = 'akut';
            }elseif ($model->prescription_dokter_kronis == true) {
                $pres = 'kronis';
            }elseif ($model->prescription_dokter_pirrt == true){
                $pres='pirrt';
            }else{
                $pres='';
            }

            $model->prescription_dokter = $pres;
            $model->dpjp_nama = !empty($model->dpjp->namaLengkap)?$model->dpjp->namaLengkap:null;
            
            if ($new_pres){
                unset($model->prescription_hd_id);
                $model->isNewRecord = true;    
            }
        }else{
            $model = new HDPrescriptionHdT;
            $model->waktu_prescription = date('d/m/Y H:i:s');
            $model->dpjp_id = $modPendaftaran->pegawai_id;
            $model->dpjp_nama = $modPendaftaran->pegawai->nama_pegawai;
                        
            $akses = "";
            if(count($aksesvaskular)>0){
                foreach ($aksesvaskular as $av){
                    $init = '';
                    if (!empty($av->hd_kateter)){
                        $init = ' - '.$av->hd_kateter;                    
                    }
                    $akses .= $av->nama_akses_vaskular.$init.", ";
                }                            
            }
            
            $model->akses_vaskular = $akses;
        }               
        
        if(isset($_POST['HDPrescriptionHdT'])){
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $model->attributes = $_POST['HDPrescriptionHdT'];
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pegawai_id = $modPendaftaran->pegawai_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->waktu_prescription = MyFormatter::formatDateTimeForDb($_POST['HDPrescriptionHdT']['waktu_prescription']);
                if(isset($_POST['HDPrescriptionHdT']['prescription_dokter'])){
                    if($_POST['HDPrescriptionHdT']['prescription_dokter'] == 'akut'){
                        $model->prescription_dokter_akut = true;
                        $model->prescription_dokter_kronis = 0;
                        $model->prescription_dokter_pirrt = 0;
                    }elseif($_POST['HDPrescriptionHdT']['prescription_dokter'] == 'kronis'){
                        $model->prescription_dokter_akut = 0;
                        $model->prescription_dokter_kronis = true;
                        $model->prescription_dokter_pirrt = 0;
                    }elseif($_POST['HDPrescriptionHdT']['prescription_dokter'] == 'pirrt'){
                        $model->prescription_dokter_akut = 0;
                        $model->prescription_dokter_kronis = 0;
                        $model->prescription_dokter_pirrt = true;
                    }
                }else{
                    $model->prescription_dokter_akut = 0;
                    $model->prescription_dokter_kronis = 0;
                    $model->prescription_dokter_pirrt = true;
                }
                
                if(isset($_POST['aksesvaskular'])){
                    $akvas = "";
                    foreach ($_POST['aksesvaskular'] as $key=>$value){
                        $akvas .= $value.",";
                    }
                    $model->akses_vaskular = $akvas;
                }
                
                if (!empty($salin_id)){
                    unset($model->prescription_hd_id);
                    $model->isNewRecord = true;                    
                }
                
                $new = false;
                if (empty($model->prescription_hd_id)){
                    $model->create_time = date('Y-m-d');
                    $model->create_loginpmakai_id = Yii::app()->user->id;
                    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                    $new = true;
                }else{
                    $model->update_time = date('Y-m-d');
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                }
                                                                
                $ok &= $model->save();
                       
                if ($new){
                    if ($modPendaftaran->instalasi_id == ParamsConst::INSTALASI_ID_HEMODIALISA) {
                        $modKonsul = KonsulpoliT::model()->findByAttributes(['pendaftaran_id' => $modPendaftaran->pendaftaran_id]);
                        if (!empty($modKonsul)) {
                            $modKonsul->update_time = date("Y-m-d h:i:s");
                            $modKonsul->statusperiksa = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
                            $ok = $ok&& $modKonsul->save(); 
                        } else {
                            $modPendaftaran->update_time = date("Y-m-d h:i:s");
                            $modPendaftaran->status_hd = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
                            $ok = $ok && $modPendaftaran->save(); 
                        }
                    }
                }
                
                if($ok){
                    $transaction->commit();
                    Yii::app()->user->setFlash('success',"Data Resep berhasil disimpan");
                    $this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id, 'sukses'=>1));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".CHtml::errorSummary($model));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
            
        }
        
        $cri = new CDbCriteria();
        $cri->addCondition("pendaftaran_id = ".$pendaftaran_id);
        $loadRiwayat = HDPrescriptionHdT::model()->findAll($cri);
        
        $this->render($this->path_view.'index', array(
           'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'aksesvaskular'=>$aksesvaskular,
            'loadRiwayat'=>$loadRiwayat
        ));
    }
    
    public function actionHapusPrescription(){
        if(Yii::app()->request->isAjaxRequest){
            $ok=true;
            $trans = Yii::app()->db->beginTransaction();
            $id = $_POST['id'];
            try{
                $ok = $ok && HDPrescriptionHdT::model()->deleteByPk($id);
                if($ok){
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Data Berhasil dihapus!';
                    $trans->commit();
                }else{
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Data Gagal dihapus!';
                    $trans->rollback();
                }
            } catch (Exception $ex) {
                $data['sukses'] = 0;
                $data['pesan'] = 'Data Gagal dihapus!';
                $trans->rollback();
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    public function actionPrintPrescription(){
        $this->layout = '//layouts/_auto';
        $format = new MyFormatter;         
        
        $model = HDPrescriptionHdT::model()->findByPk($_GET['prescriptionid']);
        
        $no_dok = '';
        $view = $this->path_view.'print/index';
            
        $judullaporan = '';
        $alias = '';
        
        $pasien = $model->pasien;
        
        $data = [
            'judul_laporan' => $judullaporan,
            'no_dok' => $no_dok,
            'alias' => $alias,
            'nama_lengkap' => $pasien->nama_pasien,
            'no_rm' => $pasien->no_rekam_medik,
            'tanggal_lahir' => date('d/m/Y', strtotime($pasien->tanggal_lahir)),
        ];
                      
        $ukuranKertasPDF = Params::getUkuranKertas();
        $mpdf = new MyPDF('', $ukuranKertasPDF['A4']);
        $mpdf->useOddEven = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/global-prinout-pdf.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $posisi = Yii::app()->user->getState('posisi_kertas');  
        $mpdf->AddPage($posisi, '', '', '', '', 10, 10, 10, 10, 10, 10);
        $mpdf->WriteHTML( $this->renderPartial($view, array(
            'format' => $format,
            'model' => $model,           
            'judullaporan' => $judullaporan,
            'data' => $data,        
        ),true));
        $mpdf->Output($judullaporan . '-' . date("Y/m/d") . '.pdf', 'I');
    }
    
}
