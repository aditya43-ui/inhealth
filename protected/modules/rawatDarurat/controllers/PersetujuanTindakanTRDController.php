<?php

//Yii::import('perawatanIntensif.controllers.PersetujuanTindakanTPIController');
//Yii::import('perawatanIntensif.models.*');
class PersetujuanTindakanTRDController extends MyAuthController {

//    public $layout='//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'rawatDarurat.views.persetujuanTindakanTRD.';

    public function actionIndex($pendaftaran_id = null, $frame = 0) {
        $format = new MyFormatter();

        if ($frame == 1) {
            $this->layout = '//layouts/iframe';
        }


        if (!empty($_GET['suratpersetujuantm_id'])) {
            $modSuratPersetujuan = SuratpersetujuantmT::model()->findByPk($_GET['suratpersetujuantm_id']);
            if ($modSuratPersetujuan->jenissurat != Params::SURAT_PERSETUJUAN_PERSETUJUAN) {
                throw new CHttpException(404, "Surat Persetujuan tidak ditemukan");
            }
        } else {
            $modSuratPersetujuan = new SuratpersetujuantmT();
            $modSuratPersetujuan->jeniskelamin_menyetujui = Params::JENIS_KELAMIN_LAKI_LAKI;
            $modSuratPersetujuan->jenissurat = Params::SURAT_PERSETUJUAN_PERSETUJUAN;
        }
        $data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        $informasi = new PemberianinformasiT;

        if (!empty($pendaftaran_id)) {
            if (!isset($_GET['suratpersetujuantm_id']) && !Yii::app()->request->isPostRequest) {
                $this->setReferrer();
            }

            $modTindakanAnestesi = TindakanpelayananT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')));
            $modObatAlkesAnestesi = ObatalkespasienT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')));
            $modPasienAnestesi = array();
            $modPraAnestesi = array();
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
//                        $modKunjungan = new PIInformasipasienanestesiV();
        } else {
            $this->cleanReferrer();
        }
        
        
        if (!empty($modSuratPersetujuan) && !$modSuratPersetujuan->isNewRecord) {
            $informasi = PemberianinformasiT::model()->findByAttributes(array(
                'suratpersetujuantm_id'=>$modSuratPersetujuan->suratpersetujuantm_id
            ));
        }
        
//                else{
//			$modKunjungan = new PIInformasipasienanestesiV();
//		}

        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

        if (isset($_POST['SuratpersetujuantmT'])) {
//            $pasienanastesi_id = isset($_GET['pasienanastesi_id']) ? $_GET['pasienanastesi_id'] : null;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $tindakan = '';
                if (!empty($_POST['tindakan'])) {
                    foreach ($_POST['tindakan'] as $key => $val) {
                        $tindakan .= $val . '::: ';
                    }
                }

                $obat = '';
                if (!empty($_POST['obat'])) {
                    foreach ($_POST['obat'] as $keyObat => $valObat) {
                        $obat .= $valObat . '::: ';
                    }
                }


                $modSuratPersetujuan = new SuratpersetujuantmT();
                $modSuratPersetujuan->attributes = $_POST['SuratpersetujuantmT'];
//                $pasienanastesi_id = null;
//                $modSuratPersetujuan->pasienanastesi_id= $pendaftaran_id;
                $modSuratPersetujuan->pasienanastesi_id = null; //RSPMC-873
                $modSuratPersetujuan->pendaftaran_id = $pendaftaran_id;
                $modSuratPersetujuan->tindakanmedis = $tindakan;
                $modSuratPersetujuan->obatalkes = $obat;

                $modSuratPersetujuan->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $modSuratPersetujuan->tglpersetujuan = date('Y-m-d H:i:s');
                $modSuratPersetujuan->nopersetujuan = MyGenerator::noPersetujuan();
                $modSuratPersetujuan->create_time = date('Y-m-d');
                $modSuratPersetujuan->update_time = date('Y-m-d');
                $modSuratPersetujuan->create_loginpemakai_id = Yii::app()->user->id;
                $modSuratPersetujuan->update_loginpemakai_id = Yii::app()->user->id;
                $modSuratPersetujuan->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $modSuratPersetujuan->jenissurat = Params::SURAT_PERSETUJUAN_PERSETUJUAN;
                $modSuratPersetujuan->tindakanterhadap = isset($_POST['hubungankeluarga']) ? $_POST['hubungankeluarga'] : "-";

                if (isset($_POST['PemberianinformasiT']['daftartindakan_id'])) {
                    $t = DaftartindakanM::model()->findByPk($_POST['PemberianinformasiT']['daftartindakan_id']);
                    $modSuratPersetujuan->tindakanmedis = !empty($t->daftartindakan_nama) ? $t->daftartindakan_nama : '-';
                }
                
                
                // var_dump($modSuratPersetujuan->validate(), $modSuratPersetujuan->errors, $modSuratPersetujuan->attributes, $_POST); die;
                
                if ($modSuratPersetujuan->save()) {
                    
                    $ok = true;
                    
                    if (isset($_POST['PemberianinformasiT'])) {
                        $informasi = $this->simpanPemberianInformasi($modSuratPersetujuan, $_POST['PemberianinformasiT']);
                        $ok = $ok && !empty($informasi->pemberianinformasi_id);

                        if (isset($_POST['informasi'])) {
                            $ok = $ok && $this->simpanPemberianInformasiDetail($modSuratPersetujuan, $informasi, $_POST['informasi']);
                        }
                    }
                    // var_dump($ok); die;
                    if ($ok) {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', "Surat Persetujuan Tindakan Medis berhasil disimpan");
                        $this->redirect(array('Index', 'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
                            'suratpersetujuantm_id' => $modSuratPersetujuan->suratpersetujuantm_id, 'frame' => $frame));
                    } else {
                        $transaction->rollback();
                            Yii::app()->user->setFlash('error',"Surat Persetujuan Tindakan Medis gagal disimpan ");
                    }

                } else {
                    // var_dump($modSuratPersetujuan->errors, $modSuratPersetujuan->attributes); die;
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Surat Persetujuan Tindakan Medis gagal disimpan ");
                }
            } catch (Exception $exc) {
                $transaction->rollback(); // var_dump($exc->getMessage()); die;
                Yii::app()->user->setFlash('error', "Surat Surat Persetujuan Tindakan Medis gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render($this->path_view . 'index', array(
//			'modKunjungan'=>$modKunjungan,
            'modSuratPersetujuan' => $modSuratPersetujuan,
            'modPasienAnestesi' => $modPasienAnestesi,
            'modPraAnestesi' => $modPraAnestesi,
            'modTindakanAnestesi' => $modTindakanAnestesi,
            'modObatAlkesAnestesi' => $modObatAlkesAnestesi,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'format' => $format,
            'data' => $data,
            'pendaftaran_id' => $pendaftaran_id,
            'informasi' => $informasi,
        ));
    }

    public function actionPenolakan($pendaftaran_id = null, $frame = 0) {

        if ($frame == 1) {
            $this->layout = '//layouts/iframe';
        }

        $format = new MyFormatter();
        if (!empty(@$_GET['suratpersetujuantm_id'])) {
            $modSuratPersetujuan = SuratpersetujuantmT::model()->findByPk($_GET['suratpersetujuantm_id']);
            if ($modSuratPersetujuan->jenissurat != Params::SURAT_PERSETUJUAN_PENOLAKAN) {
                throw new CHttpException(404, "Surat Penolakan tidak ditemukan");
            }
        } else {
            $modSuratPersetujuan = new SuratpersetujuantmT();
            $modSuratPersetujuan->jeniskelamin_menyetujui = Params::JENIS_KELAMIN_LAKI_LAKI;
            $modSuratPersetujuan->jenissurat = Params::SURAT_PERSETUJUAN_PENOLAKAN;
        }
        $data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        $informasi = new PemberianinformasiT;

        if (!empty($pendaftaran_id)) {
            if (!isset($_GET['suratpersetujuantm_id']) && !Yii::app()->request->isPostRequest) {
                $this->setReferrer();
            }

            $modTindakanAnestesi = TindakanpelayananT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')));
            $modObatAlkesAnestesi = ObatalkespasienT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')));
            $modPasienAnestesi = array();
            $modPraAnestesi = array();
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
//                        $modKunjungan = new PIInformasipasienanestesiV();
        } else {
            $this->cleanReferrer();
        }
//                else{
//			$modKunjungan = new PIInformasipasienanestesiV();
//		}
        
        if (!empty($modSuratPersetujuan) && !$modSuratPersetujuan->isNewRecord) {
            $informasi = PemberianinformasiT::model()->findByAttributes(array(
                'suratpersetujuantm_id'=>$modSuratPersetujuan->suratpersetujuantm_id
            ));
        }

        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

        if (isset($_POST['SuratpersetujuantmT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $tindakan = '';
                if (!empty($_POST['tindakan'])) {
                    foreach ($_POST['tindakan'] as $key => $val) {
                        $tindakan .= $val . '::: ';
                    }
                }

                $obat = '';
                if (!empty($_POST['obat'])) {
                    foreach ($_POST['obat'] as $keyObat => $valObat) {
                        $obat .= $valObat . '::: ';
                    }
                }


                $modSuratPersetujuan = new SuratpersetujuantmT();
                $modSuratPersetujuan->attributes = $_POST['SuratpersetujuantmT'];
                $modSuratPersetujuan->pasienanastesi_id = null; //RSPMC-873
                $modSuratPersetujuan->pendaftaran_id = $pendaftaran_id;
                $modSuratPersetujuan->tindakanmedis = $tindakan;
                $modSuratPersetujuan->obatalkes = $obat;

                $modSuratPersetujuan->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $modSuratPersetujuan->tglpersetujuan = date('Y-m-d H:i:s');
                $modSuratPersetujuan->nopersetujuan = MyGenerator::noPersetujuan();
                $modSuratPersetujuan->create_time = date('Y-m-d');
                $modSuratPersetujuan->update_time = date('Y-m-d');
                $modSuratPersetujuan->create_loginpemakai_id = Yii::app()->user->id;
                $modSuratPersetujuan->update_loginpemakai_id = Yii::app()->user->id;
                $modSuratPersetujuan->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $modSuratPersetujuan->jenissurat = Params::SURAT_PERSETUJUAN_PENOLAKAN;
                $modSuratPersetujuan->tindakanterhadap = isset($_POST['hubungankeluarga']) ? $_POST['hubungankeluarga'] : "-";

                if (isset($_POST['PemberianinformasiT']['daftartindakan_id'])) {
                    $t = DaftartindakanM::model()->findByPk($_POST['PemberianinformasiT']['daftartindakan_id']);
                    $modSuratPersetujuan->tindakanmedis = $modSuratPersetujuan->tindakanmedis = !empty($t->daftartindakan_nama) ? $t->daftartindakan_nama : '-';
                }

                
                
                if ($modSuratPersetujuan->save()) {
                    
                    $ok = true;
                    
                    if (isset($_POST['PemberianinformasiT'])) {
                        $informasi = $this->simpanPemberianInformasi($modSuratPersetujuan, $_POST['PemberianinformasiT']);
                        $ok = $ok && !empty($informasi->pemberianinformasi_id);

                        if (isset($_POST['informasi'])) {
                            $ok = $ok && $this->simpanPemberianInformasiDetail($modSuratPersetujuan, $informasi, $_POST['informasi']);
                        }
                    }
                    
                    if ($ok) {
                        $transaction->commit();

                        Yii::app()->user->setFlash('success', "Surat Persetujuan Tindakan Medis berhasil disimpan");
                        $this->redirect(array('penolakan', 'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
                            'suratpersetujuantm_id' => $modSuratPersetujuan->suratpersetujuantm_id, 'frame' => $frame));
                    } else {
                        $transaction->rollback();
                            Yii::app()->user->setFlash('error',"Surat Persetujuan Tindakan Medis gagal disimpan ");
                    }
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Surat Surat Persetujuan Tindakan Medis gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render($this->path_view . 'index', array(
//			'modKunjungan'=>$modKunjungan,
            'modSuratPersetujuan' => $modSuratPersetujuan,
            'modPasienAnestesi' => $modPasienAnestesi,
            'modPraAnestesi' => $modPraAnestesi,
            'modTindakanAnestesi' => $modTindakanAnestesi,
            'modObatAlkesAnestesi' => $modObatAlkesAnestesi,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'format' => $format,
            'data' => $data,
            'pendaftaran_id' => $pendaftaran_id,
            'informasi' => $informasi,
        ));
    }
    
    public function simpanPemberianInformasi($model, $post) {
        $informasi = new PemberianinformasiT;
        $informasi->attributes = $post;
        $informasi->pendaftaran_id = $model->pendaftaran_id;
        $informasi->suratpersetujuantm_id = $model->suratpersetujuantm_id;
        $informasi->create_time = $model->create_time;
        $informasi->create_loginpemakai_id = $model->create_loginpemakai_id;
        $informasi->create_ruangan = $model->create_ruangan;
        
        $informasi->save();
        
        return $informasi;
        
        
    }
    
    public function simpanPemberianInformasiDetail($model, $informasi, $post) {
        $ok = true;
        
        
        foreach ($post as $jenisinformasi_id => $val) {
            
            $det = new PemberianinformasidetT;
            $det->attributes = $val;
            $det->pemberianinformasi_id = $informasi->pemberianinformasi_id;
            $det->jenisinformasi_id = $jenisinformasi_id;
            
            $ok = $ok && $det->save();
            
            if (isset($val['ceklis'])) {
                foreach ($val['ceklis'] as $item) {
                    $ceklis = new ChecklistpemberianinformasiT;
                    $ceklis->pemberianinformasidet_id = $det->pemberianinformasidet_id;
                    $ceklis->checklistpemberianinformasi_awal = $item['sebelum'];
                    $ceklis->checklistpemberianinformasi_nama = $item['nama'];
                    $ceklis->checklistpemberianinformasi_akhir = $item['sesudah'];
                    if (isset($item['ceklis'])) {
                        $ceklis->checklistpemberianinformasi_ceklis = $item['ceklis'];
                    }
                    
                    $ok = $ok && $ceklis->save();
                    
                    // var_dump($ceklis->attributes);
                }
            }
            
            // var_dump($det->attributes);
        }
        return $ok;
        // var_dump($ok, $post);
        // die;
    }
    

    public function actionPrint($pasienanastesi_id = null, $suratpersetujuantm_id = null, $pendaftaran_id = null) {
        $this->layout = '//layouts/iframe';

        $data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        $format = new MyFormatter();
        if (!empty($pasienanastesi_id)) {
            $criteria = new CDbCriteria();
            $criteria->addCondition('pasienanastesi_id = ' . $pasienanastesi_id);
            $modKunjungan = InformasipasienanestesiV::model()->find($criteria);
            $modPasienAnestesi = PasienanastesiT::model()->findByPk($pasienanastesi_id);
            $modPraAnestesi = PraanestesiT::model()->findByAttributes(array('pasienanastesi_id' => $pasienanastesi_id), array('order' => 'praanestesi_id DESC'));
            if (!empty($modPraAnestesi)) {
                $modTindakanAnestesi = TindakananestesiT::model()->findAllByAttributes(array('praanestesi_id' => $modPraAnestesi->praanestesi_id));
                $modObatAlkesAnestesi = ObatalkesanestesiT::model()->findAllByAttributes(array('praanestesi_id' => $modPraAnestesi->praanestesi_id));
            } else {
                $modTindakanAnestesi = array();
                $modObatAlkesAnestesi = array();
            }
            $modPendaftaran = PendaftaranT::model()->findByPk($modPasienAnestesi->pendaftaran_id);
        } else {
            $modTindakanAnestesi = array();
            $modObatAlkesAnestesi = array();
            $modPasienAnestesi = array();
            $modPraAnestesi = array();
//		$modKunjungan = new PIInformasipasienanestesiV();
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        }

        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modSuratPersetujuan = SuratpersetujuantmT::model()->findByPk($suratpersetujuantm_id);
        $pemberiinformasi = PemberianinformasiT::model()->findByAttributes(array('suratpersetujuantm_id'=>$suratpersetujuantm_id));
        $jenisSurat = JenissuratM::model()->findByPk($pemberiinformasi->jenissurat_id);

        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraprint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }
        $this->render($this->path_view . 'printNew', array(
//                'modKunjungan'=>$modKunjungan,
            'modSuratPersetujuan' => $modSuratPersetujuan,
            'modPasienAnestesi' => $modPasienAnestesi,
            'modPraAnestesi' => $modPraAnestesi,
            'modTindakanAnestesi' => $modTindakanAnestesi,
            'modObatAlkesAnestesi' => $modObatAlkesAnestesi,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'format' => $format,
            'data' => $data,
            'jenisSurat'=>$jenisSurat));
    }
    
    
    
    public function actionPrintInformasi($pasienanastesi_id = null, $suratpersetujuantm_id = null, $pendaftaran_id = null) {
        $this->layout = '//layouts/iframe';
        if (!empty($pasienanastesi_id)) {
            
        $surat = SuratpersetujuantmT::model()->findByPk($suratpersetujuantm_id);
        
        $model = PemberianinformasiT::model()->findByAttributes(array(
            'suratpersetujuantm_id'=>$suratpersetujuantm_id,
        ));
        $detail = PemberianinformasidetT::model()->findAllByAttributes(array(
            'pemberianinformasi_id'=>$model->pemberianinformasi_id,
        ), array(
            'order'=>'pemberianinformasidet_id asc',
        ));
        $pendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
     
    }else{
        $surat = SuratpersetujuantmT::model()->findByPk($suratpersetujuantm_id);
        
        $model = PemberianinformasiT::model()->findByAttributes(array(
            'suratpersetujuantm_id'=>$suratpersetujuantm_id,
        ));
        $detail = PemberianinformasidetT::model()->findAllByAttributes(array(
            'pemberianinformasi_id'=>$model->pemberianinformasi_id,
        ), array(
            'order'=>'pemberianinformasidet_id asc',
        ));
       $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
     
    }

    $caraPrint=$_REQUEST['caraprint'];
    if($caraPrint=='PRINT') {
        $this->layout='//layouts/printWindows';
    }
        $this->render($this->path_view.'_printInformasi', array(
            'surat'=>$surat,
            'model'=>$model,
            'detail'=>$detail,
            'pendaftaran'=>$pendaftaran,
        ));
    }
    
    /*
    public function actionPrintPenolakan($pasienanastesi_id = null, $suratpersetujuantm_id = null, $pendaftaran_id = null) {
        $this->layout = '//layouts/iframe';

        $data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        $format = new MyFormatter();
        if (!empty($pasienanastesi_id)) {
            $criteria = new CDbCriteria();
            $criteria->addCondition('pasienanastesi_id = ' . $pasienanastesi_id);
            $modKunjungan = InformasipasienanestesiV::model()->find($criteria);
            $modPasienAnestesi = PasienanastesiT::model()->findByPk($pasienanastesi_id);
            $modPraAnestesi = PraanestesiT::model()->findByAttributes(array('pasienanastesi_id' => $pasienanastesi_id), array('order' => 'praanestesi_id DESC'));
            if (!empty($modPraAnestesi)) {
                $modTindakanAnestesi = TindakananestesiT::model()->findAllByAttributes(array('praanestesi_id' => $modPraAnestesi->praanestesi_id));
                $modObatAlkesAnestesi = ObatalkesanestesiT::model()->findAllByAttributes(array('praanestesi_id' => $modPraAnestesi->praanestesi_id));
            } else {
                $modTindakanAnestesi = array();
                $modObatAlkesAnestesi = array();
            }
            $modPendaftaran = PendaftaranT::model()->findByPk($modPasienAnestesi->pendaftaran_id);
        } else {
            $modTindakanAnestesi = array();
            $modObatAlkesAnestesi = array();
            $modPasienAnestesi = array();
            $modPraAnestesi = array();
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        }

        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modSuratPersetujuan = SuratpersetujuantmT::model()->findByPk($suratpersetujuantm_id);

        $judulLaporan = '';

        $caraPrint = $_REQUEST['caraprint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
        }
        $this->render($this->path_view . 'printPenolakan', array(
            'modSuratPersetujuan' => $modSuratPersetujuan,
            'modPasienAnestesi' => $modPasienAnestesi,
            'modPraAnestesi' => $modPraAnestesi,
            'modTindakanAnestesi' => $modTindakanAnestesi,
            'modObatAlkesAnestesi' => $modObatAlkesAnestesi,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'format' => $format,
            'data' => $data));
    }
     * 
     */

    public function actionLoadInformasi() {
        if (!Yii::app()->request->isAjaxRequest) {
            return Yii::app()->end();
        }

        $id = $_POST['id'];

        $jenis = JenisinformasiM::model()->findAllByAttributes(array(
            'jenissurat_id' => $id,
                ), array('order' => 'jenisinformasi_urutan asc'));

        $html = "";
        foreach ($jenis as $cnt => $item) {
            $html .= $this->renderPartial($this->path_view . 'informasi._list', array(
                'jenis' => $item,
                'cnt' => $cnt,
                'len' => count($jenis),
                    ), true);
        }

        echo CJSON::encode(array('html' => $html, 'count' => count($jenis)));
    }
    
    public function actionDaftarTindakan() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $modTindakan = new DaftartindakanM();
        $modTindakan->unsetAttributes();
        
        $modTindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');
        if (isset($_GET['term'])) {
            $modTindakan->daftartindakan_nama = $_GET['term'];
        }
        
        $prov = $modTindakan->searchTindakanRuangan();
        $prov->pagination = false;
        
        $res = array();
        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->daftartindakan_kode." - ".$item->daftartindakan_nama;
            $sub['value'] = $item->daftartindakan_id;
            
            $res[] = $sub;
        }
        
        echo CJSON::encode($res);
    }

}
