<?php

class ObservasiTransfusiDarahTHDController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $path_view = 'hemodialisa.views.observasiTransfusiDarahTHD.';
    public $ok = true;

    /**
     * Halaman index Observasi 
     * @param type $pendaftaran_id
     * @param type $observasitransfusidarahid
     */
    public function actionIndex($pendaftaran_id, $kantong_transfusi_darah_id = null, $konsulpoli_id=null) {
        $this->layout = '//layouts/iframe';        
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);        
        $model = new HDObservasiTransfusiDarahT();        
        
        $salin_id = isset($_GET['salin_id']) ? $_GET['salin_id'] : null;
        $modLoad = [];

        if (!empty($kantong_transfusi_darah_id)) {
            $cri = new CDbCriteria();
            $cri->select = "t.*, b.no_kantongdarah";
            $cri->join = "JOIN kantong_transfusi_darah_det_t b ON b.kantong_transfusi_darah_det_id = t.kantong_transfusi_darah_det_id";
            $cri->addCondition('b.kantong_transfusi_darah_id = ' . $kantong_transfusi_darah_id);
            $modLoad = HDObservasiTransfusiDarahT::model()->findAll($cri);
        }

        if (isset($_POST['HDObservasiTransfusiDarahT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if (!empty($kantongdarahdetid)) {
                    if (!empty($salin_id)) {
                        $this->saveObservasiTransfusi($model, $_POST['HDObservasiTransfusiDarahT'], $modPendaftaran);
                    } else {
                        $crite = new CDbCriteria();
                        $crite->addCondition('kantong_transfusi_darah_det_id = ' . $kantongdarahdetid);
                        $dataObservasi = HDObservasiTransfusiDarahT::model()->findAll($crite);
                        foreach ($dataObservasi as $data) {
                            $cekreaksi = ReaksiTransfusiT::model()->find("observasi_transfusi_darah_id = " . $data->observasi_transfusi_darah_id);
                            if (!empty($cekreaksi)) {
                                $this->ok = $this->ok && ReaksiTransfusiT::model()->deleteAll("observasi_transfusi_darah_id = " . $data->observasi_transfusi_darah_id);
                            }
                        }
                        $this->ok = $this->ok && HDObservasiTransfusiDarahT::model()->deleteAll('kantong_transfusi_darah_det_id = ' . $kantongdarahdetid);
                        $this->saveObservasiTransfusi($model, $_POST['HDObservasiTransfusiDarahT'], $modPendaftaran);
//                        $this->updateObservasiTransfusi($model, $_POST['HDObservasiTransfusiDarahT'], $modPendaftaran, $observasitransfusidarahid);
                    }
                } else {
                    $this->saveObservasiTransfusi($model, $_POST['HDObservasiTransfusiDarahT'], $modPendaftaran);
                }
                // Update status periksa 
//                $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
//                if ($modPendaftaran->instalasi_id == Params::INSTALASI_ID_HEMODIALISAGRAHA || $modPendaftaran->instalasi_id == Params::INSTALASI_ID_HEMODIALISA) {
//                    $modKonsul = KonsulpoliT::model()->findByAttributes(['pendaftaran_id' => $modPendaftaran->pendaftaran_id]);
//                    if (!empty($modKonsul)) {
//                        $modKonsul->statusperiksa = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
//                        $modKonsul->update_time = date("Y-m-d H:i:s");
//                        $modKonsul->update_loginpemakai_id = Yii::app()->user->id;
//                        $modKonsul->save();
//                    } else {
//                        $modPendaftaran->status_hd = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
//                        $modPendaftaran->update_time = date("Y-m-d H:i:s");
//                        $modPendaftaran->update_loginpemakai_id = Yii::app()->user->id;
//                        $modPendaftaran->save();
//                    }
//                }
                $this->ubah_status($pendaftaran_id, $konsulpoli_id);

                if ($this->ok == true) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                    $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1, 'konsulpoli_id'=>$konsulpoli_id));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                }
            } catch (Exception $ex) {
                var_dump($ex->getMessage());die;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $crit = new CDbCriteria();
        $crit->select = [
            'p.tgl_pendaftaran',
            'p.no_pendaftaran',
            'kan_det.no_kantongdarah',
            'kan.kantong_transfusi_darah_id'
        ];
        $crit->join = " JOIN kantong_transfusi_darah_det_t kan_det ON kan_det.kantong_transfusi_darah_det_id = t.kantong_transfusi_darah_det_id "
                    . " JOIN kantong_transfusi_darah_t kan ON kan.kantong_transfusi_darah_id = kan_det.kantong_transfusi_darah_id "
                    . " JOIN pendaftaran_t p ON p.pendaftaran_id = t.pendaftaran_id ";        
        $crit->addCondition("t.pendaftaran_id = " . $pendaftaran_id);        
        $crit->order = " t.create_time DESC ";
        $obs = HDObservasiTransfusiDarahT::model()->findAll($crit);
        
        $loadRiwayat = [];
        if (!empty($obs)){
            foreach($obs as $det){
                $init = $det->kantong_transfusi_darah_id;
                if (!isset($loadRiwayat[$init])){
                    $loadRiwayat[$init] = [
                        'tgl_pendaftaran' => $det->tgl_pendaftaran,
                        'no_pendaftaran' => $det->no_pendaftaran,
                        'kantong_transfusi_darah_id' => $det->kantong_transfusi_darah_id
                    ];
                }
                
                $loadRiwayat[$init]['kantong'][$det->no_kantongdarah] = $det->no_kantongdarah;
            }
        }

        $this->render('index', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'loadRiwayat' => $loadRiwayat,
            'modLoad' => $modLoad
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

    public function saveObservasiTransfusi($model, $post, $modPendaftaran) {
        foreach ($post as $i => $value) {
            $model = new HDObservasiTransfusiDarahT();
            $model->attributes = $value;
            $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $model->pasien_id = $modPendaftaran->pasien_id;
            $model->tanggal_observasi = !empty($value['tanggal_observasi']) ? MyFormatter::formatDateTimeForDb($value['tanggal_observasi']) : null;
            $model->jam_observasi = !empty($value['jam_observasi']) ? $value['jam_observasi'] : null;
            $model->create_time = date('Y-m-d');
            $model->creale_login = Yii::app()->user->id;
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

            if ($model->save()) {
                if (!empty($value['reaksi_transfusi'])) {
                    $reaksi = explode("-", $value['reaksi_transfusi']);
                    foreach ($reaksi as $index => $rks) {
                        if (!empty($rks)) {
                            $modReaksi = new ReaksiTransfusiT();
                            $modReaksi->observasi_transfusi_darah_id = $model->observasi_transfusi_darah_id;
                            $modReaksi->pasien_id = $modPendaftaran->pasien_id;
                            $modReaksi->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                            $modReaksi->nama_reaksi_transfusi = $rks;

                            if ($modReaksi->save()) {
                                $this->ok = true;
                            } else {
                                $this->ok = false;
                            }
                        }
                    }
                } else {
                    $this->ok = true;
                }
            } else {
                $this->ok = false;
            }
        }
    }

    public function updateObservasiTransfusi($model, $post, $modPendaftaran, $id) {
        $model = HDObservasiTransfusiDarahT::model()->findByPk($id);
        $model->attributes = $post[1];
        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasien_id = $modPendaftaran->pasien_id;
        $model->tanggal_observasi = MyFormatter::formatDateTimeForDb($post[1]['tanggal_observasi']);
        $model->update_time = date('Y-m-d');
        $model->update_loginpemakai_id = Yii::app()->user->id;

        if ($model->update()) {
            if (!empty($post[1]['reaksi_transfusi'])) {
                $ok = true;
                $hapusReaksi = ReaksiTransfusiT::model()->find("observasi_transfusi_darah_id = " . $id);
                if (!empty($hapusReaksi)) {
                    $ok = $ok && ReaksiTransfusiT::model()->deleteAll("observasi_transfusi_darah_id = " . $id);
                }
                $reaksi = explode("-", $post[1]['reaksi_transfusi']);
                foreach ($reaksi as $index => $rks) {
                    if (!empty($rks)) {
                        $modReaksi = new ReaksiTransfusiT();
                        $modReaksi->observasi_transfusi_darah_id = $model->observasi_transfusi_darah_id;
                        $modReaksi->pasien_id = $modPendaftaran->pasien_id;
                        $modReaksi->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                        $modReaksi->nama_reaksi_transfusi = $rks;

                        if ($modReaksi->save()) {
                            $this->ok = true;
                        } else {
                            $this->ok = false;
                        }
                    }
                }
            } else {
                $this->ok = true;
            }
        } else {
            $this->ok = false;
        }
    }

    public function actionHapusRiwayat() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = $_POST['id'];
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $crite = new CDbCriteria();
                $crite->addCondition('kantong_transfusi_darah_det_id = ' . $id);
                $dataObservasi = HDObservasiTransfusiDarahT::model()->findAll($crite);
                foreach ($dataObservasi as $dt) {
                    $cekreaksi = ReaksiTransfusiT::model()->find("observasi_transfusi_darah_id = " . $dt->observasi_transfusi_darah_id);
                    if (!empty($cekreaksi)) {
                        $ok = $ok && ReaksiTransfusiT::model()->deleteAll("observasi_transfusi_darah_id = " . $dt->observasi_transfusi_darah_id);
                    }
                }
                
                $ok = $ok && HDObservasiTransfusiDarahT::model()->deleteAll('kantong_transfusi_darah_det_id = ' . $id);

                if ($ok) {
                    $data['sukses'] = 1;
                    $data['pesan'] = "Data Berhasil Dihapus!";
                    $trans->commit();
                } else {
                    $data['sukses'] = 0;
                    $data['pesan'] = "Data Gagal Dihapus";
                    $trans->rollback();
                }
            } catch (Exception $ex) {
                $data['sukses'] = 0;
                $data['pesan'] = "Data Gagal Dihapus";
                $trans->rollback();
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionAddReaksi() {
        if (Yii::app()->request->isAjaxRequest) {
            $reaksi_transfusi = $_POST['reaksi_transfusi'];
            $key = $_POST['key'];
            $form = "";

            $form .= $this->renderPartial('_addReaksi', array('reaksi_transfusi' => $reaksi_transfusi, 'key' => $key), true);

            echo CJSON::encode(array('form' => $form));
            Yii::app()->end();
        }
    }

    public function actionAddObservasiTransfusi() {
        if (Yii::app()->request->isAjaxRequest) {
            $form = "";
            $key = $_POST['key'];

            $model = new HDObservasiTransfusiDarahT();
            $model->petugas_observasi_id = (isset($_POST['petugas_observasi_id'])) ? $_POST['petugas_observasi_id'] : "";
            $model->petugas_observasi_nama = (isset($_POST['petugas_observasi_nama'])) ? $_POST['petugas_observasi_nama'] : "";
            if (!empty($_POST['kantongdarahid'])) {
                $kantongdarahdet = KantongTransfusiDarahDetT::model()->findByPk($_POST['kantongdarahid']);
                $kantongid = $_POST['kantongdarahid'];
                $kantongno = $kantongdarahdet->no_kantongdarah;
            } else {
                $kantongid = "";
                $kantongno = "";
            }
            $model->kantong_transfusi_darah_det_id = $kantongid;
            $model->kantong_transfusi_darah_det_no = $kantongno;
            $model->reaksi_transfusi = (isset($_POST['reaksi_transfusi'])) ? $_POST['reaksi_transfusi'] : "";
            $model->tanggal_observasi = (isset($_POST['tanggal_observasi'])) ? $_POST['tanggal_observasi'] : "";
            $model->jam_observasi = (isset($_POST['jam_observasi'])) ? $_POST['jam_observasi'] : "";
            $model->keluhan = (isset($_POST['keluhan'])) ? $_POST['keluhan'] : "";
            $model->kesadaran = (isset($_POST['kesadaran'])) ? $_POST['kesadaran'] : "";
            $model->tensi_sistolik = (isset($_POST['tensi_sistolik'])) ? $_POST['tensi_sistolik'] : "";
            $model->tensi_diatolik = (isset($_POST['tensi_diatolik'])) ? $_POST['tensi_diatolik'] : "";
            $model->nadi = (isset($_POST['nadi'])) ? $_POST['nadi'] : "";
            $model->suhu = (isset($_POST['suhu'])) ? $_POST['suhu'] : "";
            $model->pernapasan = (isset($_POST['pernapasan'])) ? $_POST['pernapasan'] : "";
            $model->lainnya = (isset($_POST['lainnya'])) ? $_POST['lainnya'] : "";

            $form .= $this->renderPartial('_addObservasiTransfusi', array('model' => $model, 'key' => $key), true);

            echo CJSON::encode(array('form' => $form));
            Yii::app()->end();
        }
    }

    public function actionAutoCompletePetugasObservasi() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->compare("pegawai_aktif", true);
            $criteria->addCondition("ruangan_id = " . Yii::app()->user->getState('ruangan_id'));
            $models = PegawairuanganV::model()->findAll($criteria);
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

    public function actionPrintRiwayat($kantong_transfusi_darah_id, $id) {
        $this->layout = '//layouts/_auto';
        $format = new MyFormatter;         
        
        $modKantong = KantongTransfusiDarahT::model()->findByPk($kantong_transfusi_darah_id);
        $modKantong->set_obat_sebelum_transfusi = $modKantong->loadObatSebelumTransfusi();
        
        $model = KantongTransfusiDarahDetT::model()->findByAttributes([
            'kantong_transfusi_darah_id' => $kantong_transfusi_darah_id
        ]);
        $model->set_observasi_dan_kantong_darah = $model->loadObservasiDanKantongDarah();                
                
        
        $no_dok = 'RM 081 K';
        $view = 'print/index';
            
        $judullaporan = 'OBSERVASI TRANSFUSI DARAH';
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
        $posisi = 'L';  
        $mpdf->AddPage($posisi, '', '', '', '', 10, 10, 10, 10, 10, 10);
        $mpdf->WriteHTML( $this->renderPartial($view, array(
            'format' => $format,
            'model' => $model,
            'modKantong' => $modKantong,
            'judullaporan' => $judullaporan,
            'data' => $data,        
        ),true));
        $mpdf->Output($judullaporan . '-' . date("Y/m/d") . '.pdf', 'I');
    }

    public function actionDetail($pendaftaran_id, $tranfusi_id, $kantongdarahdetid) {
        $this->layout = '//layouts/iframe';
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modKantong = KantongTransfusiDarahT::model()->findByPk($tranfusi_id);
        $modDetail = KantongTransfusiDarahDetT::model()->findByPk($kantongdarahdetid);
        
        $this->render($this->path_view . 'detail', [
            'modPendaftaran' => $modPendaftaran,
            'modKantong' => $modKantong,
            'modDetail' => $modDetail,
        
        ]);
    }
    
    public function actionDetailRow($id){
        $this->layout = '//layouts/iframe';
        $modDet = KantongTransfusiDarahDetT::model()->findByPk($id);
        $modKantong = KantongTransfusiDarahT::model()->findByPk($modDet->kantong_transfusi_darah_id);

        $cri = new CDbCriteria();
        $cri->select = "t.*, b.no_kantongdarah";
        $cri->join = "JOIN kantong_transfusi_darah_det_t b ON b.kantong_transfusi_darah_det_id = t.kantong_transfusi_darah_det_id";
        $cri->addCondition('t.kantong_transfusi_darah_det_id = ' . $modDet->kantong_transfusi_darah_det_id);
        $modLoad = HDObservasiTransfusiDarahT::model()->findAll($cri);

        $this->render($this->path_view . '_detailObservasi', [
            'modDet' => $modDet,
            'modLoad' => $modLoad,
            'modKantong' => $modKantong, 
        ]);
        
    }

}
