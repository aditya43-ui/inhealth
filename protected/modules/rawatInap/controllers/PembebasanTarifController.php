<?php
class PembebasanTarifController extends MyAuthController
{
  public $successSavePembebasan = true;
  public $pathView = "rawatInap.views.pembebasanTarif.";

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pembebasan Tarif";
    $modPasien = new RIPasienM;
    $modPendaftaran = new RIPendaftaranT;
    $model = new RIPembebasantarifT;
    $model->tglpembebasan = date('d M Y H:i:s');

    if (isset($_POST[get_class($model)])) {
      $model->attributes = $_POST[get_class($model)];
      $modPendaftaran = RIPendaftaranT::model()->findByPk($_POST[get_class($modPendaftaran)]['pendaftaran_id']);
      $modPasien = RIPasienM::model()->findByPk($_POST[get_class($modPendaftaran)]['pasien_id']);


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

      if (isset($_POST['pembebasan'])) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $simpan = true;
          foreach ($_POST['pembebasan'] as $tindkomponen_id => $dataPembebasan) {
            $tindkomponen_id_post = (isset($dataPembebasan['tindkomponen_id']) ? $dataPembebasan['tindkomponen_id'] : null);
            if ($tindkomponen_id_post != null) {
              if ($tindkomponen_id == $tindkomponen_id_post) {
                $model = $this->savePembebasan($model, $dataPembebasan);
                if ($this->successSavePembebasan) {
                  $simpan &= true;
                } else {
                  $simpan &= false;
                }
              } else {
                $simpan &= false;
              }
            }
          }
          $tindakan = $this->saveTindakanPelayanan($_POST['pembebasan']);

          if ($simpan) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data Berhasil Disimpan ");
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        }
      }
    }

    $this->render($this->pathView . 'index', array(
      'model' => $model,
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran
    ));
  }

  protected function savePembebasan($model, $dataPembebasan)
  {
    $format = new MyFormatter;
    $modPembebasan = new RIPembebasantarifT;
    $modPembebasan->attributes = $model->attributes;
    $modPembebasan->tglpembebasan = $format->formatDateTimeForDb(trim($modPembebasan->tglpembebasan));
    $modPembebasan->tindakanpelayanan_id = $dataPembebasan['tindakanpelayanan_id'];
    $modPembebasan->komponentarif_id = $dataPembebasan['komponentarif_id'];
    $modPembebasan->jmlpembebasan = $dataPembebasan['tarif_tindakankomp'];
    $modPembebasan->loginpemakai_id = Yii::app()->user->id;
    if ($modPembebasan->validate()) {
      $modPembebasan->save();
      //                $tindakan = $this->saveTindakanPelayanan($dataPembebasan);
      //                if($tindakan){
      //                    $this->successSavePembebasan = $this->successSavePembebasan && true;
      //                }else{
      //                    $this->successSavePembebasan = false;
      //                }
      $this->successSavePembebasan = true;
    } else
      $this->successSavePembebasan = false;

    return $modPembebasan;
  }

  protected function saveTindakanPelayanan($dataPembebasan)
  {
    $is_simpan = false;

    $rows = array();

    foreach ($dataPembebasan as $i => $pembebasan) {
      $tindkomponen_id_post = (isset($pembebasan['tindkomponen_id']) ? $pembebasan['tindkomponen_id'] : null);
      if ($tindkomponen_id_post != null) {
        $tindakanpelayanan_id = $pembebasan['tindakanpelayanan_id'];

        $rows[$tindakanpelayanan_id]['tindakanpelayanan_id'] = $pembebasan['tindakanpelayanan_id'];
        $rows[$tindakanpelayanan_id]['komponentarif_id'] = $pembebasan['komponentarif_id'];
        $rows[$tindakanpelayanan_id]['tindakan'][$i]['komponentarif_id'] = $pembebasan['komponentarif_id'];
        $rows[$tindakanpelayanan_id]['tindakan'][$i]['tindakanpelayanan_id'] = $pembebasan['tindakanpelayanan_id'];
        $rows[$tindakanpelayanan_id]['tindakan'][$i]['tarif_tindakankomp'] = $pembebasan['tarif_tindakankomp'];
      }
    }

    foreach ($rows as $j => $row) {
      $pembebasan_tindakan = 0;
      $tindakanpelayanan_id = $row['tindakanpelayanan_id'];
      $attributes = array();
      foreach ($row['tindakan'] as $val) {
        $pembebasan_tindakan += $val['tarif_tindakankomp'];
      }
      $modTindakan = RITindakanPelayananT::model()->findByPk($tindakanpelayanan_id);

      $subsidiasuransi_tindakan = $modTindakan->subsidiasuransi_tindakan;
      $subsidipemerinah_tindakan = $modTindakan->subsidipemerintah_tindakan;
      $subsidirumahsakit_tindakan = $modTindakan->subsisidirumahsakit_tindakan;
      $subsidi = $subsidiasuransi_tindakan + $subsidipemerinah_tindakan + $subsidirumahsakit_tindakan;
      $tarif_satuan = $modTindakan->tarif_satuan;
      $qty_tindakan = $modTindakan->qty_tindakan;
      $pembebasan_tindakan = $pembebasan_tindakan;
      $iurbiaya_tindakan = 0;


      $attributes['pembebasan_tindakan'] = $pembebasan_tindakan;
      //				$attributes['iurbiaya_tindakan'] = $iurbiaya_tindakan; // tidak perlu di update untuk kolom iurbiaya_tindakan-nya

      if (count((array)$attributes) > 0) {
        $total = 0;
        foreach ($attributes as $key => $val) {
          $total += $val;
        }
        $tindakan = RITindakanPelayananT::model()->updateByPk($tindakanpelayanan_id, $attributes);

        if ($tindakan) {
          $is_simpan = true;
        }
      }
    }
    return $is_simpan;
  }
  /**
   * action untuk load tindakan komponen pasien ketika dipilih no rekam medik
   */
  public function actionLoadTindakanKomponenPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;

      $tindakans = TindakanpelayananT::model()->with('daftartindakan')->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'dokterpemeriksa1_id' => $pegawai_id));
      if (count((array)$tindakans) > 0) {
        foreach ($tindakans as $i => $tindakan) {
          $returnVal[$tindakan->tindakanpelayanan_id]['daftartindakan_id'] = $tindakan->daftartindakan_id;
          $returnVal[$tindakan->tindakanpelayanan_id]['daftartindakan_nama'] = $tindakan->daftartindakan->daftartindakan_nama;
          if (!empty($pegawai_id)) {
            $komponentarif_id = array(Params::KOMPONENTARIF_ID_TOTAL);
            $criteria = new CDbCriteria();
            $criteria->addCondition('tindakanpelayanan_id = ' . $tindakan->tindakanpelayanan_id);
            $criteria->addNotInCondition('komponentarif_id', $komponentarif_id);
            $komponens = TindakankomponenT::model()->findAll($criteria);
          } else {
            $komponens = TindakankomponenT::model()->findAllByAttributes(array('tindakanpelayanan_id' => $tindakan->tindakanpelayanan_id));
          }

          foreach ($komponens as $j => $komponen) {
            $tindKomponenId = $komponen->tindakankomponen_id;
            $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['tindakankomponen_id'] = $tindKomponenId;
            $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['komponentarif_id'] = $komponen->komponentarif_id;
            $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['komponentarif_nama'] = $komponen->komponentarif->komponentarif_nama;
            $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['tarif_kompsatuan'] = $komponen->tarif_kompsatuan;
            $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['tarif_tindakankomp'] = $komponen->tarif_tindakankomp;
            $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['tarifcyto_tindakankomp'] = $komponen->tarifcyto_tindakankomp;
            $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['subsidiasuransikomp'] = $komponen->subsidiasuransikomp;
            $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['subsidipemerintahkomp'] = $komponen->subsidipemerintahkomp;
            $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['subsidirumahsakitkomp'] = $komponen->subsidirumahsakitkomp;
            $returnVal[$tindakan->tindakanpelayanan_id][$tindKomponenId]['iurbiayakomp'] = $komponen->iurbiayakomp;
          }
        }
      } else {
        $returnVal = array();
      }

      $form = $this->renderPartial($this->pathView . '_formPembebasanTarif', array('data' => $returnVal), true);
      $returnVal['tabelPembebasanTarif'] = $form;

      echo CJSON::encode($returnVal);
    }
  }

  /**
   * untuk load data pasien
   */
  public function actionDataPasien()
  {
    $pasien_id = $_POST['pasien_id'];
    $pendaftaran_id = $_POST['pendaftaran_id'];
    $modPasien = RIPasienM::model()->findByPk($pasien_id);
    $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);
    $form = $this->renderPartial($this->pathView . '/_ringkasDataPasien', array(
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran,
    ), true);

    $data['form'] = $form;
    echo CJSON::encode($data);
  }

  /**
   * untuk load data pasien setelah di pilih no rekam medik
   */
  public function actionLoadDataPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data = RIInfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id' => $_POST['pendaftaran_id']));
      $masukkamar = MasukkamarT::model()->findByAttributes(array('pasienadmisi_id' => $data->pasienadmisi_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')));
      $pegawai_id = "";
      if (isset($masukkamar)) {
        if (!empty($masukkamar->pegawai_id)) {
          $pegawai_id = $masukkamar->pegawai_id;
        }
      }

      $post = null;

      if (isset($data)) {
        $criteriaTindakan = new CDbCriteria();
        $criteriaTindakan->select = "dokterpemeriksa1_id";
        $criteriaTindakan->group = "dokterpemeriksa1_id";
        $criteriaTindakan->addCondition('pendaftaran_id = ' . $data->pendaftaran_id);
        $tindakan = TindakanpelayananT::model()->findAll($criteriaTindakan);
        $dokterTindakan = array();

        if (count((array)$tindakan) > 0) {
          foreach ($tindakan as $dtTindakan) {
            if (!empty($dtTindakan->dokterpemeriksa1_id)) {
              $dokterTindakan[] = $dtTindakan->dokterpemeriksa1_id;
            }
          }
        }


        $post = array(
          'tgl_pendaftaran' => MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran),
          'no_pendaftaran' => $data->no_pendaftaran,
          'umur' => $data->umur,
          'jeniskasuspenyakit_nama' => $data->jeniskasuspenyakit_nama,
          'instalasi_nama' => $data->instalasi_nama,
          'ruangan_nama' => $data->ruangan_nama,
          'pendaftaran_id' => $data->pendaftaran_id,
          'pasien_id' => $data->pasien_id,
          'jeniskelamin' => $data->jeniskelamin,
          'statusperkawinan' => $data->statusperkawinan,
          'nama_pasien' => $data->nama_pasien,
          'nama_bin' => $data->nama_bin,
          'no_rekam_medik' => $data->no_rekam_medik,
          'dokter_nama' => $data->gelardepan . ' ' . $data->nama_pegawai . ' ' . $data->gelarbelakang_nama,
          'dokter_id' => $pegawai_id,
          'doktertindakan_id' => $dokterTindakan,
        );
      }

      echo CJSON::encode($post);
      Yii::app()->end();
    }
  }

  public function actionDaftarPasienTindakanRuangan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->join = "LEFT JOIN pembayaranpelayanan_t pp ON pp.pembayaranpelayanan_id = t.pembayaranpelayanan_id";
      //                    $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($_GET['term']), true);
      $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($_GET['term']), true);
      $criteria->addCondition('t.ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
      $criteria->addCondition(" t.statusperiksa in ('" . Params::STATUSPERIKSA_SUDAH_DIPERIKSA . "','" . Params::STATUSPERIKSA_SEDANG_DIRAWATINAP . "') ");
      //                    $criteria->addBetweenCondition("t.tgl_pendaftaran", date('Y-m-d').' 00:00:00', date('Y-m-d').' 23:59:59');
      $criteria->addCondition(" t.penjamin_id = '" . Params::PENJAMIN_ID_UMUM . "' "); //pembayaranpelayanan_id        
      $criteria->addCondition(" (LOWER(pp.statusbayar) ilike  '%" . Params::STATUSBAYAR_BELUM_LUNAS . "%') OR (t.pembayaranpelayanan_id IS NULL) ");
      $criteria->order = 't.tgl_pendaftaran DESC';
      $models = RIInfopasienmasukkamarV::model()->findAll($criteria);

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->nama_pasien;
          $returnVal[$i]['value'] = $model->no_pendaftaran;
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
