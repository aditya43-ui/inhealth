<?php

Yii::import('pendaftaranPenjadwalan.controllers.PendaftaranRawatJalanController');

class KonfirmasiBookingJanjiPoliController extends PendaftaranRawatJalanController
{
  public $path_view_booking = 'pendaftaranPenjadwalan.views.konfirmasiBookingJanjiPoli.';

  /**
   * Index transaksi pendaftaran
   * @param type $id
   * @param type $idSep
   * @param type $idAntrian
   * @param type $sk_id
   */
  public function actionIndex($id = null, $idSep = null, $idAntrian = null, $sk_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Konfirmasi Booking Janji Poli";
    $format = new MyFormatter();
    $model = new PPPendaftaranT;
    $modPasien = new PPPasienM;
    $modPegawai = new PPPegawaiM;
    $modPenanggungJawab = new PPPenanggungJawabM;
    $modRujukan = new PPRujukanT;
    $modRujukanBpjs = new PPRujukanbpjsT;
    $modTindakan = new PPTindakanPelayananT;
    $modPembayaran = new PPPembayaranpelayananT();
    $modAntrian = new PPAntrianT;
    $modAsuransiPasien = new PPAsuransipasienM;
    $modAsuransiPasienBpjs = new PPAsuransipasienbpjsM;
    $modAsuransiPasienBadak = new PPAsuransipasienbadakM();
    $modAsuransiPasienDepartemen = new PPAsuransipasiendepartemenM();
    $modAsuransiPasienPekerja = new PPAsuransipasienpegawaiM();
    $modSep = new PPSepT;
    $dataTindakans = array();
    $modKarcisV = array();
    $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
    //$modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
    //$modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
    //$modPasien->kelurahan_id = Yii::app()->user->getState('kelurahan_id');
    $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
    //$modPasien->agama = Params::DEFAULT_AGAMA;
    $model->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
    $model->is_bpjs = 0;
    $model->is_asubadak = 0;
    $model->is_asudepartemen = 0;
    $model->is_asupekerja = 0;

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

    $model->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;


    $modJanjipoli = new PPBuatJanjiPoliT();

    if (isset($_POST['buatjanjipoli_id'])) { //dari informasi janji poli
      if (!empty($_POST['buatjanjipoli_id'])) {
        $modJanjipoli = PPBuatJanjiPoliT::model()->findByPk($_POST['buatjanjipoli_id']);
        if (!empty($modJanjipoli->pasien_id)) {
          $modPasien = PPPasienM::model()->findByPk($modJanjipoli->pasien_id);
          $modPasien->tanggal_lahir = date('d/m/Y', strtotime($modPasien->tanggal_lahir));
          if ($modPasien->ispasienluar == TRUE) {
            $modPasien->no_rekam_medik = null;
            $modPasien->pasien_id = null;
          }
        }
        $model->no_urutantri = $modJanjipoli->no_antrianjanji;
        $model->buatjanjipoli_id = $_POST['buatjanjipoli_id'];
        if (!empty($modJanjipoli->ruangan_id))
          $model->ruangan_id = $modJanjipoli->ruangan_id;
        if (!empty($modJanjipoli->pegawai_id))
          $model->pegawai_id = $modJanjipoli->pegawai_id;
      }
    }

    //==load data

    if (!empty($idAntrian)) {
      $modAntrian = PPAntrianT::model()->findByPk($idAntrian, array(
        'condition' => 'pendaftaran_id is null',
      ));
      if (empty($modAntrian)) {
        $modAntrian = new PPAntrianT;
      } else {
        $model->antrian_id = $modAntrian->antrian_id;
      }
    }

    if (isset($id)) {
      $model = $this->loadModel($id);
      if (isset($idSep)) {
        $model->is_bpjs = 1;
        $modRujukanBpjs = PPRujukanbpjsT::model()->findByPk($model->rujukan_id);
        $modAsuransiPasienBpjs = PPAsuransipasienbpjsM::model()->findByPk($model->asuransipasien_id);
      }
      $modPasien = PPPasienM::model()->findByPk($model->pasien_id);

      if (!empty($model->penanggungjawab_id)) {
        $modPenanggungJawab = PPPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
      }
      if (!empty($model->rujukan_id)) {
        $modRujukan = PPRujukanT::model()->findByPk($model->rujukan_id);
      }
      $dataTindakans = PPTindakanPelayananT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id), "karcis_id is not null");
      $modAntrian->tglantrian = $format->formatDateTimeForUser($modAntrian->tglantrian);
    }

    if (isset($idSep)) {
      $modSep = PPSepT::model()->findByPk($idSep);
    }

    $pasien_id = (isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null);
    if (!empty($pasien_id)) {
      $modPasien = PPPasienM::model()->findByPk($pasien_id);
      $modPasien->tanggal_lahir = date('d/m/Y', strtotime($modPasien->tanggal_lahir));
    }
    if (!empty($modPasien->pegawai_id)) {
      $modPegawai->attributes = $modPasien->pegawai->attributes;
    }

    $ruangan = null;
    if (!empty($sk_id)) {
      $sk = SuratketeranganR::model()->findByPk($sk_id);
      $p = PendaftaranT::model()->findByPk($sk->pendaftaran_id);
      $ruangan = $p->ruangankontrol_id;

      if ($p->carabayar_id == Params::CARABAYAR_ID_BPJS) {
        $asuransi = PPAsuransipasienbpjsM::model()->findByPk($p->asuransipasien_id);
        if (empty($asuransi)) $asuransi = PPAsuransipasienbpjsM::model()->findByAttributes(array(
          'pasien_id' => $p->pasien_id,
          'carabayar_id' => $p->carabayar_id,
        ));
        if (!empty($asuransi)) {
          $rujuk = RujukandariM::model()->findByPk(Params::RUJUKANDARI_ID_ABE);
          $modAsuransiPasienBpjs->nopeserta = $asuransi->nopeserta;
          $modRujukanBpjs->asalrujukan_id = Params::ASALRUJUKAN_ID_RS;

          if (!empty($rujuk)) {
            $modRujukanBpjs->rujukandari_id = $rujuk->rujukandari_id;
            $modRujukanBpjs->nama_perujuk = $rujuk->namaperujuk;
            $modRujukanBpjs->tanggal_rujukan = date('Y-m-d H:i:s');
            $modRujukanBpjs->no_rujukan = date('dmYHi', strtotime($p->tglrenkontrol) + (3600 * 24 * 3));
            $modSep->ppkrujukan = $rujuk->ppkrujukan;

            // var_dump($modRujukanBpjs->attributes); die;
          }
        }
      }
    }

    if (isset($_POST['PPPendaftaranT'])) {

      // var_dump($_POST); die;
      $transaction = Yii::app()->db->beginTransaction();
      try {

        $modPasien = PasienM::model()->findByPk($_POST['PPPasienM']['pasien_id']);
        $this->pasientersimpan = true;

        $model = $this->simpanPendaftaran($model, $modPasien, $modRujukan, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $modAsuransiPasien);

        if (!empty($_POST['PPPendaftaranT']['buatjanjipoli_id'])) {
          $modJanjipoli = PPBuatJanjiPoliT::model()->findByPk($_POST['PPPendaftaranT']['buatjanjipoli_id']);
          $modJanjipoli->pendaftaran_id = $model->pendaftaran_id;
          $modJanjipoli->save();
        }

        if (!empty($sk_id)) { // untuk rencana kontrol pendaftaran
          $renKontrol = new PPBuatJanjiPoliT;
          $renKontrol->pegawai_id = $model->pegawai_id;
          $renKontrol->ruangan_id = $model->ruangan_id;
          $renKontrol->pasien_id = $model->pasien_id;
          $renKontrol->tglbuatjanji = $sk->create_time;
          $renKontrol->harijadwal = MyFormatter::getDayUser(date('w'));
          $renKontrol->tgljadwal = $p->tglrenkontrol;
          $renKontrol->keteranganbuatjanji = Params::KETERANGAN_BUAT_JANJI_RENKONTROL;
          $renKontrol->create_time = date('Y-m-d H:i:s');
          $renKontrol->create_loginpemakai_id = Yii::app()->user->id;
          $renKontrol->create_ruangan = Yii::app()->user->getState('ruangan_id');
          $renKontrol->no_antrianjanji = MyGenerator::noAntrianJanjiPoli($model->ruangan_id);
          $renKontrol->no_buatjanji = MyGenerator::noJanjiPoli("JP");
          $renKontrol->pendaftaran_id = $model->pendaftaran_id;
          $renKontrol->suratketerangan_id = $sk_id;

          $renKontrol->save();
        }

        $judul = 'Pendaftaran Pasien';

        if ($model->statuspasien == 'PENGUNJUNG LAMA') {
          $judul .= " Lama";
        } else $judul .= " Baru";

        $judul .= " Rawat Jalan";

        $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien;


        $cek = DokrekammedisM::model()->findByAttributes(array('pasien_id' => $model->pasien_id));

        if ($cek) {
          $link = $this->createUrl('/rekamMedis/PengirimanBerkasRekamMedis/Index', array(
            'RKDokumenpasienrmlamaV[no_pendaftaran]' => $model->no_pendaftaran,
            'RKDokumenpasienrmlamaV[no_rekam_medik]' => $model->pasien->no_rekam_medik,
            'RKDokumenpasienrmlamaV[tgl_rekam_medik]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'RKDokumenpasienrmlamaV[tgl_rekam_medik_akhir]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'RKDokumenpasienrmlamaV[nama_pasien]' => $model->pasien->nama_pasien
          ));
        } else {
          $link = $this->createUrl('/rekamMedis/PembuatanDokumenRK/Create', array(
            'pasien_id' => $model->pasien_id
          ));
        }

        $link_rj = $this->createUrl('/rawatJalan/DaftarPasien/Index', array(
          'RJInfokunjunganrjV[tgl_awal]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
          'RJInfokunjunganrjV[tgl_akhir]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
          'RJInfokunjunganrjV[no_pendaftaran]' => substr($model->no_pendaftaran, 2),
          'RJInfokunjunganrjV[nama_pasien]' => $model->pasien->nama_pasien,
          'RJInfokunjunganrjV[no_rekam_medik]' => $model->pasien->no_rekam_medik
        ));


        //var_dump($link_rj);die;

        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
          array('instalasi_id' => Params::INSTALASI_ID_RJ, 'ruangan_id' => $model->ruangan_id, 'modul_id' => 5,  'link_proses' => $link_rj), //, 'link_proses'=>$link_rj
          array('instalasi_id' => Params::INSTALASI_ID_FARMASI, 'ruangan_id' => Params::RUANGAN_ID_APOTEK_1, 'modul_id' => 10),
          // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
          array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_REKAM_MEDIS, 'modul_id' =>  Params::MODUL_ID_REKAMMEDIS, 'link_proses' => $link), //, 'link_proses' => $link
        ));


        // update janji poli
        if (isset($_POST['PPBuatJanjiPoliT']['buatjanjipoli_id']) && !empty($model->pendaftaran_id)) {
          PPBuatJanjiPoliT::model()->updateByPk($_POST['PPBuatJanjiPoliT']['buatjanjipoli_id'], array(
            'pendaftaran_id' => $model->pendaftaran_id,
          ));
        }


        //Di set di form >> Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan !");
        //                      RND-666 >>>  $this->redirect(array('view','id'=>$model->pendaftaran_id,'sukses'=>1));
        $smspasien = 1;
        $smsdokter = 1;
        $smspenanggungjawab = 1;

        if (Yii::app()->user->getState('issmsgateway')) {
          // SMS GATEWAY
          $modPegawai = $model->pegawai;
          $modRuangan = $model->ruangan;
          $sms = new Sms();
          $smspasien = 1;
          $smsdokter = 1;
          $smspenanggungjawab = 1;

          $model->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($model->tgl_pendaftaran);
          $model->no_urutantri = $model->ruangan->ruangan_singkatan . "-" . $model->no_urutantri;

          $modPegawai->nama_pegawai = $modPegawai->namaLengkap;



          foreach ($modSmsgateway as $i => $smsgateway) {

            if (isset($_POST['tujuansms']) && in_array($smsgateway->tujuansms, $_POST['tujuansms'])) {
              $isiPesan = $smsgateway->templatesms;
              $isiPesan = "${isiPesan}";

              $attributes = $modPasien->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modPegawai->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $model->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modRuangan->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($model->tgl_pendaftaran), $isiPesan);
              $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);
              $isiPesan = str_replace("\\n", hex2bin("0a"), $isiPesan);

              // var_dump($smsgateway->tujuansms);

              if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                if (!empty($modPasien->no_mobile_pasien)) {
                  $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                } else {
                  $smspasien = 0;
                }
              }
            }
          }
        }

        // die;
        // END SMS GATEWAY

        // var_dump($this->pendaftarantersimpan, $this->rujukantersimpan, $this->karcistersimpan, $this->komponentindakantersimpan, $this->asuransipasientersimpan);

        if ($this->pendaftarantersimpan) {
          $transaction->commit();
          if ($this->septersimpan) {
            $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'idSep' => $modSep->sep_id, 'sukses' => 1, 'smspasien' => $smspasien, 'smsdokter' => $smsdokter, 'smspenanggungjawab' => $smspenanggungjawab));
          } else {
            $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'sukses' => 1, 'smspasien' => $smspasien, 'smsdokter' => $smsdokter, 'smspenanggungjawab' => $smspenanggungjawab));
          }
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pasien gagal disimpan !");
          //                        echo "-".$this->pasientersimpan."<br>";
          //                        echo "-".$this->pendaftarantersimpan."<br>";
          //                        echo "-".$this->penanggungjawabtersimpan."<br>";
          //                        echo "-".$this->rujukantersimpan."<br>";
          //                        echo "-".$this->karcistersimpan."<br>";
          //                        echo "-".$this->komponentindakantersimpan."<br>";
          //                        exit;
        }
      } catch (Exception $exc) {
        //var_dump($exc->getMessage());die;
        $transaction->rollback();
        $btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
          . "<i class='icon-refresh icon-white'></i> Simpan Ulang"
          . "</a>";
        Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! " . $btn_ulang . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }


    $this->render('index', array(
      'model' => $model,
      'modJanjipoli' => $modJanjipoli,
      'modPasien' => $modPasien,
      'modPegawai' => $modPegawai,
      'modPenanggungJawab' => $modPenanggungJawab,
      'modRujukan' => $modRujukan,
      'modRujukanBpjs' => $modRujukanBpjs,
      'modTindakan' => $modTindakan,
      'modAntrian' => $modAntrian,
      'modAsuransiPasien' => $modAsuransiPasien,
      'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
      'modAsuransiPasienBadak' => $modAsuransiPasienBadak,
      'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja,
      'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen,
      'dataTindakans' => $dataTindakans,
      'modSep' => $modSep,
      'modSmsgateway' => $modSmsgateway,
      'modKarcisV' => $modKarcisV,
      'ruangan' => $ruangan,
    ));
  }


  /**
   * @author Deni Hamdani <denihamdani@piindonesia.co.id>
   * 
   * Sebelum dialog verifikasi dimunculkan maka dilakukan validasi Pasien, 
   * khususnya yang memiliki No KTP, dan Nama Ibu+Tgl. Lahir. Jika Nomor KTP
   * tidak ditemukan pada Pasien Lain, maka akan dilanjutkan dengan validasi
   * Nama Ibu+Tgl lahir
   */
  public function actionValidasiPasien()
  {
    $ok = 1;
    $msg = "";



    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    if (!isset($_POST['PPPasienM'])) {
      $msg = "Form Pasien belum Lengkap";
      Yii::app()->end();
    }



    if (isset($_POST['PPPasienM']['pasien_id']) && !empty($_POST['PPPasienM']['pasien_id']))
      goto prints;

    if (
      isset($_POST['PPPasienM']['no_identitas_pasien']) && !empty($_POST['PPPasienM']['no_identitas_pasien']) && $_POST['PPPasienM']['no_identitas_pasien'] != ''
    ) {
      // ktp
      $pasien = PasienM::model()->findByAttributes(array(
        'jenisidentitas' => 'KTP',
        'no_identitas_pasien' => $_POST['PPPasienM']['no_identitas_pasien'],
      ));


      /*
              if (!empty($pasien)) {
              $ok = 0;
              $msg = "KTP dengan Nomor " . $pasien->no_identitas_pasien . " sudah terdaftar atas Nama " . $pasien->nama_pasien . " - " . $pasien->no_rekam_medik;

              goto prints;
              }
             * 
             */
    }

    $pasien = PasienM::model()->findByAttributes(array(
      'tanggal_lahir' => MyFormatter::formatDateTimeForDb($_POST['PPPasienM']['tanggal_lahir']),
      'nama_ibu' => $_POST['PPPasienM']['nama_ibu'],
    ));

    if (!empty($pasien)) {
      $ok = 0;
      $msg = "Pasien ber tanggal lahir " . date('d/m/Y', strtotime($pasien->tanggal_lahir)) .
        " beserta Ibu bernama " . $pasien->nama_ibu .
        " sudah terdaftar atas Nama " . $pasien->nama_pasien . " - " . $pasien->no_rekam_medik;

      goto prints;
    }


    prints:
    echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
  }

  /**
   * Mengurai data pasien berdasarkan pasien_id
   * @throws CHttpException
   */
  public function actionGetDataPasienJanjiPoli()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $no_buatjanji = isset($_POST['no_buatjanji']) ? $_POST['no_buatjanji'] : null;

      $janjiPoli = BuatjanjipoliT::model()->findByAttributes(array(
        'no_buatjanji' => $no_buatjanji,
      ), array(
        'condition' => 'pendaftaran_id is null',
      ));


      if (!empty($janjiPoli->pasien_id)) {
        $pasien_id = $janjiPoli->pasien_id;
      }


      $returnVal = array();

      /*
            if (!empty($pasien_id)) {
                $pendaftaran = PendaftaranT::model()->findByAttributes(array(
                    'pasien_id'=>$pasien_id,
                ), array(
                    'condition'=>"pasienbatalperiksa_id is null "
                    . "and pembayaranpelayanan_id is null"
                ));
            } else {
                $pendaftaran = null;
            }
             * 
             */

      $returnVal['lebih'] = false;
      $returnVal['adaDaftar'] = false;

      /*
            $pp = null;
            if (!empty($pendaftaran)) {
                $returnVal['listDaftar'] = $pendaftaran->attributes;
                $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien;
                $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan;
                $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi;

                $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
                $pp = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);

                if (!empty($admisi)) {								
                    $this->periksaValidasiPasienRI($pendaftaran, $admisi, $pp, $returnVal);
                } else {
                    //var_dump($pendaftaran->attributes);die;
                    switch ($pendaftaran->instalasi_id) {
                        case Params::INSTALASI_ID_RJ:
                            $this->periksaValidasiPasienRJ($pendaftaran, $admisi, $pp, $returnVal); break;
                        case Params::INSTALASI_ID_RD:
                            $this->periksaValidasiPasienRD($pendaftaran, $admisi, $pp, $returnVal); break;
                        case Params::INSTALASI_ID_RI:
                            $this->periksaValidasiPasienRI($pendaftaran, $admisi, $pp, $returnVal); break;
                        default:
                            $this->periksaValidasiPasienPenunjang($pendaftaran, $admisi, $pp, $returnVal); break;
                    }
                }
                //die;
            }
             * 
             */

      // $returnVal['listDaftar']['pasien']['fingerprint_data'] = null;


      $criteria = new CDbCriteria();
      if (!empty($pasien_id)) {
        $criteria->addCondition("pasien_id = " . $pasien_id);
      }
      $criteria->addCondition('ispasienluar = FALSE');
      $model = PasienM::model()->find($criteria);
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["fingerprint_data"] = null;
      $returnVal["tanggal_lahir"] = date("d/m/Y", strtotime($model->tanggal_lahir));
      if (!empty($janjiPoli)) {
        $returnVal["data_janjipoli"] = $janjiPoli->attributes;
        $returnVal["data_janjipoli"]["carabayar_id"] = null;
        if (!empty($janjiPoli->penjamin_id)) {
          $penjamin = PenjaminpasienM::model()->findByPk($janjiPoli->penjamin_id);
          $returnVal["data_janjipoli"]["carabayar_id"] = $penjamin->carabayar_id;
        }
      }
      if (!empty($model->pegawai_id)) {
        $returnVal['nomorindukpegawai'] = $model->pegawai->nomorindukpegawai;
        $returnVal['nama_pegawai'] = $model->pegawai->nama_pegawai;
        $returnVal['gelardepan'] = $model->pegawai->gelardepan;
        $returnVal['unit_perusahaan'] = $model->pegawai->unit_perusahaan;
        $returnVal['gelarbelakang_nama'] = isset($model->pegawai->gelarbelakang->gelarbelakang_nama) ? $model->pegawai->gelarbelakang->gelarbelakang_nama : "";
        $returnVal['jabatan_nama'] = isset($model->pegawai->jabatan->jabatan_nama) ? $model->pegawai->jabatan->jabatan_nama : "";
        $returnVal["nomorindukpegawai"] = $model->pegawai->nomorindukpegawai;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
