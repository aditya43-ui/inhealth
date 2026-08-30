<?php

Yii::import('rawatJalan.models.*');

/**
 * untuk informasi
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.modules.hemodialisa
 * @subpackage controllers
 */
class DaftarPasienController extends MyAuthController {

    public $validRujukan = false;
    public $validPulang = false;
    public $path_view_riwayat = 'rawatJalan.views._periksaDataPasien.';
    public $path_view = 'hemodialisa.views.daftarPasien.';
  
    public $pendaftaran_id;

    public function actionIndex() {
       // $modPendaftaran = RJPendaftaranT::model()->findByPk($id);
        $format = new MyFormatter();
        $this->pageTitle = Yii::app()->name . " - Daftar Pasien Gawat Darurat";
        $model = new HDInfoKunjunganRDV;
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
//		$model->ceklis = true; 
//		$model->shift_id= Yii::app()->user->getState('shift_id');
        if (isset($_REQUEST['HDInfoKunjunganRDV'])) {
            $model->attributes = $_REQUEST['HDInfoKunjunganRDV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['HDInfoKunjunganRDV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['HDInfoKunjunganRDV']['tgl_akhir']);
//			$model->ceklis = $_REQUEST['HDInfoKunjunganRDV']['ceklis'];
        }
        if (Yii::app()->request->isAjaxRequest) {
            echo $this->renderPartial('_tablePasien', array('model' => $model));
        } else {
            $this->render('index', array('format' => $format, 'model' => $model));
        }
    }
    
    
    
  public function actionCreate($pendaftaran_id = null, $pasienadmisi_id = null, $ppds_id = null, $urutan_ppds = null)
  {

    $modPendaftaran = HDPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = HDPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modRuangan = RuanganM::model()->findByPk($modPendaftaran->ruangan_id);
    $model2 = new PpdsM();
    $modPpds = new PpdsM();
    $modDetail = new PasienPpdsT;    
    $model = new PasienPpdsT;
    
    if (isset($_POST['PasienPpdsT'])) {  
     $transaction = Yii::app()->db->beginTransaction();
     $ok = true;

      $i = 1;
        foreach ($_POST['PasienPpdsT'] as $idx=>$item) {
          $modDetail = new PasienPpdsT;
          $modDetail->ppds_id = $item['ppds_id'];
          $modDetail->urutan_ppds = $i;
          $modDetail->pendaftaran_id = $pendaftaran_id;
          $modDetail->pasienadmisi_id = $pasienadmisi_id;

          $ok = $ok && $modDetail->save();
          $i++;
        }

        if ($ok && !empty(Yii::app()->user->getState('pegawai_id'))) {
          $transaction->commit();
         Yii::app()->user->setFlash('success', '<strong>Sukses!</strong> Data berhasil disimpan!');
        } else {
          $transaction->rollback();
         Yii::app()->user->setFlash('error', '<strong>Perhatian!</strong> Nama PPDS Tidak Sesuai login Anda!');
          
        }
      }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'model2' => $model2,
      'modPpds'=>$modPpds,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modRuangan'=> $modRuangan,
      'modDetail' => $modDetail
    ));
  }

  public function actionAutoPPDS()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(ppds_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'ppds_nama';
                $criteria->limit = 10;
                $models = PpdsM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->ppds_nama;
                    $returnVal[$i]['value'] = $model->ppds_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}

  public function actionPPDSRJ($pendaftaran_id = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    //$pendaftaran_id = $_GET['pendaftaran_id'];

    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modRuangan = RuanganM::model()->findByPk($modPendaftaran->ruangan_id);
    $model2 = new PpdsM();
    $modPpds = new PpdsM();
    $modDetail = new PasienPpdsT;
    
    $model2->ppds_nama;
    
    $this->render('_formPPDSRJ', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modRuangan'=> $modRuangan,
      'model2' => $model2,
      'modPpds'=>$modPpds,
      'modDetail' => $modDetail
   //   'datatable' => $datatable
    ));
  }



    public function actionBatalRawatInap($pendaftaran_id) {
        $this->layout = '//layouts/iframe';
        $modPendaftaran = HDPendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

        $modPasienBatalPulang = new PasienbatalpulangT;
        $tersimpan = 'tidak';

        if (!empty($_POST['PasienbatalpulangT'])) {

            $pasienPulangId = $_POST['pasienpulang_id'];

            $pendaftaran_id = $_POST['pendaftaran_id'];

            $format = new MyFormatter();
            $modPasienBatalPulang->attributes = $_POST['PasienbatalpulangT'];
            $modPasienBatalPulang->create_time = date('Y-m-d H:i:s');
            $modPasienBatalPulang->update_time = date('Y-m-d H:i:s');
            $modPasienBatalPulang->tglpembatalan = $format->formatDateTimeForDb($modPasienBatalPulang->tglpembatalan);
            $modPasienBatalPulang->namauser_otorisasi = Yii::app()->user->name;
            $modPasienBatalPulang->iduser_otorisasi = Yii::app()->user->id;
            $modPasienBatalPulang->create_loginpemakai_id = Yii::app()->user->id;
            $modPasienBatalPulang->update_loginpemakai_id = Yii::app()->user->id;
            $modPasienBatalPulang->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modPasienBatalPulang->pasienpulang_id = $pasienPulangId;

            if ($modPasienBatalPulang->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($modPasienBatalPulang->save()) {
                        if (!empty($pasienPulangId)) {
                            $pulang = HDPasienPulangT::model()->updateByPk($pasienPulangId, array('pasienbatalpulang_id' => $modPasienBatalPulang->pasienbatalpulang_id));
                            $pendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, array('pasienpulang_id' => null, 'statusperiksa' => 'SEDANG PERIKSA'));
                            if ($pulang && $pendaftaran) {
                                $transaction->commit();
                                Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                                $tersimpan = 'Ya';
                                //                          
                            } else {
                                $transaction->rollback();
                                Yii::app()->user->setFlash('error', "Data gagal disimpan");
                            }
                        }
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                        $tersimpan = 'Ya';
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "Data gagal disimpanx");
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan", MyExceptionMessage::getMessage($exc, false));
                }
            } else {
                Yii::app()->user->setFlash('error', "Data gagal disimpan");
            }
        }
        $this->render('formBatalRawatInap', array('modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran, 'modPasienBatalPulang' => $modPasienBatalPulang, 'tersimpan' => $tersimpan));
    }

    /**
     * actionPasienPulang = transaksi - pasien pulang
     */
    public function actionPasienPulang($pendaftaran_id = null, $dialog = false) {
        $nama_modul = Yii::app()->controller->module->id;
        $nama_controller = Yii::app()->controller->id;
        $nama_action = Yii::app()->controller->action->id;
        $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
        $smspasien = 1;
        $criteria = new CDbCriteria;
        $criteria->compare('modul_id', $modul_id);
        $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
        $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
        if (isset($_POST['tujuansms'])) {
            $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
        }
        $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

        if ($dialog)
            $this->layout = '//layouts/iframe';
        $tersimpan = false;
        if (!empty($pendaftaran_id)) {
            $modPendaftaran = HDPendaftaranT::model()->findByPk($pendaftaran_id);
            if (!$modPendaftaran) {
                Yii::app()->user->setFlash('error', 'Pendaftaran Tidak Ditemukan !');
            } else {
                $modPasien = HDPasienM::model()->findByPk($modPendaftaran->pasien_id);
            }
//                if(!empty($modPendaftaran->pasienpulang_id)){
//                    echo "Pasien Telah Ditindaklanjut Dari Rawat Darurat !";
//                    exit;
//                }
        } else {
            $modPendaftaran = new HDPendaftaranT;
            $modPasien = new HDPasienM;
        }
        $modelPulang = new HDPasienPulangT;
        $modRujukanKeluar = new PasiendirujukkeluarT;

        $modelPulang->tglpasienpulang = date('d M Y H:i:s');
        $modelPulang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modelPulang->pasien_id = $modPasien->pasien_id;

        $modRujukanKeluar->pegawai_id = PendaftaranT::model()->findByPk($pendaftaran_id)->pegawai_id;
        $modRujukanKeluar->ruanganasal_id = Yii::app()->user->getState('ruangan_id'); //ruangan asal itu diasumsikan ruangan terakhir dia dari mana
        $modRujukanKeluar->tgldirujuk = date('d M Y H:i:s');
        $modRujukanKeluar->tglberlakusurat = date('d M Y H:i:s');
        $format = new MyFormatter();
        $date1 = $format->formatDateTimeForDb($modPendaftaran->tgl_pendaftaran);
        $date2 = date('Y-m-d H:i:s');
        $diff = abs(strtotime($date2) - strtotime($date1));
        $hours = floor(($diff) / 3600);
        $selisihHariRawat = CustomFunction::hitungHariRawat($date1);

        $modelPulang->lamarawat = $hours;
        $modelPulang->hariperawatan = $selisihHariRawat;

        if (isset($_POST['HDPasienPulangT'])) {
            if (!empty($_POST['HDPendaftaranT']['pendaftaran_id']))
                $modPendaftaran = $modPendaftaran->findByPk($_POST['HDPendaftaranT']['pendaftaran_id']);
            if (!empty($_POST['HDPasienM']['pasien_id']))
                $modPasien = $modPasien->findByPk($_POST['HDPasienM']['pasien_id']);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modelPulang = $this->savePasienPulang($modelPulang, $_POST['HDPasienPulangT']);

                if (isset($_POST['pakeRujukan'])) {
                    $modelPulang->pakeRujukan = true;
                    $modRujukanKeluar = $this->saveRujukanKeluar($modRujukanKeluar, $modelPulang, $_POST['PasiendirujukkeluarT']);
                } else {
                    $this->validRujukan = true;
                }

                if (isset($_POST['isDead'])) {
                    // $modPasien = PasienM::model()->findByPk(Yii::app()->session['pasien_id']);
                    $modPasien = PasienM::model()->findByPk($_POST['HDPasienPulangT']['pasien_id']);
                    $modPasien->tgl_meninggal = $format->formatDateTimeForDb($_POST['HDPasienPulangT']['tgl_meninggal']);
                    $modPasien->save();
                }
                if ($this->validPulang && $this->validRujukan) {
                    PendaftaranT::model()->updateByPk($modelPulang->pendaftaran_id, array('tglselesaiperiksa' => date('Y-m-d H:i:s'), 'pasienpulang_id' => $modelPulang->pasienpulang_id, 'statusperiksa' => 'SUDAH PULANG'));

                    // SMS GATEWAY

                    $sms = new Sms();
                    $modCaraKeluar = $modelPulang->carakeluar;
                    $modKondisiKeluar = $modelPulang->kondisikeluar;
                    foreach ($modSmsgateway as $i => $smsgateway) {
                        $isiPesan = $smsgateway->templatesms;

                        $attributes = $modPasien->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modelPulang->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modKondisiKeluar->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modCaraKeluar->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modelPulang->tglpasienpulang), $isiPesan);

                        if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                            if (!empty($modPasien->no_mobile_pasien)) {
                                $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                            } else {
                                $smspasien = 0;
                            }
                        }
                    }
                    // END SMS GATEWAY

                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Data berhasil disimpan !');
                    if ($dialog) {
                        $tersimpan = true;
                    } else
                        $this->redirect(Yii::app()->createUrl($this->route)); //refresh dgn menghilangkan $_get
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $this->render('formPasienPulang', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modelPulang' => $modelPulang,
            'modRujukanKeluar' => $modRujukanKeluar,
            'smspasien' => $smspasien,
            'tersimpan' => $tersimpan,
        ));
    }

    /**
     * digunakan untuk save pasien pulang
     * @param type model $modPasienPulang
     * @param type model $attrPasienPulang
     * @param type integer $pasienadmisi_id
     * @return \HDPasienPulangT
     */
    protected function savePasienPulang($modPasienPulang, $attrPasienPulang, $pasienadmisi_id = '') {
        $modelPulangNew = new HDPasienPulangT;
        $modelPulangNew->attributes = $attrPasienPulang;
        $modelPulangNew->satuanlamarawat = (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_HD) ? Params::SATUAN_LAMARAWAT_HD : Params::SATUAN_LAMARAWAT_RI;
        $modelPulangNew->ruanganakhir_id = Yii::app()->user->getState('ruangan_id');
        $modelPulangNew->create_time = date('Y-m-d H:i:s');
        $modelPulangNew->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modelPulangNew->create_loginpemakai_id = Yii::app()->user->id;
        $modelPulangNew->pasienadmisi_id = (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_HD) ? null : $pasienadmisi_id;

        if ($modelPulangNew->save()) {
            $this->validPulang = true;
        }

        return $modelPulangNew;
    }

    /**
     * digunakan untuk save rujukan keluar
     * @param type model $modRujukanKeluar
     * @param type model $modelPulang
     * @param type model $attrRujukanKeluar
     * @return \PasiendirujukkeluarT
     */
    protected function saveRujukanKeluar($modRujukanKeluar, $modelPulang, $attrRujukanKeluar) {
        $modRujukanKeluarNew = new PasiendirujukkeluarT;
        $modRujukanKeluarNew->attributes = $attrRujukanKeluar;
        $modRujukanKeluarNew->pendaftaran_id = $modelPulang->pendaftaran_id;
        $modRujukanKeluarNew->pasien_id = $modelPulang->pasien_id;
        $modRujukanKeluarNew->create_time = date('Y-m-d H:i:s');
        $modRujukanKeluarNew->create_loginpemakai_id = Yii::app()->user->id;
        $modRujukanKeluarNew->tglberlakusurat = date('Y-m-d H:i:s');
        $modRujukanKeluarNew->sampaidengan = date('Y-m-d H:i:s', strtotime("+30 days"));
        if ($modRujukanKeluarNew->save()) {
            $this->validRujukan = true;
        } else {
            $this->validRujukan = false;
        }
        return $modRujukanKeluarNew;
    }

    /**
     * Mengatur dropdown kabupaten
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropDownKondisiKeluar($encode = false, $model_nama = '', $attr = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new HDPasienPulangT;
            if ($model_nama !== '' && $attr == '') {
                $carakeluar_id = $_POST["$model_nama"]['carakeluar_id'];
            } elseif ($model_nama == '' && $attr !== '') {
                $carakeluar_id = $_POST["$attr"];
            } elseif ($model_nama !== '' && $attr !== '') {
                $carakeluar_id = $_POST["$model_nama"]["$attr"];
            }
            $kondisikeluar = null;
            if ($carakeluar_id) {
                $kondisikeluar = $model->getKondisikeluarItems($carakeluar_id);
                $kondisikeluar = CHtml::listData($kondisikeluar, 'kondisikeluar_id', 'kondisikeluar_nama');
            }
            if ($encode) {
                echo CJSON::encode($kondisikeluar);
            } else {
                if (empty($kondisikeluar)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    foreach ($kondisikeluar as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * batal periksa pasien RND-5542
     */
    public function actionBatalPeriksa() {
        $nama_modul = Yii::app()->controller->module->id;
        $nama_controller = Yii::app()->controller->id;
        $nama_action = Yii::app()->controller->action->id;

        $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
        $statusperiksa = isset($_POST['statusperiksa']) ? $_POST['statusperiksa'] : null;
        $tglbatal = isset($_POST['tglbatal']) ? $_POST['tglbatal'] : null;
        $keterangan_batal = isset($_POST['keterangan_batal']) ? $_POST['keterangan_batal'] : null;
        $nama_pemakai = isset($_POST['nama_pemakai']) ? $_POST['nama_pemakai'] : null;
        $kata_kunci = isset($_POST['kata_kunci']) ? $_POST['kata_kunci'] : null;

        //echo "<pre>";        var_dump($_POST);        die();
        
        $status_tindakan = false;
        $status_obat = false;
        $status_batal = true;
        $pesan = '';
        if (Yii::app()->request->isAjaxRequest) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
                $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

                $criteriaTindakan = new CDbCriteria();
                $criteriaTindakan->addCondition('pendaftaran_id = ' . $pendaftaran_id);
                $criteriaTindakan->addCondition('tindakansudahbayar_id is not null');

                $modTindakanPelayanan = TindakanpelayananT::model()->find($criteriaTindakan);

                $criteriaObat = new CDbCriteria();
                $criteriaObat->addCondition('pendaftaran_id = ' . $pendaftaran_id);
                $criteriaObat->addCondition('oasudahbayar_id is not null');
                $modObatalkesPasien = ObatalkespasienT::model()->find($criteriaObat);

                if ($modTindakanPelayanan) {
                    $status_tindakan = true;
                }

                if ($modObatalkesPasien) {
                    $status_obat = true;
                }

                if ($status_tindakan == true || $status_obat == true) {
                    $status_batal = false;
                    $pesan = "Pemeriksaan tidak bisa dibatalkan karena ada tindakan/obat yang sudah dibayarkan. Silakan hubungi Kasir!";
                } else {
                    $status_batal = true;
                }

                if ($status_batal == true) {
                    /*
                     * cek data pendaftaran pasien masuk penunjang
                     */
                    $criteria = new CDbCriteria();
                    if (!empty($pendaftaran_id)) {
                        $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
                    }

                    $pasienMasukPenunjang = PasienmasukpenunjangT::model()->find($criteria);

                    $pesan = '';
                    $status = false;
                    $model = new PasienbatalperiksaR();
                    $model->pendaftaran_id = $pendaftaran_id;
                    $model->pasien_id = $modPendaftaran->pasien_id;
                    $model->tglbatal = isset($tglbatal) ? MyFormatter::formatDateTimeForDb($tglbatal) : date('Y-m-d');
                    $model->keterangan_batal = isset($keterangan_batal) ? $keterangan_batal : "Batal Gawat Darurat";
                    $model->create_ruangan = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');

                    if ($model->save()) {
                        $status = true;
                        $pesan = "Pemeriksaan pasien berhasil dibatalkan!";
                    } else {
                        $status = false;
                        $pesan = "Pemeriksaan gagal dibatalkan! " . CHtml::errorSummary($model);
                    }

                    $attributes = array(
                        'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
                        'update_time' => date('Y-m-d H:i:s'),
                        'update_loginpemakai_id' => Yii::app()->user->id
                    );
                    $pendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, $attributes);

                    if (!empty($pasienMasukPenunjang)) {
                        if ($pasienMasukPenunjang->pasienkirimkeunitlain_id == null) {
                            $attributes = array(
                                'pasienkirimkeunitlain_id' => $pasienMasukPenunjang->pasienkirimkeunitlain_id
                            );
                            $Perminataan_penunjang = PermintaankepenunjangT::model()->deleteAllByAttributes($attributes);
                        }

                        $attributes = array(
                            'statusperiksa' => Params::STATUSPERIKSA_BATAL_PERIKSA,
                            'update_time' => date('Y-m-d H:i:s'),
                            'update_loginpemakai_id' => Yii::app()->user->id
                        );
                        $penunjang = PasienmasukpenunjangT::model()->updateByPk($pasienMasukPenunjang->pasienmasukpenunjang_id, $attributes);
                        if (!$penunjang) {
                            $status = false;
                        }
                        /*
                         * cek data tindakan_pelayanan
                         */
                        $attributes = array(
                            'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id,
                            'tindakansudahbayar_id' => null
                        );

                        $criteria2 = new CDbCriteria();
                        $criteria2->addCondition('pasienmasukpenunjang_id = ' . $pasienMasukPenunjang->pasienmasukpenunjang_id);
                        $criteria2->addCondition('tindakansudahbayar_id is null');
                        $tindakan = TindakanpelayananT::model()->findAll($criteria2);

                        if (count($tindakan) > 0) {

                            foreach ($tindakan as $val => $key) {
                                $attributes = array(
                                    'tindakanpelayanan_id' => $key->tindakanpelayanan_id
                                );
                                $hapus_komponen = TindakankomponenT::model()->deleteAllByAttributes($attributes);
                            }

                            $attributes = array(
                                'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id
                            );

                            $hapus_tindakan = TindakanPelayananT::model()->deleteAllByAttributes($attributes);
                            if (!$hapus_tindakan) {
                                $status = false;
                                $pesan = "exist";
                            }
                        } else {
                            $pesan = "exist";
                        }

                        $criteriaObat2 = new CDbCriteria();
                        $criteriaObat2->addCondition('pendaftaran_id = ' . $pendaftaran_id);
                        $criteriaObat2->addCondition('oasudahbayar_id is null');
                        $modObatalkesPasien2 = ObatalkespasienT::model()->findAll($criteriaObat2);

                        if (count($modObatalkesPasien2) > 0) {

                            foreach ($modObatalkesPasien2 as $val => $obat) {
                                $attributes = array(
                                    'obatalkespasien_id' => $obat->obatalkespasien_id
                                );
                                $hapusobatalkes = ObatalkeskomponenT::model()->deleteAllByAttributes($attributes);
                            }

                            $hapus_obat = ObatalkespasienT::model()->deleteAllByAttributes($attributes);
                            if (!$hapus_obat) {
                                $status = false;
                                $pesan = "exist";
                            }
                        } else {
                            $pesan = "exist";
                        }
                    }

                    /*
                     * kondisi_commit
                     */
                    if ($status == true) {
                        $transaction->commit();
                    } else {
                        $transaction->rollback();
                    }
                }
            } catch (Exception $ex) {
                $status = false;
                $pesan = "exist";
                $transaction->rollback();
            }

            $data = array(
                'pesan' => $pesan,
                'status' => $status,
            );
            echo json_encode($data);
            Yii::app()->end();
        }
    }
//public function actionBatalPeriksa()
//    {
//        $nama_modul = Yii::app()->controller->module->id;
//        $nama_controller = Yii::app()->controller->id;
//        $nama_action = Yii::app()->controller->action->id;
//        $modul_id = ModulK::model()->findByAttributes(array('url_modul'=>$nama_modul))->modul_id;
//        $smspasien = 1;
//        $smsdokter = 1;
//        $criteria = new CDbCriteria;
//        $criteria->compare('modul_id', $modul_id);
//        $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
//        $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
//        if (isset($_POST['tujuansms'])) {
//            $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
//        }
//        $modSmsgateway = SmsgatewayM::model()->findAll($criteria);
//
//        if (Yii::app()->request->isAjaxRequest) {
//            $transaction = Yii::app()->db->beginTransaction();
//            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
//            
//            echo "<pre>";            var_dump($_POST); die();
//            
//            $keterangan_batal = isset($_POST['keterangan_batal']) ? $_POST['keterangan_batal'] : null;
//            $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
//            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
//            //$modPegawai = $modPendaftaran->pegawai;
//            $modPasien = $modPendaftaran->nama_pasien;
//                                
//            try {
//                /*
//                * cek data pendaftaran pasien masuk penunjang
//                */
//                $criteria = new CDbCriteria();
//                if (!empty($pendaftaran_id)) {
//                    $criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);
//                }
//
//                $tindakan = TindakanpelayananT::model()->findByAttributes(
//                    array(
//                        'pendaftaran_id'=>$pendaftaran_id,
//                    ), array(
//                        'condition'=>'tindakansudahbayar_id is not null'
//                    )
//                );
//                $oa = ObatalkespasienT::model()->findByAttributes(
//                    array(
//                        'pendaftaran_id'=>$pendaftaran_id,
//                    ), array(
//                        'condition'=>'oasudahbayar_id is not null'
//                    )
//                );
//
//                $ada = false;
//
//                if (!empty($tindakan) || !empty($oa)) {
//                    $ada = true;
//                    $pesan = "Pasien sudah melakukan pembayaran. "
//                                . "Mohon pembayaran sebelumnya dibatalkan terlebih dahulu sebelum melakukan pembatalan pemeriksaan.";
//                    $status = false;
//                    goto onco; // loncat ke label 'onco'
//                }
//                                        
//                $pasienMasukPenunjang = PasienmasukpenunjangT::model()->find($criteria);
//                    
//                $pesan = '';
//                $status = false;
//                $model = new PasienbatalperiksaR();
//                $model->pendaftaran_id = $pendaftaran_id;
//                $model->pasien_id = $modPendaftaran->pasien_id;
//                $model->tglbatal = date('Y-m-d');
//                $model->keterangan_batal = $keterangan_batal;
//                $model->create_ruangan = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
//
//                if ($model->save()) {
//                    $status = true;
//                    $pesan = "Pemeriksaan pasien berhasil dibatalkan!";
//                } else {
//                    $status = false;
//                    $pesan = "Pemeriksaan gagal dibatalkan! ".CHtml::errorSummary($model);
//                }
//
//                $attributes = array(
//                        'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
//                        'update_time' => date('Y-m-d H:i:s'),
//                        'update_loginpemakai_id' => Yii::app()->user->id,
//                        'statusperiksa'=> Params::STATUSPERIKSA_BATAL_PERIKSA
//                    );
//                $pendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, $attributes);
//                /*
//                if(count($pasienMasukPenunjang) > 0){
//                    if($pasienMasukPenunjang->pasienkirimkeunitlain_id == null)
//                    {
//                        $attributes = array(
//                            'pasienkirimkeunitlain_id' => $pasienMasukPenunjang->pasienkirimkeunitlain_id
//                        );
//                        $Perminataan_penunjang = PermintaankepenunjangT::model()->deleteAllByAttributes($attributes);
//                    }
//
//                    $attributes = array(
//                        'statusperiksa' => Params::STATUSPERIKSA_BATAL_PERIKSA,
//                        'update_time' => date('Y-m-d H:i:s'),
//                        'update_loginpemakai_id' => Yii::app()->user->id
//                    );
//                    $penunjang = PasienmasukpenunjangT::model()->updateByPk($pasienMasukPenunjang->pasienmasukpenunjang_id, $attributes);
//                    if(!$penunjang)
//                    {
//                        $status = false;
//                    }
//                    /*
//                    * cek data tindakan_pelayanan
//                    */ /*
//                                                $attributes = array(
//                                                        'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id,
//                                                        'tindakansudahbayar_id' => null
//                                                );
//
//                                                $criteria2 = new CDbCriteria();
//                                                $criteria2->addCondition('pasienmasukpenunjang_id = '.$pasienMasukPenunjang->pasienmasukpenunjang_id);
//                                                $criteria2->addCondition('tindakansudahbayar_id is null');
//                                                $tindakan = TindakanpelayananT::model()->findAll($criteria2);
//
//                                                if(count($tindakan) > 0)
//                                                {
//
//                                                        foreach($tindakan as $val=>$key)
//                                                        {
//                                                                $attributes = array(
//                                                                        'tindakanpelayanan_id' => $key->tindakanpelayanan_id
//                                                                );
//                                                                $hapus_komponen= TindakankomponenT::model()->deleteAllByAttributes($attributes);
//                                                        }
//
//                                                        $attributes = array(
//                                                                'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id
//                                                        );
//
//                                                        $hapus_tindakan = TindakanPelayananT::model()->deleteAllByAttributes($attributes);
//                                                        if(!$hapus_tindakan)
//                                                        {
//                                                                $status = false;
//                                                                $pesan = "exist";
//                                                        }
//                                                }else{
//                                                        $pesan = "exist";
//                                                }
//                                            } */
//                   
//                /*
//                * kondisi_commit
//                */
//                onco:
//
//                if ($status == true) {
//                    // SMS GATEWAY
//                    $modPasien = $modPendaftaran->pasien;
//                    $sms = new Sms();
//                    foreach ($modSmsgateway as $i => $smsgateway) {
//                        $isiPesan = $smsgateway->templatesms;
//
//                        $attributes = $modPasien->getAttributes();
//                        foreach ($attributes as $attributes => $value) {
//                            $isiPesan = str_replace("{{".$attributes."}}", $value, $isiPesan);
//                        }
//                        $attributes = $model->getAttributes();
//                        foreach ($attributes as $attributes => $value) {
//                            $isiPesan = str_replace("{{".$attributes."}}", $value, $isiPesan);
//                        }
//                        $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($model->tglbatal), $isiPesan);
//
//                        if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
//                            if (!empty($modPasien->no_mobile_pasien)) {
//                                $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
//                            } else {
//                                $smspasien = 0;
//                            }
//                        } elseif ($smsgateway->tujuansms == Params::TUJUANSMS_DOKTER && $smsgateway->statussms) {
//                            if (!empty($modPegawai->nomobile_pegawai)) {
//                                $sms->kirim($modPegawai->nomobile_pegawai, $isiPesan);
//                            } else {
//                                $smsdokter = 0;
//                            }
//                        }
//                    }
//                    // END SMS GATEWAY
//                    $transaction->commit();
//                } else {
//                    $transaction->rollback();
//                }
//            } catch (Exception $ex) {
//                $status = false;
//                $pesan = "exist";
//                $transaction->rollback();
//            }
//                
//            $data = array(
//                    'pesan'=>$pesan,
//                    'status'=>$status,
//                                        'smspasien'=>$smspasien,
//                                        'smsdokter'=>$smsdokter,
//                                       'nama_pasien'=>$modPasien->nama_pasien,
//                                        //'nama_pegawai'=>$modPegawai->nama_pegawai,
//                );
//            echo json_encode($data);
//            Yii::app()->end();
//        }
//    }
    /**
     * Mengatur dropdown kasus penyakit
     */
    public function actionSetDropdownKasusPenyakit() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
            $jeniskasuspenyakit_id = isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null;

            $jeniskasuspenyakit = JeniskasuspenyakitM::model()->findAll('jeniskasuspenyakit_aktif = TRUE');
            $jeniskasuspenyakit = CHtml::listData($jeniskasuspenyakit, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama');

            $jeniskasuspenyakitOptions = CHtml::dropDownList('jeniskasuspenyakit_id', '', $jeniskasuspenyakit, array("onchange" => "saveKasusPenyakit(this,$pendaftaran_id)", "style" => "width:140px;", "options" => array($jeniskasuspenyakit_id => array("selected" => true))));

            $dataList['kasusPenyakit'] = $jeniskasuspenyakitOptions;

            echo json_encode($dataList);
            Yii::app()->end();
        }
    }

    /**
     * Mengatur dropdown kasus penyakit
     */
    public function actionSaveKasusPenyakit() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
            $jeniskasuspenyakit_id = isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null;
            $pesan = 'gagal';

            $update = HDPendaftaranT::model()->updateByPk($pendaftaran_id, array('jeniskasuspenyakit_id' => $jeniskasuspenyakit_id));
            if ($update) {
                $pesan = 'berhasil';
            } else {
                $pesan = 'gagal';
            }
            $data['pesan'] = $pesan;

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * untuk Ubah Dokter
     */
    public function actionUbahDokterPeriksa() {
        $model = new HDPendaftaranT();
        $modUbahDokter = new HDUbahdokterR;
        $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
        if (isset($_POST['HDPendaftaranT'])) {
            if ($_POST['HDPendaftaranT']['pegawai_id'] != "") {
                $modUbahDokter->attributes = $_POST['HDUbahdokterR'];
                $modUbahDokter->pendaftaran_id = $_POST['HDPendaftaranT']['pendaftaran_id'];
                $modUbahDokter->dokterbaru_id = $_POST['HDPendaftaranT']['pegawai_id'];
                $modUbahDokter->tglubahdokter = date('Y-m-d H:i:s');
                $modUbahDokter->create_time = date('Y-m-d H:i:s');
                $modUbahDokter->create_loginpemakai_id = Yii::app()->user->id;
                $modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $attributes = array('pegawai_id' => $_POST['HDPendaftaranT']['pegawai_id']);

                    $save = HDPendaftaranT::model()->updateByPk($_POST['HDPendaftaranT']['pendaftaran_id'], $attributes);

                    if ($save) {
                        $modUbahDokter->save();
                        $transaction->commit();
                        echo CJSON::encode(array(
                            'status' => 'proses_form',
                            'div' => "<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
                        ));
                    } else {
                        echo CJSON::encode(array(
                            'status' => 'proses_form',
                            'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
                        ));
                    }
                    exit;
                } catch (Exception $exc) {
                    $transaction->rollback();
                }
            } else {
                echo CJSON::encode(
                        array(
                            'status' => 'proses_form',
                            'div' => "<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
                        )
                );
                exit;
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(array(
                'status' => 'create_form',
                'div' => $this->renderPartial('_formUbahDokterPeriksa', array('model' => $model, 'modUbahDokter' => $modUbahDokter, 'menu' => $menu), true)));
            exit;
        }
    }

    /**
     * digunakan untuk mengambil dara pedaftaran hemodialisa
     */
    public function actionGetDataPendaftaranHD() {
        if (Yii::app()->request->isAjaxRequest) {
            $id_pendaftaran = $_POST['pendaftaran_id'];
            $model = HDInfoKunjunganRDV::model()->findByAttributes(array('pendaftaran_id' => $id_pendaftaran));
            $attributes = $model->attributeNames();
            foreach ($attributes as $j => $attribute) {
                $returnVal["$attribute"] = $model->$attribute;
                $returnVal["gelarbelakang_nama"] = isset($model->gelarbelakang_nama) ? $model->gelarbelakang_nama : "";
                $returnVal["gelardepan"] = isset($model->gelardepan) ? $model->gelardepan : "";
            }
            echo json_encode($returnVal);
            Yii::app()->end();
        }
    }

    /**
     * digunakan untuk mengambil list dokter ruangan
     */
    public function actionListDokterRuangan() {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            if (!empty($_POST['idRuangan'])) {
                $idRuangan = $_POST['idRuangan'];
                $data = DokterV::model()->findAllByAttributes(array('ruangan_id' => $idRuangan), array('order' => 'nama_pegawai'));
                $data = CHtml::listData($data, 'pegawai_id', 'nama_pegawai');

                if (empty($data)) {
                    $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    foreach ($data as $value => $name) {
                        $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }

                $dataList['listDokter'] = $option;
            } else {
                $dataList['listDokter'] = $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            }

            echo json_encode($dataList);
            Yii::app()->end();
        }
    }

    /**
     * Untuk cek tagihan pasien pada saat batal periksa
     */
    public function actionCekTagihan() {
        if (Yii::app()->request->isAjaxRequest) {
            $status_tindakan = false;
            $status_obat = false;
            $status_batal = true;
            $pesan = '';
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;

            $criteriaTindakan = new CDbCriteria();
            $criteriaTindakan->addCondition('pendaftaran_id = ' . $pendaftaran_id);
            $criteriaTindakan->addCondition('tindakansudahbayar_id is not null');

            $modTindakanPelayanan = TindakanpelayananT::model()->find($criteriaTindakan);

            $criteriaObat = new CDbCriteria();
            $criteriaObat->addCondition('pendaftaran_id = ' . $pendaftaran_id);
            $criteriaObat->addCondition('oasudahbayar_id is not null');
            $modObatalkesPasien = ObatalkespasienT::model()->find($criteriaObat);

            if ($modTindakanPelayanan) {
                $status_tindakan = true;
            }

            if ($modObatalkesPasien) {
                $status_obat = true;
            }

            if ($status_tindakan == true || $status_obat == true) {
                $status_batal = false;
                $pesan = "Pemeriksaan tidak bisa dibatalkan karena ada tindakan/obat yang sudah dibayarkan. Silakan hubungi Kasir!";
            } else {
                $status_batal = true;
            }

            $data['status_tindakan'] = $status_tindakan;
            $data['status_obat'] = $status_obat;
            $data['status_batal'] = $status_batal;
            $data['pesan'] = $pesan;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * digunakan untuk cek login batal pemeriksaan
     * @param type string $task
     */
    public function actionCekLoginBatalPemeriksaan($task = 'BatalPemeriksaanPasien') {
        if (Yii::app()->request->isAjaxRequest) {
            $username = isset($_POST['nama_pemakai']) ? $_POST['nama_pemakai'] : null;
            $password = isset($_POST['kata_kunci']) ? $_POST['kata_kunci'] : null;
            $ruangan_id = Yii::app()->user->getState('ruangan_id');

            $user = LoginpemakaiK::model()->findByAttributes(array('nama_pemakai' => $username,
                'loginpemakai_aktif' => TRUE));
            if ($user === null) {
                $data['error'] = "Login Pemakai salah!";
                $data['cssError'] = 'username';
                $data['status'] = 'Gagal Login';
            } else {
                // cek password
                if ($user->katakunci_pemakai !== $user->encrypt($password)) {
                    $data['error'] = 'password salah!';
                    $data['cssError'] = 'password';
                    $data['status'] = 'Gagal Login';
                } else {
                    // cek ruangan
                    $ruangan_user = RuanganpemakaiK::model()->findByAttributes(array('loginpemakai_id' => $user->loginpemakai_id,
                        'ruangan_id' => $ruangan_id));
                    if ($ruangan_user === null) {
                        $data['error'] = 'ruangan salah!';
                        $data['status'] = 'Gagal Login';
                    } else {
                        $data['error'] = '';
                        $cek = $this->checkAccess(array('loginpemakai_id' => $user->loginpemakai_id)); //dari MyAuthController
                        if ($cek) {
                            $data['status'] = 'success';
                            $data['userid'] = $user->loginpemakai_id;
                            $data['username'] = $user->nama_pemakai;
                        } else {
                            $data['status'] = 'Tidak memiliki akses untuk melakukan pembatalan!';
                        }
                    }
                }
            }

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /*
     * Ubah Status Periksa Pasien Baru -- Yang Pake Button
     */

    public function actionUbahStatusPeriksaPasien() {
        $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
        $status = isset($_POST['status']) ? $_POST['status'] : null;
        $model = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modBatalPeriksa = new PasienbatalperiksaR;
        $model->tglselesaiperiksa = date('Y-m-d H:i:s');
        $update = '';
        if (isset($_POST['status'])) {
            if ($status == "ANTRIAN") {
                $update = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
            } else {
                if ($status == "SEDANG PERIKSA") {
                    $update = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA));
                } else if ($status == "SEDANG DIRAWAT INAP") {
                    $update = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SUDAH_PULANG));
                } else if ($status == "SUDAH DIPERIKSA") {
                    $update = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SUDAH_PULANG));
                    $modPasienPulang = new PasienpulangT();
                    $modPasienPulang->pasien_id = $modPendaftaran->pasien_id;
                    $modPasienPulang->carakeluar_id = Params::CARAKELUAR_ID_DIPULANGKAN;
                    $modPasienPulang->kondisikeluar_id = Params::DEFAULT_KONDISIKELUAR_ID;
                    $modPasienPulang->tglpasienpulang = date('Y-m-d H:i:s');
                    $modPasienPulang->ruanganakhir_id = Yii::app()->user->getState('ruangan_id');
                    $modPasienPulang->create_time = date('Y-m-d H:i:s');
                    $modPasienPulang->create_loginpemakai_id = Yii::app()->user->id;
                    $modPasienPulang->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $modPasienPulang->save();
                }
            }
            if ($update) {
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode(array(
                        'status' => 'proses_form',
                        'div' => "<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
                    ));
                    exit;
                }
            } else {
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode(array(
                        'status' => 'proses_form',
                        'div' => "<div class='flash-error'>Data Pasien <b></b> gagal disimpan </div>",
                    ));
                    exit;
                }
            }
        }
    }

    /**
     * ubah status dokumen
     */
    public function actionStatusDokumenTerima() {
        if (Yii::app()->request->isAjaxRequest) {
            $pendaftaran_id = $_POST['pendaftaran_id'];
            $pengirimanrm_id = $_POST['pengirimanrm_id'];
            $statusdok = $_POST['status'];
            $update = false;
            $status = '';
            $div = '';
            $model = PendaftaranT::model()->findByPk($pendaftaran_id);
            if (!empty($pengirimanrm_id)) {
                $modPenerimaanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
                $modPenerimaanRm->tglterimadokrm = date('Y-m-d H:i:s');
                $modPenerimaanRm->petugaspenerima_id = Yii::app()->user->id;
                $modPenerimaanRm->ruanganpenerima_id = Yii::app()->user->getState('ruangan_id');
                if ($modPenerimaanRm->save()) {
                    $model->statusdokrm = 'SUDAH DITERIMA';
                    $model->save();
                    $update = true;
                } else {
                    $update = false;
                }
            }

            if ($update == true) {
                $status = 'proses_form';
                $div = "<div class='flash-success'>Data Dokumen Pasien <b></b> berhasil diterima </div>";
            } else {
                $status = 'proses_form';
                $div = "<div class='flash-error'>Data Dokumen Pasien <b></b> gagal diterima </div>";
            }

            echo CJSON::encode(array(
                'status' => $status,
                'div' => $div,
            ));
            exit;
        }
    }

    /**
     * Pengiriman Dokumen RM
     */
    public function actionStatusDokumenKirim($pengirimanrm_id, $pendaftaran_id) {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter();
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $status = false;
        if (!empty($pengirimanrm_id)) {
            $modPengirimanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
        } else {
            $modPengirimanRm = new PengirimanrmT();
        }


        $pegawai_id = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai_id;
        $modUbahStatus = new PengirimanrmT;
        $modUbahStatus->tglpengirimanrm = date('d/m/Y H:i:s');
        $modPegawai = PegawaiM::model()->findByPk($pegawai_id);
        $modUbahStatus->petugaspengirim = $modPegawai->namaLengkap;
        $modUbahStatus->petugaspengirim_id = $pegawai_id;

        if (isset($_POST['PengirimanrmT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modUbahStatus->attributes = $_POST['PengirimanrmT'];
                $modUbahStatus->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $modUbahStatus->pasien_id = $modPendaftaran->pasien_id;
                $modUbahStatus->dokrekammedis_id = isset($modPengirimanRm) ? $modPengirimanRm->dokrekammedis_id : null;
                $modUbahStatus->nourut_keluar = MyGenerator::noUrutKeluarRM();
                $modUbahStatus->tglpengirimanrm = $format->formatDateTimeForDb($_POST['PengirimanrmT']['tglpengirimanrm']);
                $modUbahStatus->kelengkapandokumen = TRUE;
                $modUbahStatus->petugaspengirim_id = $_POST['PengirimanrmT']['petugaspengirim_id'];
                $modUbahStatus->create_time = date('Y-m-d H:i:s');
                $modUbahStatus->create_loginpemakai_id = Yii::app()->user->id;
                $modUbahStatus->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $modUbahStatus->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');

                if ($modUbahStatus->save()) {
                    $modPendaftaran->statusdokrm = 'SUDAH DIKIRIM';
                    $modPendaftaran->save();

                    $transaction->commit();
                    $status = true;
                    Yii::app()->user->setFlash('success', "Data pengiriman dokumen pasien berhasil disimpan !");
                } else {
                    $status = false;
                    Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data pengiriman dokumen pasien gagal disimpan');
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                $status = false;
                Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan' . MyExceptionMessage::getMessage($exc));
            }
        }

        $this->render('_formStatusDokumen', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modPengirimanRm' => $modPengirimanRm,
            'modUbahStatus' => $modUbahStatus,
            'status' => $status
        ));
    }

    /**
     * penghapusan dokumen RM
     */

    /**
     * ubah status dokumen
     */
    public function actionHapusDokumenPengiriman() {
        if (Yii::app()->request->isAjaxRequest) {
            $pendaftaran_id = $_POST['pendaftaran_id'];
            $pengirimanrm_id = $_POST['pengirimanrm_id'];
            $statusdok = $_POST['status'];
            $delete = false;
            $status = '';
            $div = '';
            $model = PendaftaranT::model()->findByPk($pendaftaran_id);
            if (!empty($pengirimanrm_id)) {
                $model->pengirimanrm_id = null;
                $modPenerimaanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
                if ($model->save()) {
                    $modPenerimaanRm->delete();
                    $delete = true;
                } else {
                    $delete = false;
                }
            }

            if ($delete == true) {
                $status = 'proses_form';
                $div = "<div class='flash-success'>Data Dokumen Pasien <b></b> berhasil dihapus </div>";
            } else {
                $status = 'proses_form';
                $div = "<div class='flash-error'>Data Dokumen Pasien <b></b> gagal dihapus </div>";
            }

            echo CJSON::encode(array(
                'status' => $status,
                'div' => $div,
            ));
            exit;
        }
    }

    /**
     * ambil status penerimaan dokumen
     */
    public function actionGetStatusPenerimaan() {
        if (Yii::app()->request->isAjaxRequest) {
            $pendaftaran_id = $_POST['pendaftaran_id'];
            $pengirimanrm_id = $_POST['pengirimanrm_id'];
            $ruanganpenerimaan_id = $_POST['ruanganpenerimaan_id'];
            $statusdok = $_POST['status'];
            $penerimaan = false;
            $div = '';
            $ruangan = '';
            $model = PendaftaranT::model()->findByPk($pendaftaran_id);
            if (!empty($pengirimanrm_id)) {
                $modPenerimaanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
                if ($modPenerimaanRm->ruanganpenerimaan_id == $ruanganpenerimaan_id) {
                    $penerimaan = true;
                }
            }

            if ($penerimaan == true) {
                $div = "<div class='flash-success'>Dokumen Sudah Diterima Oleh Ruangan  <b>" . $ruangan . "</b></div>";
            } else {
                $div = "<div class='flash-error'>Dokumen Belum Diterima Oleh Ruangan  <b>" . $ruangan . "</b></div>";
            }

            echo CJSON::encode(array(
                'div' => $div,
            ));
            exit;
        }
    }

    /**
     * Mengatur dropdown ruangan
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $instalasi_id = null;
            if ($model_nama !== '' && $attr == '') {
                $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
            } else if ($model_nama == '' && $attr !== '') {
                $instalasi_id = $_POST["$attr"];
            } else if ($model_nama !== '' && $attr !== '') {
                $instalasi_id = $_POST["$model_nama"]["$attr"];
            }
            $models = null;
            $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

            if ($encode) {
                echo CJSON::encode($models);
            } else {
                echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                if (count($models) > 0) {
                    foreach ($models as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    public function actionJadwalHD($pasien_id) {
        $this->layout = '//layouts/iframe';

        $modPendaftaran = HDPendaftaranT::model()->findByPk($pasien_id);
        $modPasien = HDPasienM::model()->findByPk($pasien_id);
        $modJadwalHD = new HDJadwalhemodialisaT;
        $modJadwalHD->bulan_daftar = date('m');
        $modJadwalHD->tahun_daftar = date('Y');

        $criteria = new CdbCriteria();
        $criteria->select = "jadwalhemodialisa_tgl_ke,jadwalhemodialisa_status,bataljadwalhd_id,pendaftaran_id,gantijadwalhd_id,shift_id";
        $criteria->addCondition("pasien_id = " . $modPasien->pasien_id);

        if (isset($_POST['HDJadwalhemodialisaT'])) {
            $modJadwalHD->bulan_daftar = !empty($_POST['HDJadwalhemodialisaT']['bulan_daftar']) ? date('m', strtotime($_POST['HDJadwalhemodialisaT']['bulan_daftar'])) : date('m');
            $modJadwalHD->tahun_daftar = !empty($_POST['HDJadwalhemodialisaT']['bulan_daftar']) ? date('Y', strtotime($_POST['HDJadwalhemodialisaT']['bulan_daftar'])) : date('Y');
            $modJadwalHD->pasien_id = $modPasien->pasien_id;
            $criteria->addCondition("EXTRACT(MONTH FROM jadwalhemodialisa_tgl_ke) = " . date('m', strtotime($_POST['HDJadwalhemodialisaT']['bulan_daftar'])));
            $criteria->addCondition("EXTRACT(YEAR FROM jadwalhemodialisa_tgl_ke) = " . date('Y', strtotime($_POST['HDJadwalhemodialisaT']['bulan_daftar'])));
        } else {
            $criteria->addCondition("EXTRACT(MONTH FROM jadwalhemodialisa_tgl_ke) = " . date('m'));
            $criteria->addCondition("EXTRACT(YEAR FROM jadwalhemodialisa_tgl_ke) = " . date('Y'));
        }

        $criteria->order = 'pendaftaran_id ASC';
        $modJadwal = HDJadwalhemodialisaT::model()->findAll($criteria);

        $this->render('_jadwalHD', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modJadwalHD' => $modJadwalHD,
            'modJadwal' => $modJadwal));
    }

    public function actionUbahKamarRuangan() {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter();
        $pendaftaran_id = $_GET['pendaftaran_id'];
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        if (isset($_POST['PendaftaranT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modPendaftaran->kamarruangan_id = $_POST['PendaftaranT']['kamarruangan_id'];
                if ($modPendaftaran->save()) {
                    $transaction->commit();
                    $this->redirect(array('ubahKamarRuangan', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1));
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                $status = false;
                Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan' . MyExceptionMessage::getMessage($exc));
            }
        }
        $this->render('_formUbahKamar', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
        ));
    }

    public function actionGetRiwayatPasien($id) {
        $this->layout = '//layouts/iframe';

        $criteria = new CDbCriteria(array(
            'condition' => 't.pasien_id = ' . $id,
            //.'
            //      and t.ruangan_id ='.Yii::app()->user->getState('ruangan_id'),
            'order' => 'tgl_pendaftaran DESC',
        ));

        $pages = new CPagination(HDPendaftaranT::model()->count($criteria));
        $pages->pageSize = Params::JUMLAH_PERHALAMAN; //Yii::app()->params['postsPerPage'];
        $pages->applyLimit($criteria);

        $modKunjungan = HDPendaftaranT::model()->with('hasilpemeriksaanlab', 'anamnesa', 'pemeriksaanfisik', 'pasienmasukpenunjang', 'diagnosa')->
                findAll($criteria);


        $this->render('rawatJalan.views._periksaDataPasien._riwayatPasien', array(
            'pages' => $pages,
            'modKunjungan' => $modKunjungan,
        ));
    }

    public function actionDetailPersalinan($id) {
        $this->layout = '//layouts/iframe';
        $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
        $modPersalinan = PersalinanT::model()->findAllByAttributes(array('pendaftaran_id' => $id));
        $format = new MyFormatter;
        $modPersalinanSearch = new PersalinanT('search');
        $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
        $modPemeriksaan = PemeriksaanfisikT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));

        $this->render($this->path_view_riwayat . '_persalinan', array('modPendaftaran' => $modPendaftaran,
            'modPersalinan' => $modPersalinan,
            'modPersalinanSearch' => $modPersalinanSearch,
            'modPasien' => $modPasien,
            'modPemeriksaan' => $modPemeriksaan));
    }

    public function actionDetailKelahiran($id) {
        $this->layout = '//layouts/iframe';
        $modKelahiran = array();
        $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
        $modPersalinan = PersalinanT::model()->findAllByAttributes(array('pendaftaran_id' => $id));
        foreach ($modPersalinan as $persalinan) {
            $modKelahiran = KelahiranbayiT::model()->findByAttributes(array('persalinan_id' => $persalinan->persalinan_id));
        }
        $format = new MyFormatter;
        $modKelahiranSearch = new KelahiranbayiT('search');
        $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
        $this->render($this->path_view_riwayat . '_kelahiran', array('modPendaftaran' => $modPendaftaran,
            'modKelahiran' => $modKelahiran,
            'modKelahiranSearch' => $modKelahiranSearch,
            'modPasien' => $modPasien));
    }

    public function actionDetailAnamnesa($id) {
        $this->layout = '//layouts/iframe';
        $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
        $modAnamnesa = RJAnamnesaT::model()->findAllByAttributes(array('pendaftaran_id' => $id));
        $format = new MyFormatter;
        $modAnamnesaSearch = new RJAnamnesaT('search');
        $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
        $this->render($this->path_view_riwayat . '_anamnesa', array('modPendaftaran' => $modPendaftaran,
            'modAnamnesa' => $modAnamnesa,
            'modAnamnesaSearch' => $modAnamnesaSearch,
            'modPasien' => $modPasien));
    }

    public function actionDetailPeriksaFisik($id) {
        $this->layout = '//layouts/iframe';
        $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
        $modPemeriksaanFisik = RJPemeriksaanFisikT::model()->findAllByAttributes(array(
            'pendaftaran_id' => $id), array('order' => 'create_time DESC'));
        $format = new MyFormatter;
        $modPemeriksaanFisikSearch = new RJPemeriksaanFisikT('search');
        $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
        $modPemeriksaanGambar = RJPemeriksaangambarT::model()->findAllByAttributes(array(
            'pendaftaran_id' => $id));
        $this->render($this->path_view_riwayat . '_periksafisik', array('modPendaftaran' => $modPendaftaran,
            'modPemeriksaanFisik' => $modPemeriksaanFisik,
            'modPemeriksaanFisikSearch' => $modPemeriksaanFisikSearch,
            'modPasien' => $modPasien,
            'modPemeriksaanGambar' => $modPemeriksaanGambar));
    }

//    public function actionDetailTerapi($id) {
//        $this->layout = '//layouts/iframe';
//        $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
//        $modTerapi = ResepturT::model()->findAllByAttributes(array('pendaftaran_id' => $id));
//        $modDetailTerapi = new RJResepturDetailT('searchDetailTerapi');
//        $format = new MyFormatter;
//        $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
//        $modPemeriksaan = PemeriksaanfisikT::model()->findAllByAttributes(array('pendaftaran_id'=>$id));
//
//        $this->render($this->path_view_riwayat . '_terapi', array('modPendaftaran' => $modPendaftaran,
//            'modTerapi' => $modTerapi,
//            'modDetailTerapi' => $modDetailTerapi,
//            'modPasien' => $modPasien,
//            'modPemeriksaan' => $modPemeriksaan));
//    }
    
    
   public function actionDetailTerapi($id)
    {
        $this->layout='//layouts/iframe';
        $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
            
        $penjualan = PenjualanresepT::model()->findAllByAttributes(
            array(
                'pendaftaran_id'=>$id,
            ), array('order' => 'tglpenjualan DESC')
        );
            
        $prereseptur = ResepturT::model()->findAllByAttributes(
            array(
                'pendaftaran_id'=>$id,
            ), array('order'=> 'tglreseptur DESC')
        );
            
        $reseptur = array();
            
        foreach ($prereseptur as $item) {
            $item->tglreseptur = MyFormatter::formatDateTimeForDb($item->tglreseptur);
            foreach ($penjualan as $item2) {
                if ($item->reseptur_id == $item2->reseptur_id || $item->penjualanresep_id == $item2->penjualanresep_id) {
                    continue;
                }
            }
            array_push($reseptur, $item);
        }
            
            
            
        $checkers = array();
            
        foreach ($reseptur as $item) {
            $checkers[$item->tglreseptur] = array(
                    'tipe'=>1,
                    'noresep'=>$item->noresep,
                    'id'=>$item->reseptur_id,
                );
        }
            
            
            
        foreach ($penjualan as $item) {
            $checkers[$item->tglresep] = array(
                    'tipe'=>2,
                    'noresep'=>$item->noresep,
                    'id'=>$item->penjualanresep_id,
                );
        }
            
        $this->render(
            $this->path_view_riwayat . '/_terapi',
            array('modPendaftaran'=>$modPendaftaran,
                        'checkers'=>$checkers)
        );
           
    } 
    
    
    

    public function actionDetailPemakaianBahan($id) {
        $this->layout = '//layouts/iframe';
        $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
        $modBahan = RJObatalkesPasienT::model()->with('obatalkes')->findAllByAttributes(array(
            'pendaftaran_id' => $id));
        $format = new MyFormatter;
        $modPemakaianBahan = new RJObatalkesPasienT;
        $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
        $this->render($this->path_view_riwayat . '_pemakaianBahan', array('modPendaftaran' => $modPendaftaran,
            'modBahan' => $modBahan,
            'modPemakaianBahan' => $modPemakaianBahan,
            'modPasien' => $modPasien));
    }

    public function actionDetailHasilLab($pasienmasukpenunjang_id) {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter();
        $judulLaporan = "Hasil Pemeriksaan Laboratorium";
        $modKunjungan = RJPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        $modHasilPemeriksaan = RJHasilpemeriksaanlabT::model()->findByAttributes(array(
            'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        $criteria = new CDbCriteria();
        $criteria->join = "
							JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id 
							JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = t.pemeriksaanlabdet_id 
							JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id";
        $criteria->addCondition('t.hasilpemeriksaanlab_id = ' . $modHasilPemeriksaan->hasilpemeriksaanlab_id);
//		$criteria->order = "pemeriksaanlab_m.pemeriksaanlab_urutan ASC, pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
        $criteria->order = "pemeriksaanlab_m.pemeriksaanlab_id ASC, pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC"; //RSKG-1453
        $modDetailHasilPemeriksaans = RJDetailhasilpemeriksaanlabT::model()->findAll($criteria);
        $this->render('rawatInap.views.riwayatPasien.detailHasilLab', array(
            'format' => $format,
            'modKunjungan' => $modKunjungan,
            'modHasilPemeriksaan' => $modHasilPemeriksaan,
            'modDetailHasilPemeriksaans' => $modDetailHasilPemeriksaans,
            'judulLaporan' => $judulLaporan,
        ));
    }

    public function actionDetailKonsul($id) {
        $this->layout = '//layouts/iframe';
        $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
        $modRiwayatKonsulSearch = new RJKonsulPoliT('search');
        $format = new MyFormatter;
        $this->render($this->path_view_riwayat . '_detailkonsulpoli', array('modPendaftaran' => $modPendaftaran,
            'modRiwayatKonsulSearch' => $modRiwayatKonsulSearch));
    }

    public function actionDetailTindakan($id) {
        $this->layout = '//layouts/iframe';
        $modPendaftaran = RJPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);

        // var_dump($id);exit();

        $modTindakan = RJTindakanPelayananT::model()->with('daftartindakan')->findAllByAttributes(array(
            'pendaftaran_id' => $id));
        $format = new MyFormatter;
        $modTindakanSearch = new RJTindakanPelayananT('search');
        $modPasien = RJPasienM::model()->findByPK($modPendaftaran->pasien_id);
        $this->render($this->path_view_riwayat . '_tindakan', array('modPendaftaran' => $modPendaftaran,
            'modTindakan' => $modTindakan,
            'modTindakanSearch' => $modTindakanSearch,
            'modPasien' => $modPasien));
    }

    /**
     * action ketika tombol panggil di klik
     */
    public function actionPanggil() {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $data = array();
            $data['pesan'] = "";
            $pendaftaran_id = ($_POST['pendaftaran_id']);
            $keterangan = (isset($_POST['keterangan']) ? $_POST['keterangan'] : null);
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

            $nama_modul = Yii::app()->controller->module->id;
            $nama_controller = Yii::app()->controller->id;
            $nama_action = Yii::app()->controller->action->id;
            $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
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

            if (isset($modPendaftaran)) {
                if ($modPendaftaran->panggilantrian == true) {
                    if ($keterangan == "batal") {
                        $modPendaftaran->panggilantrian = false;
                        if ($modPendaftaran->update()) {

                            $data['pesan'] = "Pemanggilan no. antrian " . $modPendaftaran->no_urutantri . " dibatalkan !";
                        }
                    } else {
                        $modPendaftaran->waktupanggilpasien = date('Y-m-d H:i:s');
                        $modPendaftaran->update();
                        $data['pesan'] = "No. antrian " . $modPendaftaran->no_urutantri . " dipanggil !";
                    }
                    $data['smspasien'] = 1;
                } else {
                    $modPendaftaran->panggilantrian = true;
                    $modPendaftaran->waktupanggilpasien = date('Y-m-d H:i:s');
                    if ($modPendaftaran->update()) {
                        // SMS GATEWAY
                        $modPasien = $modPendaftaran->pasien;
                        $sms = new Sms();
                        $smspasien = 1;
                        foreach ($modSmsgateway as $i => $smsgateway) {
                            $isiPesan = $smsgateway->templatesms;

                            $attributes = $modPasien->getAttributes();
                            foreach ($attributes as $attributes => $value) {
                                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                            }
                            $attributes = $modPendaftaran->getAttributes();
                            foreach ($attributes as $attributes => $value) {
                                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                            }

                            if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                                if (!empty($modPasien->no_mobile_pasien)) {
                                    $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                                } else {
                                    $smspasien = 0;
                                }
                            }
                        }
                        // END SMS GATEWAY
                        /* $data['smspasien'] = $smspasien;
                          $data['nama_pasien'] = $modPendaftaran->pasien->nama_pasien;
                          $data['pesan'] = "No. antrian ".$modPendaftaran->no_urutantri." dipanggil !";
                          $data_telnet = $modPendaftaran->ruangan->ruangan_nama.", ".$modPendaftaran->ruangan->ruangan_singkatan."-".$modPendaftaran->no_urutantri; */
//							CustomFunction::postTelnet($data_telnet); //fungsi komen karena load menjadi lama/crash jika koneksi tidak ditemukan
                    }
                }
            }
            $attributes = $modPendaftaran->attributeNames();
            foreach ($attributes as $i => $attribute) {
                $data["$attribute"] = $modPendaftaran->$attribute;
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
    
     /**
     * action ketika tombol panggil di klik
     */
    public function actionVerifikasiAntrian()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $data = array();
            $data['pesan']="";
            $pendaftaran_id = ($_POST['pendaftaran_id']);
           // $konsupoli_id = ($_POST['konsupoli_id']);
            $modPendaftaran =  PendaftaranT::model()->findByPk($pendaftaran_id);
            if (empty($_POST['konsulpoli_id'])){
                $modPendaftaran->status_hd = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
                $modPendaftaran->statusperiksa = Params::STATUSPERIKSA_SEDANG_PERIKSA;
            }else{
                $konsul = KonsulpoliT::model()->findByPk($_POST['konsulpoli_id']);
                $konsul->statusperiksa = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
                $konsul->save();
            }
            $modPendaftaran->waktuverifikasipasien = date('Y-m-d H:i:s');
            if(!empty($modPendaftaran->waktupanggilpasien)){
                if($modPendaftaran->update()){
                    $data['pesan']="";
                }else{
                    $data['pesan']="Verifikasi gagal dilakukan";
                }
            }else{
                $data['pesan']="Antrian belum dilakukan pemanggilan";
            }
            
            echo CJSON::encode($data);
            Yii::app()->end();
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionStatusHemodialisa($pendaftaran_id, $pasienmasukpenunjang_id = null) {

        $this->layout = '//layouts/iframe';

        $model = HDPendaftaranT::model()->findByPk($pendaftaran_id);
        $model->status_lama = $model->status_hd;

        if (isset($_POST['HDPendaftaranT'])) {
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();

            try {
                $model->status_hd = $_POST['HDPendaftaranT']['status_hd'];
                $ok & $model->save();
                
                if(!empty($pasienmasukpenunjang_id)) {
                    $ok = PasienmasukpenunjangT::model()->updateByPk($pasienmasukpenunjang_id, ['statusperiksa' => $_POST['HDPendaftaranT']['status_hd']]);
                }
               

                if ($ok) {
                    $trans->commit();
                    // Yii::app()->user->setFlash('success', "Data berhasil diupdate! ");
                    $this->redirect(array('StatusHemodialisa', 'pendaftaran_id' => $model->pendaftaran_id, 'sukses' => 1));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal diupdate! ");
                }
            } catch (Exception $ex) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal diupdate! " . $ex->getMessage());
            }
        }

        $this->render("StatusHemodialisa", array(
            'model' => $model,
        ));
    }

}

?>
