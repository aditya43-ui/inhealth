<?php

class InformedtoConsentTHDController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $path_view = 'hemodialisa.views.informedtoConsentTHD.';

    public function actionIndex($pendaftaran_id, $informtoconsent_hd_id = null, $salin = null) {
        $this->layout = '//layouts/iframe';
        $modPendaftaran = HDPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = HDPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = new HDInformtoconsentHdT();
        $model->waktu = date('d-m-Y H:i:s');
        $model->dokteri_id = $modPendaftaran->pegawai_id;
        $model->dokter_nama = $modPendaftaran->pegawai->nama_pegawai;

        if (!empty($informtoconsent_hd_id)) {
            $model = HDInformtoconsentHdT::model()->findByPk($informtoconsent_hd_id);
            $model->hd = ($model->f_hd == true) ? 'fhd' : 'ghd';
            $model->dokter_nama = $model->dokteri->nama_pegawai;
            $model->update_time = date('Y-m-d');
            $model->update_loginpemakai_id = Yii::app()->user->id;

            if (isset($_POST['HDInformtoconsentHdT'])) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if (!empty($salin)) {
                        $model = new HDInformtoconsentHdT();
                        $model->create_time = date('Y-m-d');
                        $model->create_loginpemakai_id = Yii::app()->user->id;
                    }
                    
                    $model->attributes = $_POST['HDInformtoconsentHdT'];
                    $model->pendaftaran_id = $pendaftaran_id;
                    $model->pasien_id = $modPasien->pasien_id;
                    $model->f_hd = $_POST['HDInformtoconsentHdT']['hd'] == 'fhd' ? true : 0;
                    $model->g_hd = $_POST['HDInformtoconsentHdT']['hd'] == 'ghd' ? true : 0;
                    $model->waktu = MyFormatter::formatDateTimeForDb($_POST['HDInformtoconsentHdT']['waktu']);

                    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

                    if ($model->save()) {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                        $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1));
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                    }
                } catch (Exception $ex) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
                }
            }
        }

        if (isset($_POST['HDInformtoconsentHdT'])) {
            $ok = true;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['HDInformtoconsentHdT'];
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $modPasien->pasien_id;
                $model->f_hd = isset($_POST['HDInformtoconsentHdT']['hd']) ? $_POST['HDInformtoconsentHdT']['hd'] == 'fhd' ? true : 0 : true;
                $model->g_hd = isset($_POST['HDInformtoconsentHdT']['hd']) ? $_POST['HDInformtoconsentHdT']['hd'] == 'ghd' ? true : 0 : 0;
                $model->waktu = MyFormatter::formatDateTimeForDb($_POST['HDInformtoconsentHdT']['waktu']);
                $model->create_time = date('Y-m-d');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                if ($model->save()) {
                    $ok &= $model->save();
                } else {
                    $ok &= false;
                }
                
                $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
                $ins_h = RuanganhemodialisaV::arrIns();
                if (in_array($modPendaftaran->instalasi_id, $ins_h)) {
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
                
                if ($ok) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                    $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {                
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $crit = new CDbCriteria();
        $crit->addCondition("pendaftaran_id = " . $pendaftaran_id);
        $loadRiwayat = HDInformtoconsentHdT::model()->findAll($crit);

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'loadRiwayat' => $loadRiwayat
        ));
    }

    public function actionAutoCompleteDokter() {
        if (Yii::app()->request->isAjaxRequest) {
            $term = $_GET['term'];
            $criteria = new CDbCriteria();
            $criteria->addCondition("nama_pegawai ILIKE '%" . $term . "%'");
            $criteria->addCondition("kelompokpegawai_id = 1");
            $criteria->addCondition("ruangan_id = " . Yii::app()->user->getState('ruangan_id'));
            $criteria->addCondition('pegawai_aktif = true');
            $models = PegawairuanganV::model()->findAll($criteria);
            $returnVal = array();
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();

                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nama_pegawai;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionHapusInformed() {
        if (Yii::app()->request->isAjaxRequest) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            $id = $_POST['id'];
            try {
                $ok = $ok && HDInformtoconsentHdT::model()->deleteByPk($id);
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
     * digunakan untuk memanggil prinout data
     * @param type $hasilpemeriksaan_id
     */
    public function actionPrintInformed($informtoconsent_hd_id) {
        
        $this->layout = '//layouts/_auto';
        $format = new MyFormatter;         
        
        $model = HDInformtoconsentHdT::model()->findByAttributes([
            'informtoconsent_hd_id' => $informtoconsent_hd_id
        ]);
              
        if ($model->f_hd){
            $view = '_print_8f_hd';
            $no_dok = 'RM 08f HD';
        }else{
            $view = '_print_8g_hd';
            $no_dok = 'RM 08g HD';
        }
        
        
        $judullaporan = 'PERNYATAAN PEMBERIAN INFORMASITINDAKAN KEDOKTERAN';        
        $alias = '(INFORMED TO CONSENT)';
        
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
        $mpdf = new MyPDF60('', $ukuranKertasPDF['A4']);        
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
        $mpdf->Output(str_replace(' ', '_',$judullaporan.$no_dok) . '-' . date("Y/m/d") . '.pdf', 'I');
    }

}
