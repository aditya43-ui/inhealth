<?php
//Yii::import('rawatJalan.controllers.KonsulPoliController');
//Yii::import('rawatJalan.models.*');
//class KonsulPoliTRIController extends KonsulPoliController
//{
//        
//}
Yii::import('pendaftaranPenjadwalan.models.*');
class KonsulPoliTRIController extends MyAuthController
{


  protected $path_view = 'rawatInap.views.konsulPoliTRI.';

  public function actionIndex($pendaftaran_id, $pasienadmisi_id)
  {
    $this->layout = '//layouts/iframe';
    $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id)) : array();
    $modPendaftaran = RIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $karcisTindakan = DaftartindakanM::model()->findAllByAttributes(array('daftartindakan_karcis' => true));

    $modKonsul = new RIKonsulPoliT;
    $modPegawai = new PPPegawaiM;
    $modelPendaftaran = new RIPendaftaranT;
    $modAsuransiPasienBadak = new PPAsuransipasienbadakM();
    $modAsuransiPasienDepartemen = new PPAsuransipasiendepartemenM();
    $modAsuransiPasienPekerja = new PPAsuransipasienpegawaiM();
    $modAsuransiPasien = new LBAsuransipasienM;


    $modKonsul->pasien_id = $modPendaftaran->pasien_id;
    $modKonsul->pendaftaran_id = $pendaftaran_id;
    $modKonsul->pegawai_id = $modAdmisi->pegawai_id;
    $modKonsul->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
    $modKonsul->asalpoliklinikkonsul_id = Yii::app()->user->getState('ruangan_id');
    $modKonsul->pasienadmisi_id = $_GET['pasienadmisi_id'];
    $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modAdmisi->penjamin_id);

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

    if (isset($_GET['idPasienKirimKeUnitLain'])) {
      $modKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findByPk($_GET['idPasienKirimKeUnitLain']);
      $modPasien = $modKirimKeUnitLain->pasien;
    }

    if (isset($_POST['RIKonsulPoliT'])) {
      $modKonsul->attributes = $_POST['RIKonsulPoliT'];

      $modKonsul->no_antriankonsul = MyGenerator::noAntrianPPKonsul($_POST['RIKonsulPoliT']['ruangan_id']); //fungsi diganti karena no antrian duplikat ketika ada konsul poli ke ruangan.
      if ($_POST['RIKonsulPoliT']['ruangan_id'] != Params::RUANGAN_ID_HEMODIALISA) {
        $modKonsul->jenisdialisat_id = null;
        $modKonsul->penarikan_cairan = null;
        $modKonsul->lama_hd = null;
        $modKonsul->jenistransfusi_id = null;
        $modKonsul->aksesvaskular_id = null;
      }

      $modKonsul->jenisdialisat_id = $modKonsul->jenisdialisat_id == "" ? null : $modKonsul->jenisdialisat_id;
      $modKonsul->penarikan_cairan =  $modKonsul->penarikan_cairan == "" ? null : $modKonsul->penarikan_cairan;
      $modKonsul->lama_hd =  $modKonsul->lama_hd == "" ? null : $modKonsul->lama_hd;
      $modKonsul->jenistransfusi_id = $modKonsul->jenistransfusi_id == "" ? null : $modKonsul->jenistransfusi_id;
      $modKonsul->aksesvaskular_id = $modKonsul->aksesvaskular_id == "" ? null : $modKonsul->aksesvaskular_id;

      if ($modKonsul->validate()) {
        if ($modKonsul->save()) {
          /* ================================================ */
          /* Penambahan Tarif Konsul Poli EHS-188             */
          /* ================================================ */
          // $modTindakanPelayanan =  New TindakanpelayananT;
          // $modTindakanPelayanan->konsulpoli_id = $modKonsul->konsulpoli_id;
          // $modTindakanPelayanan->pasien_id = $modPendaftaran->pasien_id;
          // $modTindakanPelayanan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
          // $modTindakanPelayanan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
          // $modTindakanPelayanan->shift_id     = $modPendaftaran->shift_id;
          // $modTindakanPelayanan->carabayar_id = $modPendaftaran->carabayar_id;
          // $modTindakanPelayanan->penjamin_id = $modPendaftaran->penjamin_id;
          // $modTindakanPelayanan->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
          // $modTindakanPelayanan->ruangan_id   = $modKonsul->ruangan_id;
          // $modTindakanPelayanan->instalasi_id = $modTindakanPelayanan->ruangan->instalasi_id;
          // $modTindakanPelayanan->cyto_tindakan=0;
          // $modTindakanPelayanan->tarifcyto_tindakan = 0;
          // $modTindakanPelayanan->discount_tindakan = 0;
          // $modTindakanPelayanan->subsidiasuransi_tindakan = 0;
          // $modTindakanPelayanan->subsidipemerintah_tindakan = 0;
          // $modTindakanPelayanan->subsisidirumahsakit_tindakan = 0;
          // $modTindakanPelayanan->iurbiaya_tindakan = 0;
          // $modTindakanPelayanan->create_loginpemakai_id = Yii::app()->user->id;
          // $modTindakanPelayanan->create_ruangan = $modKonsul->ruangan_id;
          // $modTindakanPelayanan->create_time =  date( 'Y-m-d H:i:s');
          // $modTindakanPelayanan->satuantindakan = "Hari";

          // $modTindakanPelayanan->daftartindakan_id = Params::DAFTARTINDAKAN_ID_KONSUL;
          // $modTindakanPelayanan->tgl_tindakan = date( 'Y-m-d H:i:s');
          // $modTindakanPelayanan->tarif_satuan = $modTindakanPelayanan->getTarifSatuan(); //RND-7250
          // $modTindakanPelayanan->tarif_tindakan = $modTindakanPelayanan->qty_tindakan * $modTindakanPelayanan->tarif_satuan;
          // $modTindakanPelayanan->pasienadmisi_id = $_GET['pasienadmisi_id'];
          // if($modTindakanPelayanan->validate()){
          //     if($modTindakanPelayanan->save()){
          //         $valid = true;
          //         $modTindakanPelayanan->saveTindakanKomponen();
          //     }
          // }
          /* ================================================ */


          $judul = 'Pasien Konsul Poli';

          $isi = 'Pasien ' . $modPasien->nama_pasien . ' dengan nomor rekam medik ' . $modPasien->no_rekam_medik . ' telah dikonsul ke ' . $modKonsul->politujuan->ruangan_nama . ' pada ' . $modKonsul->tglkonsulpoli . ' dari ' . $modKonsul->poliasal->ruangan_nama . " (Rawat Inap)";

          $ruangan = RuanganM::model()->findByPk($modKonsul->ruangan_id);



          $ok = CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id),
          ));



          // SMS GATEWAY
          $modPegawai = $modPendaftaran->pegawai;
          $modRuangan = $modKonsul->politujuan;
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
            $attributes = $modPegawai->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modKonsul->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modRuangan->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modKonsul->tglkonsulpoli), $isiPesan);

            if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
              if (!empty($modPasien->no_mobile_pasien)) {
                $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
              } else {
                $smspasien = 0;
              }
            }
          }


          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'idKonsulPoli' => $modKonsul->konsulpoli_id, 'smspasien' => $smspasien));
        }
      }
    }



    $modRiwayatKonsul = RIKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $modBayarUangMuka = RIBayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $total = 0;
    foreach ($modBayarUangMuka as $key => $value) {
      $total += $modBayarUangMuka[$key]->jumlahuangmuka;
    }
    $modDeposit = (($modBayarUangMuka) ? $total : null);

    $this->render('index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPegawai' => $modPegawai,
      'modKonsul' => $modKonsul,
      'karcisTindakan' => $karcisTindakan,
      'modRiwayatKonsul' => $modRiwayatKonsul,
      'modAdmisi' => $modAdmisi,
      'modelPendaftaran' => $modelPendaftaran,
      'modJenisTarif' => $modJenisTarif,
      'modDeposit' => $modDeposit,
      'modAsuransiPasienBadak' => $modAsuransiPasienBadak,
      'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja,
      'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen,
    ));
  }


  public function actionSetDropdownPenjaminPasien($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($carabayar_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array(
            'carabayar_id'   => $carabayar_id,
            'penjamin_aktif' => true
          ), array('order' => 'penjamin_nama ASC'));
          if (count((array)$penjamin) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
          foreach ($penjamin as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }



  
  public function actionSetKarcis()
  {
      if (Yii::app()->request->isAjaxRequest) {

          $konfig = KonfigsystemK::model()->find();

          $format = new MyFormatter();
          $modTindakan = new RITindakanPelayananT;
         // $kelaspelayanan_id = $_POST['kelaspelayanan_id'];
        //  $ruangan_id = $_POST['ruangan_id'];
          $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
          $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : "";
        //  $penjamin_id = $_POST['penjamin_id'];
          $form = '';

          $is_pasienbaru = 'true';
          if (!empty($ruangan_id)) {
              if (!empty($pasien_id)) {
                  $modP = PendaftaranT::model()->findByAttributes(array(
                      'pasien_id' => $pasien_id,
                  ), array(
                      'condition' => 'pasienbatalperiksa_id is null',
                  ));
                  $modPasien = PasienM::model()->findByPk($pasien_id);
                  if (isset($modPasien)) {
                      $is_pasienbaru = ($modPasien->statusrekammedis == Params::STATUSREKAMMEDIS_AKTIF && !empty($modP)) ? 'false' : 'true';
                  }
              } else if (trim($no_rekam_medik) != "") {
                  $is_pasienbaru = 'false';
              }
              $criteria = new CdbCriteria();
           //   $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
            //  $criteria->addCondition("ruangan_id = " . $ruangan_id);
            //  $criteria->addCondition("penjamin_id = " . $penjamin_id);
              $modKarcisAll = KarcisV::model()->findAll($criteria);

              if (Yii::app()->user->getState('karcisbarulama')) { //RND-7737
                  $criteria->addCondition("pasienbaru_karcis = $is_pasienbaru");
              }

              $modKarcisV = KarcisV::model()->findAll($criteria);

              // susun karcis global
              $modKarcisFinal = array();
              $modKarcisAda = array();
              foreach ($modKarcisAll as $item) {
                  if (empty($modKarcisAda[$item->daftartindakan_id])) {
                      $modKarcisAda[$item->daftartindakan_id] = 1;
                      $modKarcisFinal[] = $item;
                  }
              }


              $form = $this->renderPartial('_formKarcis', array('modKarcisAll' => $modKarcisFinal, 'modKarcisV' => $modKarcisV, 'modTindakan' => $modTindakan, 'format' => $format), true);
              $data['listKarcis'] = $form;
              echo json_encode($data);
              Yii::app()->end();
          }
          $data['listKarcis'] = $form;
          echo json_encode($data);
          Yii::app()->end();
      }
  }





  public function actionAjaxDetailKonsul()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idKonsulAntarPoli = $_POST['idKonsulAntarPoli'];
      $modKonsulPoli = RIKonsulPoliT::model()->findByPk($idKonsulAntarPoli);
      $data['result'] = $this->renderPartial('_viewKonsulPoli', array('modKonsul' => $modKonsulPoli), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * Detail hasil jawaban konsul poli dengan fungsi ajax
   */
  public function actionAjaxDetailKonsulHasil()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idKonsulAntarPoli = $_POST['idKonsulAntarPoli'];
      $modKonsulPoli = RIKonsulPoliT::model()->findByPk($idKonsulAntarPoli);
      $modMorbiditas = RIPasienMorbiditasT::model()->findAllByAttributes(array(
        'pendaftaran_id' => $modKonsulPoli->pendaftaran_id,
        'ruangan_id' => $modKonsulPoli->ruangan_id,
      ));
      if (!empty($modKonsulPoli->pegawaikonsul_id)) {
        $modKonsulPoli->nama_pegawai = PegawaiM::model()->findByPk($modKonsulPoli->pegawaikonsul_id)->nama_pegawai;
      }

      $data['result'] = $this->renderPartial('_viewKonsulPoliHasil', array('modKonsul' => $modKonsulPoli, 'modMorbiditas' => $modMorbiditas), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionAjaxBatalKonsul()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idKonsulAntarPoli = $_POST['idKonsulAntarPoli'];
      $pendaftaran_id = $_POST['pendaftaran_id'];

      $tindakanpelayanan = RITindakanPelayananT::model()->findByAttributes(array('konsulpoli_id' => $idKonsulAntarPoli));
      if (!empty($tindakanpelayanan)) {
        TindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $tindakanpelayanan->tindakanpelayanan_id));
        RITindakanPelayananT::model()->deleteByPk($tindakanpelayanan->tindakanpelayanan_id);
      }


      RIKonsulPoliT::model()->deleteByPk($idKonsulAntarPoli);
      $modRiwayatKonsul = RIKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

      $data['result'] = $this->renderPartial('_listKonsulPoli', array('modRiwayatKonsul' => $modRiwayatKonsul), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * ajax untuk menampilkan tarif tindakan konsultasi poliklinik
   */
  public function actionAjaxSetTarif()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $penjamin_id = (isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null);
      $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
      $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
      $ruangan = RuanganM::model()->findByPk($ruangan_id);
      $ruangan_nama = $ruangan->ruangan_nama;
      $jenistarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $penjamin_id)->jenistarif_id;

      $criteria = new CDbCriteria();
      $criteria->addCondition('t.komponentarif_id =' . Params::KOMPONENTARIF_ID_TOTAL);
      $criteria->addCondition('daftartindakan_id = ' . Params::DAFTARTINDAKAN_ID_KONSUL);
      // $criteria->join = "join daftartindakan_m d on d.daftartindakan_id = t.daftartindakan_id";
      $criteria->addCondition("d.daftartindakan_konsul = true and d.daftartindakan_karcis = true");
      //$criteria->addCondition('daftartindakan_id = '.Params::DAFTARTINDAKAN_ID_KONSUL);
      if (!empty($kelaspelayanan_id)) {
        $criteria->addCondition("t.kelaspelayanan_id = " . $kelaspelayanan_id);
      }
      if (!empty($jenistarif)) {
        $criteria->addCondition("t.jenistarif_id = " . $jenistarif);
      }
      $model = TariftindakanM::model()->findAll($criteria);

      $data['result'] = $this->renderPartial('_listTarifKonsul', array('model' => $model, 'ruangan_nama' => $ruangan_nama), true);
      $data['dokter'] = $this->loadDokterRuangan($ruangan_id);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionSetAsuransiBadak()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data = array();
      if ((!empty($_POST['pasien_id'])) && (!empty($_POST['penjamin_id']))) {
        $criteria = new CDbCriteria();
        $criteria->addCondition("pasien_id = " . $_POST['pasien_id']);
        $criteria->addCondition("penjamin_id = " . $_POST['penjamin_id']);
        $criteria->order = 'asuransipasien_id DESC';
        $model = AsuransipasienM::model()->find($criteria);
        if (!empty($model)) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $data["$attribute"] = $model->$attribute;
          }
          $data['listPenjamin'] = "";
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $model->carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
          if (count((array)$penjamin) > 1) {
            $data['listPenjamin'] .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
          foreach ($penjamin as $value => $name) {
            $data['listPenjamin'] .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        } else {
          $data = null;
          $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : '';
          if (!empty($pegawai_id)) {
            $modPegawai = PegawaiM::model()->findByPk($pegawai_id);
            $data['nopeserta'] = $modPegawai->nomorindukpegawai;
            $data['namaperusahaan'] = $modPegawai->unit_perusahaan;
            $data['namapemilikasuransi'] = $modPegawai->nama_pegawai;
            $data['namaperusahaan'] = 'PT. Badak LNG';
          }
        }
      } else {
        $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : '';
        if (!empty($pegawai_id)) {
          $modPegawai = PegawaiM::model()->findByPk($pegawai_id);
          $data['nopeserta'] = $modPegawai->nomorindukpegawai;
          $data['namaperusahaan'] = $modPegawai->unit_perusahaan;
          $data['namapemilikasuransi'] = $modPegawai->nama_pegawai;
          $data['namaperusahaan'] = 'PT. Badak LNG';
        }
      }
      echo CJSON::encode($data);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  public function actionAjaxSetTarif2()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $penjamin_id = (isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null);
      $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
      $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
      $ruangan = RuanganM::model()->findByPk($ruangan_id);
      $ruangan_nama = $ruangan->ruangan_nama;
      $jenistarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $penjamin_id)->jenistarif_id;

      $criteria = new CDbCriteria();
      $criteria->addCondition('t.komponentarif_id =' . Params::KOMPONENTARIF_ID_TOTAL);
      $criteria->addCondition('d.daftartindakan_konsul = true and d.daftartindakan_karcis = true');
      $criteria->join = "join daftartindakan_m d on t.daftartindakan_id = d.daftartindakan_id";



      if (!empty($kelaspelayanan_id)) {
        $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
      }
      if (!empty($jenistarif)) {
        $criteria->addCondition("jenistarif_id = " . $jenistarif);
      }
      // var_dump($criteria); die;
      $model = TariftindakanM::model()->findAll($criteria);

      $data['result'] = $this->renderPartial($this->path_view . '_listTarifKonsul', array('model' => $model, 'ruangan_nama' => $ruangan_nama), true);
      $data['dokter'] = $this->loadDokterRuangan($ruangan_id);


      echo json_encode($data);
      Yii::app()->end();
    }
  }


  protected function loadDokterRuangan($ruangan_id)
  {
    $dokter = DokterV::model()->findAllByAttributes(array(
      'pegawai_aktif' => true,
      'ruangan_id' => $ruangan_id,
    ));
    $dat = CHtml::listData($dokter, 'pegawai_id', 'namaLengkap');
    $str = count((array)$dat) > 1 ? '<option value="">-- Pilih --</option>' : '';
    foreach ($dat as $val => $item) {
      $str .= '<option value="' . $val . '">' . $item . '</option>';
    }

    return $str;
  }


  /**
   * Print konsul poli dari RI
   */
  public function actionPrint()
  {
    $modKonsul = new RIKonsulPoliT;
    $pendaftaran_id = (isset($_GET['id']) ? $_GET['id'] : null);
    $konsulpoli_id = (isset($_GET['idKonsulPoli']) ? $_GET['idKonsulPoli'] : null);
    $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);

    //            $modKonsulPoli = RJKonsulPoliT::model()->findByPk($idKonsulAntarPoli);
    $modRiwayatKonsul = RIKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'konsulpoli_id' => $konsulpoli_id));

    $judulLaporan = 'Permintaan Konsultasi Poliklinik';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  /**
   * Print riwayat konsul
   */
  public function actionPrintRiwayat()
  {
    $modKonsul = new RIKonsulPoliT;
    $pendaftaran_id = (isset($_GET['id']) ? $_GET['id'] : null);
    $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);
    $modRiwayatKonsul = RIKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $judulLaporan = 'Permintaan Konsultasi Poliklinik';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('printRiwayat', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('printRiwayat', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('printRiwayat', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
