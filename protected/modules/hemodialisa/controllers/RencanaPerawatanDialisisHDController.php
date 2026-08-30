<?php

class RencanaPerawatanDialisisHDController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $path_view = 'hemodialisa.views.rencanaPerawatanDialisisHD.';
    public $path_view_riwayat = 'rawatJalan.views._periksaDataPasien.';
    public $ok = true;

    function actionIndex($pendaftaran_id, $pasienadmisi_id = null, $konsulpoli_id=null) {
        $modPendaftaran = HDPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        $modPasien = HDPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = new RencanaPerawatanDialisisT();
        $modAdmisi = HDPasienAdmisiT::model()->findByPk($pasienadmisi_id);
        $modRiwayatTerintegrasi = PerkembanganTerintegrasiPasienT::model()->findAll('pendaftaran_id = ' . $pendaftaran_id);
        $modRiwayatPerawatan = RencanaPerawatanDialisisT::model()->findAll('pendaftaran_id = ' . $pendaftaran_id);
//        print_r($modRiwayatPerawatan);die;
        $perkembanganterintegrasi = isset($_GET['perkembangan_terintegrasi_pasien_id']) ? $_GET['perkembangan_terintegrasi_pasien_id'] : null;
        $id = isset($_GET['rencana_perawatan_dialisis_id']) ? $_GET['rencana_perawatan_dialisis_id'] : null;
        $salin = isset($_GET['salin']) ? $_GET['salin'] : null;
        if (!empty($perkembanganterintegrasi)) {
            $modPerkembanganTerintegrasi = PerkembanganTerintegrasiPasienT::model()->findByPk($perkembanganterintegrasi);
            $model->perencanaan = $modPerkembanganTerintegrasi->perencanaan;
            $model->instruksi = $modPerkembanganTerintegrasi->instruksi;
        }

        if (!empty($id)) {
            $model = RencanaPerawatanDialisisT::model()->findByPk($id);
            $model->nama_pegawai = $model->pegawai->nama_pegawai;
        }

        if (isset($_POST['RencanaPerawatanDialisisT'])) {
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if (!empty($id) && empty($salin)) {
                    $model = RencanaPerawatanDialisisT::model()->findByPk($id);
                    $model->update_time = date('Y-m-d');
                    $model->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                } else {
                    $model = new RencanaPerawatanDialisisT();
                }
                $model->attributes = $_POST['RencanaPerawatanDialisisT'];
                $model->waktu_dialisis_pertama = MyFormatter::formatDateTimeForDb($_POST['RencanaPerawatanDialisisT']['waktu_dialisis_pertama']);
                $model->pasien_id = $modPendaftaran->pasien_id;
                $model->pendaftaran_id = $pendaftaran_id;
                $model->create_time = date('Y-m-d');
                $model->creale_login = Yii::app()->user->getState('pegawai_id');
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

                $ok = $ok && $model->save();

                // Update status periksa 
                $this->ubah_status($pendaftaran_id, $konsulpoli_id);
//                    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
//                    if ($modPendaftaran->instalasi_id == Params::INSTALASI_ID_HEMODIALISAGRAHA || $modPendaftaran->instalasi_id == Params::INSTALASI_ID_HEMODIALISA) {
//                        $modKonsul = KonsulpoliT::model()->findByAttributes(['pendaftaran_id' => $modPendaftaran->pendaftaran_id]);
//                        if (!empty($modKonsul)) {
//                            $modKonsul->statusperiksa = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
//                            $modKonsul->update_time = date("Y-m-d H:i:s");
//                            $modKonsul->update_loginpemakai_id = Yii::app()->user->id;
//                            $this->ok = $this->ok && $modKonsul->save();
//                        } else {
//                            $modPendaftaran->status_hd = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
//                            $modPendaftaran->update_time = date("Y-m-d H:i:s");
//                            $modPendaftaran->update_loginpemakai_id = Yii::app()->user->id;
//                            $this->ok = $this->ok && $modPendaftaran->save();
//                        }
//                    }

                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                    $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1,'konsulpoli_id'=>$konsulpoli_id));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modAdmisi' => $modAdmisi,
            'modRiwayatTerintegrasi' => $modRiwayatTerintegrasi,
            'modRiwayatPerawatan' => $modRiwayatPerawatan
        ));
    }
    
    public function ubah_status($pendaftaran_id, $konsulpoli_id){
        $pen = PendaftaranT::model()->findByPk($pendaftaran_id);
        $pen->status_hd = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
        $pen->update_time = date('Y-m-d H:i:s');
        $pen->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $pen->save();
        
        $konsul = KonsulpoliT::model()->findByPk($konsulpoli_id);
        
        if (!empty($konsul)){            
            if (in_array($konsul->poliasal->instalasi_id, RuanganrawatinapV::loadInstalasi())){
                $konsul->statusperiksa = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
                $konsul->update_time = date('Y-m-d H:i:s');
                $konsul->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $konsul->save();
            }
        }                
    }

    public function actionHapusRiwayatPerawatan() {
        if (Yii::app()->request->isAjaxRequest) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            $id = $_POST['id'];
            try {
                $ok = $ok && RencanaPerawatanDialisisT::model()->deleteByPk($id);
                if ($ok) {
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Data Berhasil dihapus!';
                    $trans->commit();
                } else {
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

    /**
     * 
     * @param type $id
     */
    public function actionPrint($id) {
        $this->layout = '//layouts/printWindows';
        $this->layout = '//layouts/_auto';
        $format = new MyFormatter;         
        
        $model = RencanaPerawatanDialisisT::model()->findByAttributes([
            'rencana_perawatan_dialisis_id' => $id
        ]);
              
        $no_dok = 'RM 05cHD';
        $view = 'print_emr';
            
        $judullaporan = 'RENCANA PERAWATAN DIALISIS';
        $alias = 'DIALYSIS PLAN OF CARE';
        
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
